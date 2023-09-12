@extends("layouts.app")

@section("content")
    @livewire('devolutions.devolution-create', [
        'devolution' => $devolution,
        'member' => $member,
    ])
@endsection
