@extends("layouts.app")

@section("content")
    <center><h5><b class="text-success">Devoluciones | Consulta de Devoluciones | Detalle de la Devolución</b></h5></center>

    <div class="mt-3"><p class="text-success">
        <b>{{ 'Socio: ' . $devolution->member->code . ' - ' . $devolution->member->fullName() }}</b>
    </div>

    <div class="d-flex align-items-end">
        <div class="form-group">
            <p><b>Devolución N°: {{ $devolution->dev_number }}</b></p>
        </div>

        <div class="form-group">
            <a class="button btn btn-secondary px-3 ml-5" href="{{ route('devolutions.index') }}" title="Ir a la página de Consulta de Devoluciones">Volver</a>
        </div>
    </div>

    <div class="web2py_grid">
        @livewire('devolutions.devolution-items', ['devolution' => $devolution, 'show' => true])
    </div>
@endsection
