@extends('layouts.app')

@section('content')
    <div class="web2py_grid">
        <center><h5><b class="text-primary">Datos del Socio</b></h5></center>

        <div class="d-flex justify-content-center">
            <div class="text-primary"><b>{{ 'Socio: ' . $member->code . ' - ' . $member->fullName() }}</b>
            </div>

            <a class="button btn btn-secondary px-2 ml-5" href="#" onclick="history.back()" title="Volver a la página anterior">Volver</a>
        </div>

        <div class="d-flex justify-content-center table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover w-50 mt-2">
                <tbody>
                    <tr>
                        <td>DNI</td>
                        <td>{{ $member->doc_number }}</td>
                    </tr>

                    <tr>
                        <td>Domicilio</td>
                        <td>{{ $member->address }}</td>
                    </tr>

                    <tr>
                        <td>Cód. Postal</td>
                        <td>{{ $member->postcode }}</td>
                    </tr>

                    <tr>
                        <td>Localidad</td>
                        <td>{{ $member->locality }}</td>
                    </tr>

                    <tr>
                        <td>Teléfono Móvil</td>
                        <td>{{ $member->mobile }}</td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td>{{ $member->email }}</td>
                    </tr>

                    <tr>
                        <td>Fecha de admisión</td>
                        <td>{{ $member->adm_date ? $member->adm_date->format('d/m/Y') : '' }}</td>

                    </tr>

                    <tr>
                        <td>Estado</td>
                        <td>{{ $member->status }}</td>
                    </tr>

                    <tr>
                        <td>Observaciones</td>
                        <td>{{ $member->notes }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
