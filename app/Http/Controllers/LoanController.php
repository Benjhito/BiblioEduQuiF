<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Exports\LoansExport;
use App\Exports\LoansListPdf;
use Maatwebsite\Excel\Facades\Excel;

class LoanController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        $member = Member::find($loan->member_id);

        return view('loans.edit', compact('loan', 'member'));
    }

    public function list()
    {
        $title = 'Listado de Prestamos';
        $line = str_repeat('-', 90);

        $pdf = new LoansListPdf();
        $pdf->AliasNbPages();
        $pdf->SetMargins(20, 20);
        $pdf->AddPage('P', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $loanTotal = 0;

        $search = session()->get('search-5.2');

        $loans = Loan::lastName($search)
            ->orWhere->memberCode($search)
            ->orWhere->loanNumber($search)
            ->dateRange(session()->get('iniDate-5.2'), session()->get('finDate-5.2'))
            ->orderBy(session()->get('sort-5.2'), session()->get('direction-5.2'))
            ->get();

        foreach ($loans as $loan) {

            $row = $loan->loan_date->format('d/m/Y') .
                str_pad($loan->loan_number, 9, ' ', STR_PAD_LEFT) . '     ' .
                str_pad(utf8_decode(substr($loan->member->code . ' - ' . $loan->member->fullName(), 0, 54)), 56, ' ') .
                str_pad($loan->status, 10, ' ', STR_PAD_LEFT);

            $pdf->Cell(0, 4, $row, 0, 1);

            $loanTotal += 1;
        }

        $pdf->Cell(0, 3, $line, 0, 1);
        $pdf->SetFont('Courier', 'B', 9);
        $pdf->Cell(0, 5, 'Cantidad de Registros:' . str_pad((string)$loanTotal, 6, ' ', STR_PAD_LEFT), 0, 1);

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoPrestamos(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(LoansExport $loansExport)
    {
        return Excel::download($loansExport, 'Prestamos(' . now()->format('d-m-Y') . ').xlsx');
    }
}
