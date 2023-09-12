<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Collection;
use App\Exports\CollectionsExport;
use App\Exports\CollectionsListPdf;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateCollectionRequest;

class CollectionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastRecord = Collection::orderBy('code', 'desc')->first();
        $collection = new Collection;
        $collection->code = $lastRecord ? str_pad((string)(((int)$lastRecord->code) + 1), 2, '0', STR_PAD_LEFT) : '100';
        $update = false;
        $route = route('collections.store');

        return view('collections.create', compact('update', 'route', 'collection'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCollectionRequest $request)
    {
        $collection = new Collection($request->validated());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('collections', 'public');
            $img = Image::make(public_path("storage/{$imagePath}"))->fit(800, 600);
            $img->save();
            $collection->image = $imagePath;
        }

        $collection->code = str_pad((string)((int)Collection::max('code') + 1), 2, '0', STR_PAD_LEFT);
        $collection->save();

        return redirect()->route('collections.index')->with('success', '¡La Colección fue creada exitosamente!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        $update = true;
        $route = route('collections.update', $collection);

        return view('collections.edit', compact('update', 'route', 'collection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateCollectionRequest $request, Collection $collection)
    {
        $data = $request->validated();

        if ($request['delete_image']) {
            Storage::delete("public/{$collection->image}");
            $data['image'] = '';
        }

        if ($request->hasFile('image')) {
            Storage::delete("public/{$collection->image}");
            $imagePath = $request->file('image')->store('collections', 'public');
            $img = Image::make(public_path("storage/{$imagePath}"))->fit(800, 600);
            $img->save();
            $data['image'] = $imagePath;
        }
        //$book->fill($request->all())->save();
        $collection->update($data);

        return redirect()->route('collections.index')->with('success', '¡Colección actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        try {
            $collection->books()->detach();
            $collection->delete();
        } catch (Throwable $e) {
            //report($e);
            return back()->withErrors('No se pudo eliminar esta Colección.');
        }

        return redirect()->route('collections.index')->withSuccess('¡La Colección fue eliminada de la Base de Datos!');
    }

    public function list(CollectionsListPdf $pdf)
    {
        $title = 'Listado de Colecciones';
        $pdf->AliasNbPages();
        $pdf->SetMargins(25, 20);
        $pdf->AddPage('P', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $search = session()->get('search-3.4');

        $collections = Collection::code($search)
            ->orWhere->name($search)
            ->orWhere->descrip($search)
            ->orderBy(session()->get('sort-3.4'), session()->get('direction-3.4'))
            ->get();

        // Header
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20, 7, 'Cod.Int.', 1, 0, 'C');
        $pdf->Cell(70, 7, utf8_decode('Nombre'), 1, 0, 'C');
        $pdf->Cell(70, 7, utf8_decode('Descripción'), 1, 0, 'C');
        $pdf->Ln();
        // Data
        foreach ($collections as $collection) {
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(20, 6, $collection->code, 1, 0, 'C');
            $pdf->Cell(70, 6, utf8_decode($collection->name), 1);
            $pdf->Cell(70, 6, utf8_decode(substr($collection->descrip, 0, 33)), 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Ln();
        }

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoColecciones(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(CollectionsExport $collectionsExport)
    {
        return Excel::download($collectionsExport, 'Colecciones(' . now()->format('d-m-Y') . ').xlsx');
    }
}
