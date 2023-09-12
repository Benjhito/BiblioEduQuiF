<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Book;
use App\Models\IvaRate;
use App\Models\Provider;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Collection;
use App\Exports\BooksExport;
use App\Exports\BooksListPdf;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateBookRequest;

class BookController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastCode = Book::orderBy('code', 'desc')->first();
        $book = new Book;
        $book->code = $lastCode ? (string)(((int)$lastCode->code) + 1) : '10001';
        $book->edition = 1;
        $book->tome_count = 1;
        $book->price = 0.00;
        $book->disc_rate = 0.00;
        $book->iva_rate_id = 1;
        $book->status = 'Disponible'; // ['Disponible', 'Prestado', 'Reservado']
        $providers = Provider::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        $collections = Collection::all();
        $ivaRates = IvaRate::all();
        $update = false;
        $route = route('books.store');

        return view('books.create', compact('update', 'route', 'book', 'providers', 'publishers', 'categories', 'collections', 'ivaRates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBookRequest $request)
    {
        //Book::create($request->validated());
        $book = new Book($request->validated());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $img = Image::make(public_path("storage/{$imagePath}"))->fit(800, 600);
            $img->save();
            $book->image = $imagePath;
        }

        $book->code = str_pad((string)((int)Book::max('code') + 1), 5, '0', STR_PAD_LEFT);
        $book->save();

        if ($request->has('categories')) {
            $book->categories()->attach($request->categories);
        }

        return redirect()->route('books.index')->with('success', '¡El Libro fue dado de alta exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $providers = Provider::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        $collections = Collection::all();
        $ivaRates = IvaRate::all();
        $update = true;
        $route = route('books.update', $book);

        return view('books.edit', compact('update', 'route', 'book', 'providers', 'publishers', 'categories', 'collections', 'publishers', 'ivaRates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateBookRequest $request, Book $book)
    {
        $data = $request->validated();

        if ($request['delete_image']) {
            Storage::delete("public/{$book->image}");
            $data['image'] = '';
        }

        if ($request->hasFile('image')) {
            Storage::delete("public/{$book->image}");
            $imagePath = $request->file('image')->store('books', 'public');
            $img = Image::make(public_path("storage/{$imagePath}"))->fit(800, 600);
            $img->save();
            $data['image'] = $imagePath;
        }
        //$book->fill($request->all())->save();
        $book->update($data);

        if ($request->has('categories')) {
            $book->categories()->sync($request->categories);
        }

        return redirect()->route('books.index')->with('success', '¡El Libro fue actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            Storage::delete("public/{$book->image}");
            $book->categories()->detach();
            $book->delete();
        } catch (Throwable $e) {
            //report($e);
            return back()->withErrors('No se puede eliminar este Libro porque hay Registros asociados al mismo.');
        }

        return redirect()->route('books.index')->withSuccess('¡El Libro fue eliminado de la Base de Datos!');
    }

    public function list(BooksListPdf $pdf)
    {
        $title = 'Listado de Libros';
        $pdf->AliasNbPages();
        $pdf->SetMargins(12, 15);
        $pdf->AddPage('P', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $search = session()->get('search-3.1');

        $books = Book::code($search)
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

        foreach ($books as $book) {
            $row = $book->code . ' ' .
                str_pad(substr($book->title, 0, 20), 21, ' ') .
                str_pad(substr($book->author, 0, 18), 19, ' ') .
                str_pad($book->edition, 2, ' ', STR_PAD_LEFT) . '  ' .
                $book->pub_year . ' ' .
                str_pad(substr($book->publisher->name, 0, 18), 19, ' ') . ' ' .
                substr($book->isbn, 0, 13);
            $pdf->Cell(0, 4, $row, 0, 1);
        }

        $pdf->Cell(0, 3, str_repeat('-', 88), 0, 1);

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoLibros(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(BooksExport $booksExport)
    {
        return Excel::download($booksExport, 'Libros(' . now()->format('d-m-Y') . ').xlsx');
    }
}
