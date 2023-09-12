<?php

namespace App\Exports;

use App\Models\Devolution;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DevolutionsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-7.2');

        return Devolution::lastName($search)
            ->orWhere->memberCode($search)
            ->orWhere->devNumber($search)
            ->dateRange(session()->get('iniDate-7.2'), session()->get('finDate-7.2'))
            ->orderBy(session()->get('sort-7.2'), session()->get('direction-7.2'))
            ->get();
    }

    public function map($devolution): array
    {
        return [
            $devolution->dev_date->format('d/m/Y'),
            $devolution->dev_number,
            $devolution->member->code . ' - ' . $devolution->member->fullName(),
            $devolution->status,
            //$devolution->notes,
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
