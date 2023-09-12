@extends('errors::layout')

@section('title', 'Página no encontrada.')
@section('code', '404')
@section('message')
    <style type="text/css">
        body {
            background:url({{ asset('images/background.jpg') }}) repeat 0 0;
        }
    </style>

    <a class="navbar-brand" href="{{ url('/') }}">
        <img width="90px" src="{{ asset('images/logo.jpeg') }}" alt="Logo">
    </a>

    <h5>Ups! Página no encontrada.</h5>

    <img width="640px" src="{{ asset('images/error-404-1252056_1280.png') }}" alt="Error">
@endsection




