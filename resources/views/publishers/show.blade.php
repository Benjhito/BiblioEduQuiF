@extends('layouts.app')

@section('content')
    <div class="web2py_grid">
        <center><h5><b class="text-primary">Datos de la Editorial</b></h5></center>

        <div class="d-flex justify-content-center">
            <div class="text-primary"><b>{{ 'Editorial: ' . $publisher->code . ' - ' . $publisher->fullName() }}</b>
            </div>

            <a class="button btn btn-secondary px-2 ml-5" href="#" onclick="history.back()" title="Volver a la página anterior">Volver</a>
        </div>

        <div class="d-flex justify-content-center table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover w-50 mt-2">
                <tbody>
                    <tr>
                        <td>Dirección</td>
                        <td>{{ $publisher->address }}</td>
                    </tr>

                    <tr>
                        <td>Cód. Postal</td>
                        <td>{{ $publisher->postcode }}</td>
                    </tr>

                    <tr>
                        <td>Ciudad</td>
                        <td>{{ $publisher->city }}</td>
                    </tr>

                    <tr>
                        <td>Estado</td>
                        <td>{{ $publisher->state }}</td>
                    </tr>

                    <tr>
                        <td>País</td>
                        <td>{{ $publisher->country }}</td>
                    </tr>

                    <tr>
                        <td>Teléfono</td>
                        <td>{{ $publisher->phone }}</td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td>{{ $publisher->email }}</td>
                    </tr>

                    <tr>
                        <td>Url</td>
                        <td>{{ $publisher->url }}</td>
                    </tr>

                    <tr>
                        <td>Logo</td>
                        <td align="center">
                            @if($publisher->logo)
                                <img width="100px" src="/storage/{{ $publisher->logo }}">
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
