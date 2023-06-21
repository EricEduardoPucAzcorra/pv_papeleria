<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Deudor;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
//librerias de tickets
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

class Cuenta extends Component
{

    public $cantidad, $cambio, $total;

    //Variables para almacenar los datos de la venta
    public $estado, $deuda_id, $nombreDeudor, $apellidoDeudor, $sobrenombreDeudor, $telefonoDeudor, $notasDeudor;

    protected $listeners = ['calcular' => 'calcularTotal', 'imprime-ticket'=>'imprimirTicket'];

    //valores para el modal
    public $selected_id = -1;
    public $operationName = 'Ventas';

    public function render()
    {
        $deudas = Deudor::all();
        return view('livewire.ventas.cuenta', \compact('deudas'));
    }

    public function mount()
    {
        $this->total = 0;
        $this->cambio = 0;
        $this->deuda_id = -1;;
        $this->estado = 'COMPLETADO';

        $this->calcularTotal();
    }

    public function resetUI()
    {
        $this->resetErrorBag();
    }

    public function calcularTotal()
    {
        $productos = session('carrito');

        if ($productos) {
            //Calcular el total del carrito
            $this->total = \array_sum(\array_column($productos, 'total'));
        } else {
            $this->total = 0;
        }
    }

    public function getCalcularCambioProperty()
    {
        if (!is_numeric($this->cantidad)) {
            $this->cantidad = 0;
        }

        $this->cambio =  $this->cantidad - $this->total;

        if ($this->cambio < 0) {
            $this->cambio = 0;
        }

        return $this->cambio;
    }

    public function getItemsProperty()
    {
        $productos = session('carrito');

        $items = 0;

        if ($productos) {
            foreach ($productos as $producto) {
                $items += $producto->cantidad;
            }
        }

        return $items;
    }

    //Funciona para recuperar una deuda anterior facilmente
    public function updated($campo, $valor)
    {
        if ($campo == 'deuda_id') {
            if ($valor != -1) {
                $this->actualizarDeudor($valor);
            } else {
                $this->nombreDeudor = '';
                $this->apellidoDeudor = '';
                $this->sobrenombreDeudor = '';
                $this->telefonoDeudor = '';
                $this->notasDeudor = '';
            }
        }
    }

    public function actualizarDeudor($clave)
    {
        $deudor = Deudor::find($clave);

        if ($deudor) {
            $this->nombreDeudor = $deudor->nombre;
            $this->apellidoDeudor = $deudor->apellido;
            $this->sobrenombreDeudor = $deudor->sobrenombre;
            $this->telefonoDeudor = $deudor->telefono;
            $this->notasDeudor = $deudor->notas;
        }
    }

    public function store()
    {
        if ($this->cantidad < $this->total) {
            $this->emit('modal-opciones', 'hide');
            $this->emit('mostrar-alerta', 'La cantidad ingresada es menor al total de la venta');
            return;
        }
        $this->validate([
            'cantidad' => 'required|numeric',
            'cambio' => 'required|numeric',
            'estado' => 'required',
        ]);

        DB::beginTransaction();

        try {

            if ($this->estado == 'PENDIENTE') {

                $this->validate([
                    'nombreDeudor' => 'required',
                    'apellidoDeudor' => 'required',
                ]);

                if ($this->deuda_id == -1) {
                    //Crear al deudor
                    $deudor = Deudor::create([
                        'nombre' => $this->nombreDeudor,
                        'apellido' => $this->apellidoDeudor,
                        'sobrenombre' => $this->sobrenombreDeudor,
                        'telefono' => $this->telefonoDeudor,
                        'notas' => $this->notasDeudor,
                    ]);
                } else {
                    $deudor = Deudor::find($this->deuda_id);
                }

                //Crear la venta
                $venta = Venta::create([
                    'total' => $this->total,
                    'items' => $this->items,
                    'estatus' => $this->estado,
                    'pago' => $this->cantidad,
                    'cambio' => $this->cambio,
                    'deudor_id' => $deudor->id,
                    'user_id' => auth()->user()->id,
                ]);
            } else {
                //Crear la venta
                $venta = Venta::create([
                    'total' => $this->total,
                    'items' => $this->items,
                    'estatus' => $this->estado,
                    'pago' => $this->cantidad,
                    'cambio' => $this->cambio,
                    'user_id' => auth()->user()->id,
                ]);

            }

            //reducir el stock de los productos
            $productos = session('carrito');

            if ($productos) {
                foreach ($productos as $producto) {
                    $inventario = Producto::where('sku', $producto->sku)->first();
                    if ($inventario) {
                        $inventario->stock = $inventario->stock - $producto->cantidad;
                        $inventario->save();
                    }
                }
            }

            //Agregar a la tabla pivote
            $productos = session('carrito');

            if ($productos) {
                foreach ($productos as $producto) {
                    $venta->productos()->attach($producto->id, [
                        'cantidad' => $producto->cantidad,
                        'precio' => $producto->precio,
                    ]);
                }
            }

            //Eliminar el carrito
            $this->emit('limpiar');
            //Cerrar el modal
            $this->emit('modal-operaciones', 'hide');

            $this->emit('imprimir', $venta, $productos);
            //imprime ticket

            //$this->imprimirTicket($venta, $productos);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('mostrar-alerta', $e->getMessage());
        }


    }

    public function imprimirTicket($datos, $productos){
        //lgica de ticket
        //dd($datos);
      // dd($productos);

        $nombre_impresora = "POS-80C";

        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);

        # Vamos a alinear al centro lo próximo que imprimamos
        $printer->setJustification(Printer::JUSTIFY_CENTER);

        //logo de la empresa
        // try{
        //     $logo = EscposImage::load("dist/img/Papelería.png", false);
        //     $printer->bitImage($logo);
        // }catch(Exception $e){/*No hacemos nada si hay error*/}

        $printer->setTextSize(2, 2);
        //dts de la empresa
        $printer->text("Papería Jordana\n");
        $printer->setTextSize(1,1);
        $printer->text("Tel: 9992669174\n");
        $printer->text("Dirección: C 6 #31B X 11 Y 13\n");
        #La fecha también
        $printer->text(date("Y-m-d H:i:s") . "\n");

        $printer->text("Productos\n");

        $printer->text("-------------------\n");

        # Para mostrar el total
        $total = 0;

        foreach ($productos as $producto) {
            //$total += $producto->cantidad * $producto->precio;

            /*Alinear a la izquierda para la cantidad y el nombre*/
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($producto['cantidad'] . "x" . $producto['nombre'] . "\n");

            /*Y a la derecha para el importe*/
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text(' $' . $producto['precio'] . "\n");
        }

        /*
            Terminamos de imprimir
            los productos, ahora va el total
        */
        $printer->text("--------\n");
        $printer->text("TOTAL: $". $total ."\n");
        $printer->text("Pago: $". $datos['pago'] . "\n");
        $printer->text("Cambio: $". $datos['cambio'] . "\n");
        /*
            Podemos poner también un pie de página
        */
        $printer->text("Muchas gracias por su compra\n SPV-PJ");



        /*Alimentamos el papel 3 veces*/
        $printer->feed(3);


        $printer->cut();

        /*
            Por medio de la impresora mandamos un pulso.
            Esto es útil cuando la tenemos conectada
            por ejemplo a un cajón
        */
        $printer->pulse();

        /*
            Para imprimir realmente, tenemos que "cerrar"
            la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
        */
        $printer->close();


    }


}
