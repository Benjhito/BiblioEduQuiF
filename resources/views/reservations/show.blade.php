@extends("layouts.app")

@section("content")
    <center><h5><b class="text-warning">Reservas | Consulta de Reservas | Detalle de la Reserva</b></h5></center>

    <div class="mt-3"><p class="text-warning">
        <b>{{ 'Socio: ' . $reservation->member->code . ' - ' . $reservation->member->fullName() }}</b>
    </div>

    <div class="d-flex align-items-end">
        <div class="form-group">
            <p><b>Reserva N°: {{ $reservation->res_number }}</b></p>
        </div>

        <div class="form-group">
            <a class="button btn btn-secondary px-3 ml-5" href="{{ route('reservations.index') }}" title="Ir a la página de Consulta de Reservas">Volver</a>
        </div>
    </div>

    <div class="web2py_grid">
        @livewire('reservations.reservation-items', ['reservation' => $reservation, 'show' => true])
    </div>
@endsection
