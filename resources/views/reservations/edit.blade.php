@extends("layouts.app")

@section("content")
    @livewire('reservations.reservation-create', [
        'reservation' => $reservation,
        'member' => $member,
    ])
@endsection
