<?php

namespace App\Http\Controllers\Clases;

use Codedge\Fpdf\Fpdf\Fpdf as PDF;
//crear una nueva clase que herede de FPDF
class PdfReportes extends PDF
{
    //funcion para crear el encabezado
    function Header()
    {
        $this->Image(\public_path('dist/img/jordana-circle.png'), 3, 0.0, 4, 4);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 1, 'Reporte de ventas', 0, 1, 'C');
        $this->Ln(0.1);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 1, 'Detalles del periodo', 0, 1, 'C');
        $this->Ln(0.2);
        $this->SetFont('Arial', '', 10);
    }

    //funcion para crear el pie de pagina
    function Footer()
    {
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 1, 'Pagina ' . $this->PageNo() . ' de {nb}' , 0, 0, 'R');
    }
}
