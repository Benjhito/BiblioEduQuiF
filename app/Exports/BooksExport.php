<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BooksExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-3.1');

        return Book::code($search)
            ->orWhere->isbn($search)
            ->orWhere->title($search)
            ->orWhere->subtitle($search)
            ->orWhere->descrip($search)
            ->orWhere->author($search)
            ->provider(session()->get('providerId-3.1'))
            ->publisher(session()->get('publisherId-3.1'))
            ->category(session()->get('categoryId-3.1'))
            ->collection(session()->get('collectionId-3.1'))
            ->orderBy(session()->get('sort-3.1'), session()->get('direction-3.1'))
            ->get();
    }

    public function map($book): array
    {
        return [
            $book->code,
            $book->title,
            $book->subtitle,
            $book->descrip,
            $book->author,
            $book->edition,
            $book->pub_year,
            $book->isbn,
            $book->collection->name,
            $book->publisher->business_name,
            $book->binding,
            $book->page_count,
            $book->format,
            $book->tome_count,
            $book->weight,
            $book->price,
            $book->disc_rate,
            $book->ivaRate->value,
            $book->status,
        ];
    }

    public function headings(): array
    {
        return [
            'Cod.Int.',
            'Título',
            'Subtítulo',
            'Descripción',
            'Autor',
            'Edición',
            'Año Public.',
            'ISBN',
            'Colección',
            'Editorial',
            'Encuadernación',
            'Cant.Págs.',
            'Formato',
            'Cant.Tomos',
            'Peso (g)',
            'Precio',
            '% Desc.',
            '% IVA',
            'Estado',
        ];
    }
}
