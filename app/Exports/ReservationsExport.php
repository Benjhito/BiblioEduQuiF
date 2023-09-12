<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReservationsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-6.2');

        return Reservation::lastName($search)
            ->orWhere->memberCode($search)
            ->orWhere->resNumber($search)
            ->dateRange(session()->get('iniDate-6.2'), session()->get('finDate-6.2'))
            ->orderBy(session()->get('sort-6.2'), session()->get('direction-6.2'))
            ->get();
    }

    public function map($reservation): array
    {
        return [
            $reservation->res_date->format('d/m/Y'),
            $reservation->res_number,
            $reservation->member->code . ' - ' . $reservation->member->fullName(),
            $reservation->status,
            //$reservation->notes,
        ];
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Nro.',
            'Socio',
            'Estado',
            //'Observ.',
        ];
    }
}
