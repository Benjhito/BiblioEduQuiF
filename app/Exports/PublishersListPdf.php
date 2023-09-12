<?php

namespace App\Exports;

use Codedge\Fpdf\Fpdf\Fpdf;

class PublishersListPdf extends Fpdf
{
    function Header()
    {
        $this->Image(asset('images/logo.jpeg'), 15, 15, 20);
        $this->SetFont('Arial', 'B', 14);
        //$this->Cell(80);         // Move to the right
        // Title
        $this->Cell(0, 10, 'Listado de Editoriales', 0, 0, 'C');
        $this->Ln(20);  // Line break
    }

    function Footer()
    {
        $this->SetY(-15);   // Position at 1.5 cm from bottom
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, 'Pag. ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
}
