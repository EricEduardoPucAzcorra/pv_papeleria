<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Clases\PdfReportes as FPDF;

class PDFController extends Controller
{
    //
    public function __invoke($fechaInicio, $fechaFin)
    {
        $fechaInicio = $fechaInicio . ' 00:00:00';
        $fechaFin = $fechaFin . ' 23:59:59';

        $pdf = new FPDF('P', 'cm', 'Letter');
        $pdf->AliasNbPages();
        $pdf->SetTextColor(60);
        $pdf->AddPage('P', 'Letter');

        //Cuerpo
        $pdf->Cell(0, 1, Carbon::parse($fechaInicio)->translatedFormat('d-M-Y') . ' - ' . Carbon::parse($fechaFin)->translatedFormat('d-M-Y') , 0, 1, 'C');

        //Mostrar detalles de ventas
        #Recuperar las ventas de las fechas seleccionadas
        $ventas = Venta::whereBetween('created_at', [$fechaInicio, $fechaFin])->get();

        $pdf->Cell(0, 1, 'Detalles de ventas', 0, 1, 'C');

        #Tabla con los detalles relevantes de las ventas
        $pdf->SetFillColor(30, 86, 169);

        
        $red = 246;
        $green = 246;
        $blue = 246;
        $color2 = '0';

        $pdf->SetTextColor($red, $green, $blue);
        $pdf->setDrawColor(50, 50, 80);
        $pdf->SetFont('Arial', 'B', 10);
        

        #Primera fila
        $pdf->SetTextColor($red, $green, $blue);
        $pdf->Cell(3, 1, 'Ventas:', 1, 0, 'C', true);
        $pdf->SetTextColor($color2);
        $pdf->Cell(3, 1, $ventas->count(), 1, 0, 'C');

        //Mostrar el total de las ventas
        $total = 0;
        foreach ($ventas as $venta) {
            $total += $venta->total;
        }

        $pdf->SetTextColor($red, $green, $blue);
        $pdf->Cell(3, 1, 'Total: ', 1, 0, 'C', true);
        $pdf->SetTextColor($color2);
        $pdf->Cell(3, 1, '$' . \number_format($total, 2), 1, 0, 'C');

        $ingresos = 0;
        foreach ($ventas->where('estatus', 'COMPLETADO') as $venta) {
            $ingresos += $venta->total;
        }

        $pdf->SetTextColor($red, $green, $blue);
        $pdf->Cell(3, 1, 'Ingresos: ', 1, 0, 'C', true);
        $pdf->SetTextColor($color2);
        $pdf->Cell(3, 1, '$' . \number_format($ingresos, 2), 1, 1, 'C');

        #Segunda linea
        $ganancias = 0;
        foreach ($ventas->where('estatus', 'COMPLETADO') as $venta) {
            foreach ($venta->productos as $producto ) {
                $ganancias += ($producto->precio * $producto->pivot->cantidad) - ($producto->costo * $producto->pivot->cantidad);
            }
        }

        $pdf->SetTextColor($red, $green, $blue);
        $pdf->Cell(3, 1, 'Ganancias: ', 1, 0, 'C', true);
        $pdf->SetTextColor($color2);
        $pdf->Cell(3, 1, '$' . \number_format($ganancias, 2), 1, 0, 'C');
        
        $retenido = 0;
        foreach ($ventas->where('estatus', 'PENDIENTE') as $venta) {
            foreach ($venta->productos as $producto ) {
                $retenido += ($producto->precio * $producto->pivot->cantidad) - ($producto->costo * $producto->pivot->cantidad);
            }
        }

        $pdf->SetTextColor($red, $green, $blue);
        $pdf->Cell(3, 1, 'Pendientes: ', 1, 0, 'C', true);
        $pdf->SetTextColor($color2);
        $pdf->Cell(3, 1, '$' . \number_format($retenido, 2), 1, 0, 'C');
        
        
        $cancelado = 0;
        foreach ($ventas->where('estatus', 'CANCELADO') as $venta) {
            foreach ($venta->productos as $producto ) {
                $cancelado += ($producto->precio * $producto->pivot->cantidad) - ($producto->costo * $producto->pivot->cantidad);
            }
        }

        $pdf->SetTextColor($red, $green, $blue);
        $pdf->Cell(3, 1, 'Cancelado: ', 1, 0, 'C', true);
        $pdf->SetTextColor($color2);
        $pdf->Cell(3, 1, '$' . \number_format($cancelado, 2), 1, 1, 'C');
        #Tercera linea
        
        #items Vendidos
        $items = 0;
        foreach ($ventas->where('estatus', 'COMPLETADO') as $venta) {
            foreach ($venta->productos as $producto ) {
                $items += $producto->pivot->cantidad;
            }
        }

        $pdf->SetTextColor($red, $green, $blue);
        $pdf->Cell(3, 1, 'Obj. Vendidos: ', 1, 0, 'C', true);
        $pdf->SetTextColor($color2);
        $pdf->Cell(3, 1, '$' . \number_format($items, 2), 1, 0, 'C');
        
        $pdf->SetTextColor($red, $green, $blue);
        $pdf->Cell(3, 1, 'De: ', 1, 0, 'C', true);
        $pdf->SetTextColor($color2);
        $pdf->Cell(3, 1, Carbon::parse($fechaInicio)->translatedFormat('d-M-Y'), 1, 0, 'C');
        
        $pdf->SetTextColor($red, $green, $blue);
        $pdf->Cell(3, 1, 'A: ', 1, 0, 'C', true);
        $pdf->SetTextColor($color2);
        $pdf->Cell(3, 1, Carbon::parse($fechaFin)->translatedFormat('d-M-Y'), 1, 0, 'C');

        //Crear una tabla con las ventas realizadas
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 1, 'Ventas realizadas', 0, 1, 'C');
        $pdf->Ln(0.2);
        //Cambiar el color del encabezado
        $pdf->SetFillColor(22, 49, 114);
        $pdf->SetTextColor(246, 246, 246);
        $pdf->setDrawColor(50, 50, 80);
        $pdf->Cell(1, 1, '#', 1, 0, 'C', true);
        $pdf->Cell(2.5, 1, 'Fecha', 1, 0, 'C', true);
        $pdf->Cell(3.5, 1, 'Vendedor', 1, 0, 'C', true);
        $pdf->Cell(2.5, 1, 'Productos', 1, 0, 'C', true);
        $pdf->Cell(2.5, 1, 'Pago', 1, 0, 'C', true);
        $pdf->Cell(2.5, 1, 'Cambio', 1, 0, 'C', true);
        $pdf->Cell(2.5, 1, 'Subtotal', 1, 0, 'C', true);
        $pdf->Cell(2.5, 1, 'Estado', 1, 1, 'C', true);

        

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->setDrawColor(200);
        //Recorrer las ventas
        $fill = false;
        if ($fill) {
            $r = 214;
            $g = 228;
            $b = 240;
            $pdf->SetFillColor($r, $g, $b);
        } else {
            $r = 246;
            $g = 246;
            $b = 246;
            $pdf->SetFillColor($r, $g, $b);
        }
        foreach ($ventas as $clave => $venta) {
            $oldFill = $fill;

            $pdf->Cell(1, 1, $clave + 1, 1, 0, 'C', $fill);
            $pdf->Cell(2.5, 1, Carbon::parse($venta->created_at)->translatedFormat('d-M-Y'), 1, 0, 'C', $fill);
            $pdf->Cell(3.5, 1, $venta->user->nombre, 1, 0, 'C', $fill);
            $pdf->Cell(2.5, 1, $venta->items, 1, 0, 'C', $fill);
            $pdf->Cell(2.5, 1, '$' . \number_format($venta->pago, 2), 1, 0, 'C', $fill);
            $pdf->Cell(2.5, 1, '$' . \number_format($venta->cambio, 2), 1, 0, 'C', $fill);
            $pdf->Cell(2.5, 1, '$' . \number_format($venta->total, 2), 1, 0, 'C', $fill);
            $pdf->SetFont('Arial', '', 8);

            if ($venta->estatus != 'COMPLETADO') {
                $fill = true;
                $pdf->SetTextColor(246,246,246);
                $pdf->SetFillColor(30, 86, 169);
            }

            $pdf->Cell(2.5, 1, $venta->estatus, 1, 1, 'C', $fill);
            $pdf->SetFont('Arial', '', 10);

            if ($venta->estatus != 'COMPLETADO') {
                $fill = $oldFill;
                $pdf->SetTextColor(0);
                $pdf->SetFillColor($r, $g, $b);
            }
            
            $fill = !$fill;
        }

        //Detalles de venta
        $pdf->Cell(14.5, 1, '', 0, 0, 'C');
        $pdf->Cell(5, 1, 'Total de ventas: ' . '$' . \number_format($total, 2), 1, 1, 'R', $fill);

        
        $pdf->Output('', Carbon::parse($fechaInicio)->translatedFormat('d-M-Y') . ' - ' . Carbon::parse($fechaFin)->translatedFormat('d-M-Y') . '.pdf');
        exit;
    }

}
