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

class Cuenta extends Component
{
    public $cantidad, $cambio, $total;

    //Variables para almacenar los datos de la venta
    public $estado, $deuda_id, $nombreDeudor, $apellidoDeudor, $sobrenombreDeudor, $telefonoDeudor, $notasDeudor;

    protected $listeners = ['calcular' => 'calcularTotal'];

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

            //imprime ticket
            $this->imprimirTicket($venta, $productos);

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

        $nombreImpresora = "POS-80C";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(2, 2);
        $impresora->text("Papería Jordana\n");
        $impresora->setTextSize(1,1);
        $impresora->text("9992669174\n");
        $impresora->text("Dirección:C 6 #31B X 11 Y 13\n");
        //$impresora->text("\n");
        $impresora->text("Productos" . $productos);
        $impresora->setTextSize(1, 1);
        $impresora->text("CANT\n");
        $impresora->text("DESCRIPCIÓN\n");
        $impresora->text("PRECIO\n");
        $impresora->setTextSize(1, 1);
        $impresora->text("https://parzibyte.me");
        $impresora->feed(5);
        $impresora->close();



    }

    public function pruebaticket(){

    }
}
