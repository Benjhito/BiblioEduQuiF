<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Member;
use App\Models\Reservation;
use App\Exports\ReservationsExport;
use App\Exports\ReservationsListPdf;
use Maatwebsite\Excel\Facades\Excel;

class ReservationController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $member = Member::find($reservation->member_id);

        return view('reservations.edit', compact('reservation', 'member'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->status == 'Confirmada')
            return back()->withErrors('No se puede eliminar esta Reserva porque ya fue confirmada.');

        try {
            $reservation->delete();
        } catch (Throwable $e) {
            return back()->withErrors('No se puede eliminar esta Reserva porque tiene registros relacionados.');
        }

        return redirect()->route('reservations.index')->withSuccess('¡La Reserva fue eliminada de la Base de Datos!');
    }

    public function list()
    {
        $title = 'Listado de Reservas';
        $line = str_repeat('-', 90);

        $pdf = new ReservationsListPdf();
        $pdf->AliasNbPages();
        $pdf->SetMargins(20, 20);
        $pdf->AddPage('P', 'A4');
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Benjamin Emanuel Tito');
        $pdf->SetCreator('Benjamin Emanuel Tito');
        $pdf->SetSubject($title);

        $reservationTotal = 0;

        $search = session()->get('search-6.2');

        $reservations = Reservation::lastName($search)
            ->orWhere->memberCode($search)
            ->dateRange(session()->get('iniDate-6.2'), session()->get('finDate-6.2'))
            ->orderBy(session()->get('sort-6.2'), session()->get('direction-6.2'))
            ->get();

        foreach ($reservations as $reservation) {

            $row = $reservation->res_date->format('d/m/y') .
                str_pad($reservation->res_number, 9, ' ', STR_PAD_LEFT) . '     ' .
                str_pad(utf8_decode(substr($reservation->member->code . ' - ' . $reservation->member->fullName(), 0, 54)), 56, ' ') .
                str_pad($reservation->status, 12, ' ', STR_PAD_LEFT);

            $pdf->Cell(0, 4, $row, 0, 1);

            $reservationTotal += 1;
        }

        $pdf->Cell(0, 3, $line, 0, 1);
        $pdf->SetFont('Courier', 'B', 9);
        $pdf->Cell(0, 5, 'Cantidad de Registros:' . str_pad((string)$reservationTotal, 6, ' ', STR_PAD_LEFT), 0, 1);

        return response($pdf->output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-disposition', 'filename=ListadoReservas(' . now()->format('d-m-Y') . ').pdf');
    }

    public function export(ReservationsExport $reservationsExport)
    {
        return Excel::download($reservationsExport, 'Reservas(' . now()->format('d-m-Y') . ').xlsx');
    }
}
