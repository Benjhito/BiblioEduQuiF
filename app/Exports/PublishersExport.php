<?php

namespace App\Exports;

use App\Models\Publisher;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PublishersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-3.2');

        return Publisher::name($search)
            ->orWhere->email($search)
            ->orWhere->code($search)
            ->orderBy(session()->get('sort-3.2'), session()->get('direction-3.2'))
            ->get();
    }

    public function map($publisher): array
    {
        return [
            $publisher->code,
            $publisher->name,
            $publisher->address,
            $publisher->postcode,
            $publisher->city,
            $publisher->state,
            $publisher->country,
            $publisher->phone,
            $publisher->email,
            $publisher->url,
        ];
    }

    public function headings(): array
    {
        return [
            'Cód.Int.',
            'Nombre',
            'Dirección',
            'C.P.',
            'Ciudad',
            'Estado',
            'País',
            'Teléfono',
            'Email',
            'Url',
        ];
    }
}
