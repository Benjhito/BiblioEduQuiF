<?php

namespace App\Exports;

use Codedge\Fpdf\Fpdf\Fpdf;

class BooksListPdf extends Fpdf
{
    function Header()
    {
        //$this->Image(asset('images/Logo.png'), 15, 15, 20);
        $line = str_repeat('-', 88);
        $this->SetFont('Courier', 'B', 10);
        $this->Cell(0, 5, utf8_decode('Fundación EduQuiF'), 0, 1);
        // Title
        $this->Cell(0, 5, 'Listado de Libros' . str_repeat(' ', 54) . 'Fecha: ' . now()->format('d/m/Y'), 0, 1);
        $this->SetFont('Courier', '', 10);
        $this->Cell(0, 3, $line, 0, 1);
        $this->Cell(0, 5, utf8_decode('Cod.       Título              Autor        Edic. Año     Editorial            ISBN'), 0, 1);
        //$this->Ln(20);  // Line break
        $this->Cell(0, 3, $line, 0, 1);
    }

    function Footer()
    {
        $this->SetY(-15);   // Position at 1.5 cm from bottom
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, 'Pag. ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
}
