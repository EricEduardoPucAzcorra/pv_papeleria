<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Venta;
use Livewire\Component;
use Carbon\Carbon;

class Reporte extends Component
{
    public $fechaInicio, $fechaFin, $tipoReporte;

    public $detalleVenta;

    //Variables para los detalles del reporte
    public $productosVendidos, $venRealizadas, $venPendientes, $venCanceladas, $ingresosVentas, $ingresosObtenidos, $ingresosPendientes, $ingresosCancelados; 

    public function mount()
    {
        $this->tipoReporte = 'DIARIO';

        $fechaActual = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        $fechaFinal = Carbon::now()->format('Y-m-d') . ' 23:59:59';

        $this->fechaInicio = Carbon::now()->format('Y-m-d');
        $this->fechaFin = Carbon::now()->format('Y-m-d');

        $this->estadisticas($fechaActual, $fechaFinal);

    }

    public function render()
    {
        return view('livewire.reportes.reporte')->extends('layouts.master')->section('contenido');
    }

    public function getReportesProperty()
    {
        $fechaActual = '';
        $fechaFinal = '';

        if ($this->tipoReporte == 'FECHA') {

           if ($this->fechaInicio && $this->fechaFin) {
                $fechaActual = Carbon::parse($this->fechaInicio)->format('Y-m-d') . ' 00:00:00';
                $fechaFinal = Carbon::parse($this->fechaFin)->format('Y-m-d') . ' 23:59:59';

                $this->estadisticas($fechaActual, $fechaFinal);
           }
            
        } else {

            //Crear el intervalo de tiempo que corresponde al dia actual
            $fechaActual = Carbon::now()->format('Y-m-d') . ' 00:00:00';
            $fechaFinal = Carbon::now()->format('Y-m-d') . ' 23:59:59';

            $this->estadisticas($fechaActual, $fechaFinal);

        }

        if ($fechaActual && $fechaFinal) {
            $ventas = Venta::whereBetween('created_at', [$fechaActual, $fechaFinal])->get() ?? [];
        } else {
            $ventas = [];
        }

        return $ventas;

    }

    public function estadisticas($fechaIni, $fechaFin) {

        $ventas = Venta::whereBetween('created_at', [$fechaIni, $fechaFin])->get() ?? [];

        if ($ventas->count() > 0) {
            $this->productosVendidos = $ventas->count();
            $this->venRealizadas = $ventas->where('estatus', 'COMPLETADO')->count();
            $this->venPendientes = $ventas->where('estatus', 'PENDIENTE')->count();
            $this->venCanceladas = $ventas->where('estatus', 'CANCELADO')->count();
            $this->ingresosVentas = $ventas->where('estatus', 'COMPLETADO')->sum('total');
            $this->ingresosPendientes = $ventas->where('estatus', 'PENDIENTE')->sum('total');
            $this->ingresosCancelados = $ventas->where('estatus', 'CANCELADO')->sum('total');
            
            //Obtener la ganacia al descontar el precio de compra con el precio de venta
            $ganancia = 0;

            foreach($ventas->where('estatus', 'COMPLETADO') as $venta) {
                foreach ($venta->productos as $producto) {
                    $cantidad = $producto->pivot->cantidad;
                    $ganancia += ($producto->precio * $cantidad) - ($producto->costo * $cantidad);
                }
            }

            $this->ingresosObtenidos = $ganancia;

        } else {
            $this->productosVendidos = 0;
            $this->venRealizadas = 0;
            $this->venPendientes = 0;
            $this->venCanceladas = 0;
            $this->ingresosVentas = 0;
            $this->ingresosPendientes = 0;
            $this->ingresosObtenidos = 0;
            $this->ingresosCancelados = 0;
        }
    }

    public function verDetalles(Venta $venta)
    {
        $this->detalleVenta = $venta;
        $this->emit('modal-detalles', 'show');
    }

    public function exportarPDF()
    {
        if ($this->reportes->count() > 0) {
            return \redirect()->route('reportes.pdf', ['inicio' => $this->fechaInicio, 'fin' => $this->fechaFin]);
        } else {
            $this->emit('mostrar-alerta', 'No hay datos para exportar');
        }
    }
}
