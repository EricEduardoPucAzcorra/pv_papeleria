<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Producto;
use Illuminate\Support\Str;
use Livewire\Component;

class Ventas extends Component
{
    /**
     * Componente que funcionara como carrito de compras
     * para agregar productos a la venta
     * 
     * El carrito esta diseñado desde cero
     * 
     */

     protected $listeners = ['agregar' => 'agregarProducto', 'limpiar' => 'vaciarCarrito'];

     public $buscar;

    public $listaProductos;

    public function mount()
    {
        $this->listaProductos = session('carrito') ?? [];
        
    }
 
    public function render()
    {

        $productos = $this->obtenerProductos();

        if ($this->buscar) {
            $buscarProducto = Producto::where('nombre', 'like', '%' . $this->buscar . '%')
                                    ->orWhere('sku', 'like', '%' . $this->buscar . '%')                           
                                    ->get();
        } else {
            $buscarProducto = [];
        }

        return view('livewire.ventas.ventas', \compact('productos', 'buscarProducto'));
    }

    //Obtener la clave del producto
    public function obtenerClave($llave)
    {
        $productos = $this->obtenerProductos();

       if ($productos != []) {

           foreach ($productos as $clave => $producto) {
               if ($producto->sku == $llave) {
                   return $clave;
               }
           }
       } 

       return -1;
    }

    //Obtener la lista de los productos del carrito
    public function obtenerProductos()
    {
        $productos = \session('carrito');

        if (!$productos) {
            return [];
        } else {
            return $productos;
        }
    }

    //Agregar productos al carrito
    public function agregarProducto($sku)
    {
        $this->buscar = '';

        $llave = $this->obtenerClave($sku);
        
        $productos = $this->obtenerProductos();

        if ($llave == -1) {
            $producto = Producto::where('sku', $sku)->first();


            //Validar que exista el producto
            if ($producto) {
                if ($producto->stock <= 0) {
                    $this->emit('mostrar-alerta', 'No hay stock disponible');
                    return;
                }
                $articulo = (object) [
                    'id' => $producto->id,
                    'sku' => $producto->sku,
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precio,
                    'cantidad' => 1,
                    'total' => $producto->precio,
                ];

                //Agregar el producto al carrito
                $productos[] = $articulo;
                \session(['carrito' => $productos]);
                //Actualizar la lista de productos
                $this->listaProductos = session('carrito');
                //Mostrar mensaje de exito
                $this->emit('mostrar-alerta', 'PRODUCTO AGREGADO');
            } else {
                $this->listaProductos = session('carrito');
                //Si no existe
                $this->emit('mostrar-alerta', 'EL PRODUCTO NO EXISTE');
                return;
            }
        } else {
            $this->aumentarItem($sku);
        }

        $this->emit('calcular');

    }

    //
    public function aumentarItem($sku)
    {

        $clave = $this->obtenerClave($sku);

        if ($clave == -1) {
            return;
        }

        //Validar que exista cantidad del producto
        $producto = Producto::where('sku', $sku)->first();

        if ($producto) {
            //Verificar el stock
            //Recuperar la lista de productos
            $productos = $this->obtenerProductos();

            if ($producto->stock >= $productos[$clave]->cantidad + 1) {
                //Actualizar la cantidad
                $productos[$clave]->cantidad++;
                $productos[$clave]->total = $productos[$clave]->precio * $productos[$clave]->cantidad;
                //Guardar en el carrito
                \session(['carrito' => $productos]);
                //actualizar la lista de productos
                $this->listaProductos = session('carrito');
                //Mostrar alerta correcta
                $this->emit('mostrar-alerta', 'PRODUCTO ACTUALIZADO');
            } else {
                $this->listaProductos = session('carrito');
                $this->emit('mostrar-alerta', 'NO HAY STOCK SUFICIENTE');
                return;
            }
        }

        $this->emit('calcular');
    }

    public function reducirItem($sku)
    {
        $clave = $this->obtenerClave($sku);

        if ($clave == -1) {
            //mostrar alerta
            $this->emit('mostrar-alerta', 'PRODUCTO NO ENCONTRADO');
            return;
        }

        //Recuperar la lista de productos
        $productos = $this->obtenerProductos();
        //Actualizar la cantidad
        $productos[$clave]->cantidad--;
        $productos[$clave]->total = $productos[$clave]->precio * $productos[$clave]->cantidad;
        //Guardar en el carrito
        \session(['carrito' => $productos]);
        //actualizar la lista de productos
        $this->listaProductos = session('carrito');

        if ($productos[$clave]->cantidad <= 0) {
            //Eliminar el producto del carrito
            $this->eliminarProducto($sku);
        } else {
            //Mostrar alerta correcta
            $this->emit('mostrar-alerta', 'PRODUCTO REDUCIDO');
        }

        $this->emit('calcular');

    }


    public function eliminarProducto($sku)
    {
        $clave = $this->obtenerClave($sku);

        if ($clave == -1) {
            //mostrar alerta
            $this->emit('mostrar-alerta', 'PRODUCTO NO ENCONTRADO');
            return;
        }

        //Recuperar la lista de productos
        $productos = $this->obtenerProductos();
        //Eliminar el producto
        unset($productos[$clave]);
        //Guardar en el carrito
        \session(['carrito' => $productos]);
        //actualizar la lista de productos
        $this->listaProductos = session('carrito');
        //Mostrar alerta correcta
        $this->emit('mostrar-alerta', 'PRODUCTO ELIMINADO');

        $this->emit('calcular');
    }


    public function vaciarCarrito() {
        \session(['carrito' => []]);
        $this->listaProductos = session('carrito');
        $this->emit('calcular');
        $this->emit('mostrar-alerta', 'CARRITO VACIADO');
    }
}
