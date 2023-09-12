<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Devolution;
use App\Exports\DevolutionsExport;
use App\Exports\DevolutionsListPdf;
use Maatwebsite\Excel\Facades\Excel;

class DevolutionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Devolution $devolution)
    {
        return view('devolutions.show', compact('devolution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Devolution $devolution)
    {
        $member = Member::find($devolution->member_id);

        return view('devolutions.edit', compact('devolution', 'member'));
    }

    public function list()
    {
        $title = 'Listado de Devoluciones';
        $line = str_repeat('-', 90);

        $pdf = new DevolutionsListPdf();
        $pdf->AliasNbPages();
        $pdf->SetMargins(20, 20);
        $pdf->AddPage('P', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $devolutionTotal = 0;

        $search = session()->get('search-7.2');

        $devolutions = Devolution::lastName($search)
            ->orWhere->memberCode($search)
            ->orWhere->devNumber($search)
            ->dateRange(session()->get('iniDate-7.2'), session()->get('finDate-7.2'))
            ->orderBy(session()->get('sort-7.2'), session()->get('direction-7.2'))
            ->get();

        foreach ($devolutions as $devolution) {

            $row = $devolution->dev_date->format('d/m/Y') .
                str_pad($devolution->dev_number, 9, ' ', STR_PAD_LEFT) . '     ' .
                str_pad(utf8_decode(substr($devolution->member->code . ' - ' . $devolution->member->fullName(), 0, 54)), 56, ' ') .
                str_pad($devolution->status, 10, ' ', STR_PAD_LEFT);

            $pdf->Cell(0, 4, $row, 0, 1);

            $devolutionTotal += 1;
        }

        $pdf->Cell(0, 3, $line, 0, 1);
        $pdf->SetFont('Courier', 'B', 9);
        $pdf->Cell(0, 5, 'Cantidad de Registros:' . str_pad((string)$devolutionTotal, 6, ' ', STR_PAD_LEFT), 0, 1);

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoDevoluciones(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(DevolutionsExport $devolutionsExport)
    {
        return Excel::download($devolutionsExport, 'Devoluciones(' . now()->format('d-m-Y') . ').xlsx');
    }
}
