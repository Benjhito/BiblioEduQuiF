<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LoansExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-5.2');

        return Loan::lastName($search)
            ->orWhere->memberCode($search)
            ->orWhere->loanNumber($search)
            ->dateRange(session()->get('iniDate-5.2'), session()->get('finDate-5.2'))
            ->orderBy(session()->get('sort-5.2'), session()->get('direction-5.2'))
            ->get();
    }

    public function map($loan): array
    {
        return [
            $loan->loan_date->format('d/m/Y'),
            $loan->loan_number,
            $loan->member->code . ' - ' . $loan->member->fullName(),
            $loan->status,
            //$loan->notes,
        ];
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Nro.',
            'Socio',
            'Estado',
            //'Observ.',
        ];
    }
}
