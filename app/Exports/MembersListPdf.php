<?php

namespace App\Exports;

use Codedge\Fpdf\Fpdf\Fpdf;

class MembersListPdf extends Fpdf
{
    function Header()
    {
        $this->Image(asset('images/logo.jpeg'), 15, 15, 30);
        $this->SetFont('Arial', 'B', 14);
        //$this->Cell(80);         // Move to the right
        // Title
        $this->Cell(160, 10, 'Listado de Socios', 0, 0, 'R');
        $this->SetFont('Arial', '', 12);
        $this->Cell(115, 10, now()->format('d/m/Y'), 0, 1, 'R');
        $this->Ln();  // Line break
    }

    function Footer()
    {
        $this->SetY(-15);   // Position at 1.5 cm from bottom
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, 'Pag. ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
}
