<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\IvaType;
use App\Models\Provider;
use App\Exports\ProvidersExport;
use App\Exports\ProvidersListPdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CreateProviderRequest;

class ProviderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastCode = Provider::orderBy('code', 'desc')->first();
        $provider = new Provider;
        $provider->code = $lastCode ? (string)(((int)$lastCode->code) + 1) : '101';
        $provider->acc_type = 'CC';
        $provider->iva_type_id = 1;
        $provider->inv_type = 'A';
        $ivaTypes = IvaType::all();
        $update = false;
        $route = route('providers.store');

        return view('providers.create', compact('update', 'route', 'provider', 'ivaTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProviderRequest $request)
    {
        //Provider::create($request->validated());
        $provider = new Provider($request->validated());
        $provider->code = str_pad((string)((int)Provider::max('code') + 1), 3, '0', STR_PAD_LEFT);
        $provider->save();

        return redirect()->route('providers.index')->with('success', '¡El Proveedor fue dado de alta exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider)
    {
        return view('providers.show', compact('provider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        $ivaTypes = IvaType::all();
        $update = true;
        $route = route('providers.update', $provider);

        return view('providers.edit', compact('update', 'route','provider', 'ivaTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateProviderRequest $request, Provider $provider)
    {
        //$provider->fill($request->all())->save();
        $provider->update($request->validated());

        return redirect()->route('providers.index')->with('success', '¡Proveedor actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        try {
            $provider->delete();
        } catch (Throwable $e) {
            //report($e);
            return back()->withErrors('No se puede eliminar este Proveedor porque hay Libros asociados al mismo.');
        }

        return redirect()->route('providers.index')->withSuccess('¡El Proveedor fue eliminado de la Base de Datos!');
    }

    public function list(ProvidersListPdf $pdf)
    {
        $title = 'Listado de Proveedores';
        $pdf->AliasNbPages();
        $pdf->SetMargins(12, 20);
        $pdf->AddPage('L', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $search = session()->get('search-2.1');

        $providers = Provider::businessName($search)
            ->orWhere->email($search)
            ->orWhere->code($search)
            ->orderBy(session()->get('sort-2.1'), session()->get('direction-2.1'))
            ->get();
        // Header
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 7, 'Cod.', 1, 0, 'C');
        $pdf->Cell(52, 7, 'Nombre', 1, 0, 'C');
        $pdf->Cell(52, 7, 'Direccion', 1, 0, 'C');
        $pdf->Cell(10, 7, 'C.P.', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Localidad', 1, 0, 'C');
        $pdf->Cell(35, 7, 'Provincia', 1, 0, 'C');
        $pdf->Cell(18, 7, 'Tel.1', 1, 0, 'C');
        $pdf->Cell(24, 7, 'CUIT', 1, 0, 'C');
        $pdf->Cell(26, 7, 'Tipo IVA', 1, 0, 'C');
        $pdf->Cell(8, 7, 'Fac', 1, 0, 'C');
        $pdf->Ln();
        // Data
        foreach ($providers as $provider) {
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(10, 6, $provider->code, 1, 0, 'C');
            $pdf->Cell(52, 6, utf8_decode(substr($provider->business_name, 0, 26)), 1);
            $pdf->Cell(52, 6, utf8_decode(substr($provider->address, 0, 27)), 1);
            $pdf->Cell(10, 6, substr($provider->postcode, 0, 4), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(substr($provider->locality, 0, 19)), 1);
            $pdf->Cell(35, 6, utf8_decode(substr($provider->province, 0, 17)), 1);
            $pdf->Cell(18, 6, substr($provider->phone1, 0, 10), 1, 0, 'C');
            $pdf->Cell(24, 6, $provider->cuit, 1, 0, 'C');
            $pdf->Cell(26, 6, substr($provider->ivaType->descrip, 0, 15), 1);
            $pdf->Cell(8, 6, $provider->inv_type, 1, 0, 'C');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Ln();
        }

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoProveedores(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(ProvidersExport $providersExport)
    {
        return Excel::download($providersExport, 'Proveedores(' . now()->format('d-m-Y') . ').xlsx');
    }
}
