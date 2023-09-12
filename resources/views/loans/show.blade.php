@extends("layouts.app")

@section("content")
    <center><h5><b class="text-primary">Préstamos | Consulta de Préstamos | Detalle del Préstamo</b></h5></center>

    <div class="mt-3"><p class="text-primary">
        <b>{{ 'Socio: ' . $loan->member->code . ' - ' . $loan->member->fullName() }}</b>
    </div>

    <div class="d-flex align-items-end">
        <div class="form-group">
            <p><b>Préstamo N°: {{ $loan->loan_number }}</b></p>
        </div>

        <div class="form-group">
            <a class="button btn btn-secondary px-3 ml-5" href="{{ route('loans.index') }}" title="Ir a la página de Consulta de Préstamos">Volver</a>
        </div>
    </div>

    <div class="web2py_grid">
        @livewire('loans.loan-items', ['loan' => $loan, 'show' => true])
    </div>
@endsection
