@extends('errors::layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
    <style type="text/css">
        body {
            background:url({{ asset('images/background.jpg') }}) repeat 0 0;
        }
    </style>

    <a class="navbar-brand" href="{{ url('/') }}">
        <img width="60px" src="{{ asset('images/logo.jpeg') }}" alt="Logo">
    </a>

    <h5>Ups! Parece que algo falló...</h5>

    <img width="800px" src="{{ asset('images/error-500-server.png') }}" alt="Error">
@endsection

