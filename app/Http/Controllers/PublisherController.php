<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Publisher;
use App\Exports\PublishersExport;
use App\Exports\PublishersListPdf;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreatePublisherRequest;

class PublisherController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastCode = Publisher::orderBy('code', 'desc')->first();
        $publisher = new Publisher;
        $publisher->code = $lastCode ? (string)(((int)$lastCode->code) + 1) : '101';
        $update = false;
        $route = route('publishers.store');

        return view('publishers.create', compact('update', 'route', 'publisher'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePublisherRequest $request)
    {
        //Publisher::create($request->validated());
        $publisher = new Publisher($request->validated());

        if ($request->hasFile('logo')) {
            $imagePath = $request->file('logo')->store('publishers', 'public');
            $img = Image::make(public_path("storage/{$imagePath}"))->fit(800, 600);
            $img->save();
            $publisher->logo = $imagePath;
        }

        $publisher->code = str_pad((string)((int)Publisher::max('code') + 1), 3, '0', STR_PAD_LEFT);
        $publisher->save();

        return redirect()->route('publishers.index')->with('success', '¡La Editorial fue dada de alta exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return view('publishers.show', compact('publisher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        $update = true;
        $route = route('publishers.update', $publisher);

        return view('publishers.edit', compact('update', 'route','publisher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePublisherRequest $request, Publisher $publisher)
    {
        $publisher->update($request->validated());

        $data = $request->validated();

        if ($request['delete_logo']) {
            Storage::delete("public/{$publisher->logo}");
            $data['logo'] = '';
        }

        if ($request->hasFile('logo')) {
            Storage::delete("public/{$publisher->logo}");
            $imagePath = $request->file('logo')->store('publishers', 'public');
            $img = Image::make(public_path("storage/{$imagePath}"))->fit(800, 600);
            $img->save();
            $data['logo'] = $imagePath;
        }
        //$publisher->fill($request->all())->save();
        $publisher->update($data);

        return redirect()->route('publishers.index')->with('success', '¡Editorial actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        try {
            Storage::delete("public/{$publisher->logo}");
            $publisher->delete();
        } catch (Throwable $e) {
            //report($e);
            return back()->withErrors('No se puede eliminar esta Editorial porque hay Libros asociados a la misma.');
        }

        return redirect()->route('publishers.index')->withSuccess('¡La Editorial fue eliminada de la Base de Datos!');
    }

    public function list(PublishersListPdf $pdf)
    {
        $title = 'Listado de Editoriales';
        $pdf->AliasNbPages();
        $pdf->SetMargins(12, 20);
        $pdf->AddPage('L', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $search = session()->get('search-3.2');

        $publishers = Publisher::name($search)
            ->orWhere->email($search)
            ->orWhere->code($search)
            ->orderBy(session()->get('sort-3.2'), session()->get('direction-3.2'))
            ->get();
        // Header
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 7, 'Cod.', 1, 0, 'C');
        $pdf->Cell(52, 7, 'Nombre', 1, 0, 'C');
        $pdf->Cell(52, 7, 'Direccion', 1, 0, 'C');
        $pdf->Cell(12, 7, 'C.P.', 1, 0, 'C');
        $pdf->Cell(43, 7, 'Ciudad', 1, 0, 'C');
        $pdf->Cell(43, 7, 'Estado', 1, 0, 'C');
        $pdf->Cell(43, 7, 'Pais', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Telefono', 1, 0, 'C');
        $pdf->Ln();
        // Data
        foreach ($publishers as $publisher) {
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(10, 6, $publisher->code, 1, 0, 'C');
            $pdf->Cell(52, 6, utf8_decode(substr($publisher->name, 0, 25)), 1);
            $pdf->Cell(52, 6, utf8_decode(substr($publisher->address, 0, 27)), 1);
            $pdf->Cell(12, 6, substr($publisher->postcode, 0, 4), 1, 0, 'C');
            $pdf->Cell(43, 6, utf8_decode(substr($publisher->city, 0, 21)), 1);
            $pdf->Cell(43, 6, utf8_decode(substr($publisher->state, 0, 21)), 1);
            $pdf->Cell(43, 6, utf8_decode(substr($publisher->country, 0, 23)), 1);
            $pdf->Cell(20, 6, substr($publisher->phone, 0, 10), 1, 0, 'C');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Ln();
        }

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoEditoriales(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(PublishersExport $publishersExport)
    {
        return Excel::download($publishersExport, 'Editoriales(' . now()->format('d-m-Y') . ').xlsx');
    }
}
