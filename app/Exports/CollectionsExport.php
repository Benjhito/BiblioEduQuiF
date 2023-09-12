<?php

namespace App\Exports;

use App\Models\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CollectionsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-3.4');

        return Collection::code($search)
            ->orWhere->name($search)
            ->orWhere->descrip($search)
            ->orderBy(session()->get('sort-3.4'), session()->get('direction-3.4'))
            ->get(['code', 'name', 'descrip']);
    }

    public function headings(): array
    {
        return [
            'Cód.Int.',
            'Nombre',
            'Descripción',
        ];
    }
}
