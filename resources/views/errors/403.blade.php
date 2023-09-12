@extends('errors::layout')

@section('title', 'Acceso restringido')
@section('code', '403')
@section('message')
    <style type="text/css">
        body {
            background:url({{ asset('images/background.jpg') }}) repeat 0 0;
        }
    </style>

    <a class="navbar-brand" href="{{ url('/') }}">
        <img width="90px" src="{{ asset('images/logo.jpeg') }}" alt="Logo">
    </a>

    <h5>¡Acceso restringido!</h5>

    <img width="480px" src="{{ asset('images/error-403-forbidden.png') }}" alt="Error">
@endsection
