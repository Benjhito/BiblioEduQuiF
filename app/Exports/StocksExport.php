<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StocksExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-7.1');

        return Stock::quantity()
            ->join('books', 'stocks.book_id', 'books.id')
            ->select('stocks.*')
            ->where(function ($query) use ($search) {
                $query->where('books.code', 'ilike', "%{$search}%")
                        ->orWhere('books.isbn', 'ilike', "%{$search}%")
                        ->orWhere('books.title', 'ilike', "%{$search}%")
                        ->orWhere('books.author', 'ilike', "%{$search}%")
                        ->provider(session()->get('providerId-7.1'))
                        ->publisher(session()->get('publisherId-7.1'))
                        ->category(session()->get('categoryId-7.1'))
                        ->collection(session()->get('collectionId-7.1'));
            })
            ->orderBy('books.title')
            ->get();
    }

    public function map($stock): array
    {
        return [
            $stock->book->code,
            $stock->book->isbn,
            $stock->book->title,
            $stock->book->subtitle,
            $stock->book->descrip,
            $stock->book->author,
            $stock->book->edition,
            $stock->book->pub_year,
            $stock->book->publisher->name,
            $stock->book->collection->name,
            $stock->quantity,
            $stock->book->price,
            $stock->book->disc_rate,
            $stock->book->ivaRate->value,
            $stock->book->cost,
            $stock->book->amount,
            $stock->location,
        ];
    }

    public function headings(): array
    {
        return [
            'Cód.Int.',
            'ISBN',
            'Título',
            'Subtítulo',
            'Descripción',
            'Autor',
            'Edición',
            'Año Public.',
            'Editorial',
            'Colección',
            'Stock',
            'Precio',
            '%Desc.',
            '%IVA',
            'Precio Costo',
            'Importe',
            'Ubicación',
        ];
    }
}
