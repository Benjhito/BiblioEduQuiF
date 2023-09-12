@extends('layouts.app')

@section('content')
    <div class="web2py_grid">
        <center><h5><b class="text-primary">Datos del Proveedor</b></h5></center>

        <div class="d-flex justify-content-center">
            <div class="text-primary"><b>{{ 'Proveedor: ' . $provider->code . ' - ' . $provider->fullName() }}</b>
            </div>

            <a class="button btn btn-secondary px-2 ml-5" href="#" onclick="history.back()" title="Volver a la página anterior">Volver</a>
        </div>

        <div class="d-flex justify-content-center table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover w-50 mt-2">
                <tbody>
                    <tr>
                        <td>Dirección</td>
                        <td>{{ $provider->address }}</td>
                    </tr>

                    <tr>
                        <td>Cód. Postal</td>
                        <td>{{ $provider->postcode }}</td>
                    </tr>

                    <tr>
                        <td>Localidad</td>
                        <td>{{ $provider->locality }}</td>
                    </tr>

                    <tr>
                        <td>Provincia</td>
                        <td>{{ $provider->province }}</td>
                    </tr>

                    <tr>
                        <td>País</td>
                        <td>{{ $provider->country }}</td>
                    </tr>

                    <tr>
                        <td>Teléfono 1</td>
                        <td>{{ $provider->phone1 }}</td>
                    </tr>

                    <tr>
                        <td>Teléfono 2</td>
                        <td>{{ $provider->phone2 }}</td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td>{{ $provider->email }}</td>
                    </tr>

                    <tr>
                        <td>Url</td>
                        <td>{{ $provider->url }}</td>
                    </tr>

                    <tr>
                        <td>Tipo de Cuenta</td>
                        <td>{{ $provider->acc_type == 'CC' ? 'Cuenta Corriente' : 'Caja de Ahorro' }}</td>
                    </tr>

                    <tr>
                        <td>Nro. de Cuenta</td>
                        <td>{{ $provider->acc_number }}</td>

                    </tr>

                    <tr>
                        <td>CUIT</td>
                        <td>{{ $provider->cuit }}</td>
                    </tr>

                    <tr>
                        <td>Tipo de IVA</td>
                        <td>{{ $provider->ivaType->descrip }}</td>
                    </tr>

                    <tr>
                        <td>Tipo de Factura</td>
                        <td>{{ $provider->inv_type }}</td>
                    </tr>

                    <tr>
                        <td>Contacto</td>
                        <td>{{ $provider->contact }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
