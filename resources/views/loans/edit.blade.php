@extends("layouts.app")

@section("content")
    @livewire('loans.loan-create', [
        'loan' => $loan,
        'member' => $member,
    ])
@endsection
