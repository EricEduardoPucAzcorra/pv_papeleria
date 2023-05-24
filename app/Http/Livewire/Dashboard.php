<?php

namespace App\Http\Livewire;

use App\Models\Deudor;
use App\Models\Producto;
use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function mount()
    {
    }
    
    public function render()
    {
        $productos = Producto::all();
        //Filtrar productos si el stock es menor o igual al minimo_stock
        $productosCortos = $productos->filter(function ($producto) {
            return $producto->stock <= $producto->minimo_stock;
        })->take(5);

        //Ordenar productos mas vendidos
        $productosMasVendidos = $productos->sortByDesc(function ($producto) {
            return $producto->ventas->count();
        })->take(5);

        //Ultimas ventas
        $ultimasVentas = Venta::whereBetween('created_at', [Carbon::now()->format('Y-m-d') . ' 00:00:00' ,  Carbon::now()->format('Y-m-d') . ' 23:59:59'])->get();

        $deudasAntiguas = Venta::orderBy('created_at', 'asc')->where('estatus', 'PENDIENTE')->take(3)->get();

        return view('livewire.dashboard', compact('productosCortos', 'productosMasVendidos', 'ultimasVentas', 'deudasAntiguas'));
    }
}
