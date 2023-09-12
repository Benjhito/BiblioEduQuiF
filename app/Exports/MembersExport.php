<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MembersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-1.1');

        return Member::code($search)
            ->orWhere->lastName($search)
            ->orWhere->docNumber($search)
            ->orWhere->email($search)
            ->orderBy(session()->get('sort-1.1'), session()->get('direction-1.1'))
            ->get();
    }

    public function map($member): array
    {
        return [
            $member->code,
            $member->last_name,
            $member->first_name,
            $member->doc_number,
            $member->address,
            $member->postcode,
            $member->locality,
            $member->mobile,
            $member->email,
            $member->adm_date ? $member->adm_date->format('d/m/Y') : '',
            $member->status,
            $member->notes,
        ];
    }

    public function headings(): array
    {
        return [
            'Código',
            'Apellidos',
            'Nombres',
            'DNI',
            'Domicilio',
            'C.P.',
            'Localidad',
            'Móvil',
            'Email',
            'Fecha Admisión',
            'Estado',
            'Observ.',
        ];
    }
}
