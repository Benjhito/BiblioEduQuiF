<?php

namespace App\Exports;

use App\Models\Provider;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProvidersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = session()->get('search-2.1');

        return Provider::businessName($search)
            ->orWhere->email($search)
            ->orWhere->code($search)
            ->orderBy(session()->get('sort-2.1'), session()->get('direction-2.1'))
            ->get();
    }

    public function map($provider): array
    {
        return [
            $provider->code,
            $provider->business_name,
            $provider->address,
            $provider->postcode,
            $provider->locality,
            $provider->province,
            $provider->country,
            $provider->phone1,
            $provider->phone2,
            $provider->email,
            $provider->url,
            $provider->acc_type == 'CC' ? 'Cuenta Corriente' : 'Caja de Ahorro',
            $provider->acc_number,
            $provider->cuit,
            $provider->contact,
            $provider->ivaType->descrip,
            $provider->inv_type,
        ];
    }

    public function headings(): array
    {
        return [
            'Cód.Int.',
            'Nombre',
            'Dirección',
            'C.P.',
            'Localidad',
            'Provincia',
            'País',
            'Tel.1',
            'Tel.2',
            'Email',
            'Url',
            'Tipo Cuenta',
            'Nro Cuenta',
            'CUIT',
            'Contacto',
            'Tipo IVA',
            'Tipo Fact.',
        ];
    }
}
