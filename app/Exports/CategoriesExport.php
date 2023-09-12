<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoriesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-3.3');

        return Category::code($search)
            ->orWhere->name($search)
            ->orWhere->descrip($search)
            ->orderBy(session()->get('sort-3.3'), session()->get('direction-3.3'))
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
