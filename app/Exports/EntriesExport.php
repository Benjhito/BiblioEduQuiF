<?php

namespace App\Exports;

use App\Models\Entry;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EntriesExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-4.2');

        return Entry::bookCode($search)
            ->orWhere->isbn($search)
            ->orWhere->title($search)
            ->provider(session()->get('providerId-4.2'))
            ->publisher(session()->get('publisherId-4.2'))
            ->category(session()->get('categoryId-4.2'))
            ->collection(session()->get('collectionId-4.2'))
            ->dateRange(session()->get('iniDate-4.2'), session()->get('finDate-4.2'))
            ->orderBy('provider_id')
            ->orderBy('rec_date', 'desc')
            ->orderBy('title')
            ->get();
    }

    public function map($entry): array
    {
        return [
            $entry->rec_date->format('d/m/Y'),
            $entry->book_code,
            $entry->isbn,
            $entry->title,
            $entry->provider->business_name,
            $entry->book->publisher->name,
            $entry->book->collection->name,
            $entry->quantity,
            $entry->missing,
            $entry->surplus,
            $entry->price,
            $entry->disc_rate,
            $entry->book->ivaRate->value,
            $entry->cost,   // Campo calculado
            $entry->amount, // Campo calculado
        ];
    }

    public function headings(): array
    {
        return [
            'FechaRecep',
            'Cód.Int.',
            'ISBN',
            'Título',
            'Proveedor',
            'Editorial',
            'Colección',
            'Cant.',
            'Falt.',
            'Sobr.',
            'Precio',
            '%Desc.',
            '%IVA',
            'Costo',
            'Importe',
        ];
    }
}
