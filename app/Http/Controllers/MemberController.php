<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Member;
use App\Exports\MembersExport;
use App\Exports\MembersListPdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CreateMemberRequest;

class MemberController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $member = new Member;
        $member->code = str_pad((string)((int)Member::max('code') + 1), 4, '0', STR_PAD_LEFT);
        $member->adm_date = now();
        $member->status = 'Activo';
        $update = false;
        $route = route('members.store');

        return view('members.create', compact('update', 'route', 'member'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMemberRequest $request)
    {
        //Member::create($request->validated());
        $member = new Member($request->validated());
        $member->code = str_pad((string)((int)Member::max('code') + 1), 4, '0', STR_PAD_LEFT);
        $member->save();

        return redirect()->route('members.index')->with('success', '¡El Socio fue dado de alta exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $update = true;
        $route = route('members.update', $member);

        return view('members.edit', compact('update', 'route', 'member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateMemberRequest $request, Member $member)
    {
        $member->update($request->validated());

        return redirect()->route('members.index')->withSuccess('¡Los datos del Socio se actualizaron correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        try {
            $member->delete();
        } catch (Throwable $e) {
            return back()->withErrors('No se puede eliminar este Socio porque tiene registros relacionados.');
        }

        return redirect()->route('members.index')->withSuccess('¡El Socio fue eliminado de la Base de Datos!');
    }

    public function list(MembersListPdf $pdf)
    {
        $title = 'Listado de Socios';
        $pdf->AliasNbPages();
        $pdf->SetMargins(12, 20);
        $pdf->AddPage('L', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $search = session()->get('search-1.1');

        $members = Member::code($search)
            ->orWhere->lastName($search)
            ->orWhere->docNumber($search)
            ->orWhere->email($search)
            ->orderBy(session()->get('sort-1.1'), session()->get('direction-1.1'))
            ->get();

        // Header
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 7, 'Cod.', 1, 0, 'C');
        $pdf->Cell(51, 7, 'Apellidos y Nombres', 1, 0, 'C');
        $pdf->Cell(23, 7, 'DNI', 1, 0, 'C');
        $pdf->Cell(55, 7, 'Domicilio', 1, 0, 'C');
        $pdf->Cell(10, 7, 'C.P.', 1, 0, 'C');
        $pdf->Cell(41, 7, 'Localidad', 1, 0, 'C');
        $pdf->Cell(22, 7, 'Movil', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Email', 1, 0, 'C');
        $pdf->Cell(18, 7, 'FechaAdm', 1, 0, 'C');
        $pdf->Ln();
        // Data
        foreach ($members as $member) {
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(10, 6, $member->code, 1, 0, 'C');
            $pdf->Cell(51, 6, utf8_decode(substr($member->fullName(), 0, 33)), 1);
            $pdf->Cell(23, 6, $member->doc_number, 1, 0, 'C');
            $pdf->Cell(55, 6, utf8_decode(substr($member->address, 0, 29)), 1);
            $pdf->Cell(10, 6, substr($member->postcode, 0, 4), 1, 0, 'C');
            $pdf->Cell(41, 6, utf8_decode(substr($member->locality, 0, 20)), 1);
            $pdf->Cell(22, 6, substr($member->mobile, 0, 10), 1, 0, 'C');
            $pdf->Cell(45, 6, substr($member->email, 0, 28), 1);
            $pdf->Cell(18, 6, optional($member->adm_date)->format('d/m/Y') ?? '', 1, 0, 'C');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Ln();
        }

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoSocios(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(MembersExport $membersExport)
    {
        return Excel::download($membersExport, 'Socios(' . now()->format('d-m-Y') . ').xlsx');
    }
}
