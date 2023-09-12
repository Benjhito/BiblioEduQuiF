<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Category;
use App\Exports\CategoriesExport;
use App\Exports\CategoriesListPdf;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastRecord = Category::orderBy('code', 'desc')->first();
        $category = new Category;
        $category->code = $lastRecord ? str_pad((string)(((int)$lastRecord->code) + 1), 2, '0', STR_PAD_LEFT) : '100';
        $update = false;
        $route = route('categories.store');

        return view('categories.create', compact('update', 'route', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = new Category($request->validated());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $img = Image::make(public_path("storage/{$imagePath}"))->fit(800, 600);
            $img->save();
            $category->image = $imagePath;
        }

        $category->code = str_pad((string)((int)Category::max('code') + 1), 2, '0', STR_PAD_LEFT);
        $category->save();

        return redirect()->route('categories.index')->with('success', '¡La Categoría fue creada exitosamente!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $update = true;
        $route = route('categories.update', $category);

        return view('categories.edit', compact('update', 'route', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if ($request['delete_image']) {
            Storage::delete("public/{$category->image}");
            $data['image'] = '';
        }

        if ($request->hasFile('image')) {
            Storage::delete("public/{$category->image}");
            $imagePath = $request->file('image')->store('categories', 'public');
            $img = Image::make(public_path("storage/{$imagePath}"))->fit(800, 600);
            $img->save();
            $data['image'] = $imagePath;
        }
        //$book->fill($request->all())->save();
        $category->update($data);

        return redirect()->route('categories.index')->with('success', '¡Categoría actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->books()->detach();
            $category->delete();
        } catch (Throwable $e) {
            //report($e);
            return back()->withErrors('No se pudo eliminar esta Categoría.');
        }

        return redirect()->route('categories.index')->withSuccess('¡La Categoría fue eliminada de la Base de Datos!');
    }

    public function list(CategoriesListPdf $pdf)
    {
        $title = 'Listado de Categorías';
        $pdf->AliasNbPages();
        $pdf->SetMargins(25, 20);
        $pdf->AddPage('P', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $search = session()->get('search-3.3');

        $categories = Category::code($search)
            ->orWhere->name($search)
            ->orWhere->descrip($search)
            ->orderBy(session()->get('sort-3.3'), session()->get('direction-3.3'))
            ->get();

        // Header
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20, 7, 'Cod.Int.', 1, 0, 'C');
        $pdf->Cell(70, 7, utf8_decode('Nombre'), 1, 0, 'C');
        $pdf->Cell(70, 7, utf8_decode('Descripción'), 1, 0, 'C');
        $pdf->Ln();
        // Data
        foreach ($categories as $category) {
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(20, 6, $category->code, 1, 0, 'C');
            $pdf->Cell(70, 6, utf8_decode($category->name), 1);
            $pdf->Cell(70, 6, utf8_decode(substr($category->descrip, 0, 33)), 1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Ln();
        }

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoCategorias(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(CategoriesExport $categoriesExport)
    {
        return Excel::download($categoriesExport, 'Categorias(' . now()->format('d-m-Y') . ').xlsx');
    }
}
