@extends("layouts.app")

@section("content")
    @include('members.form', ['member' => $member])
@endsection
