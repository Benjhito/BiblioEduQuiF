<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/web2py-bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('images/logo.ico') }}" rel="icon" type="image/png">

    @livewireStyles
</head>
<body>
    <div id="app">
        @include('layouts.navigation')
        @if(session("success"))
            <div class="container-fluid mt-3">
                <div class="d-flex alert alert-success alert-dismissible fade show shadow-sm justify-content-center" role="alert">
                    <img width="25px" src="{{ asset('images/icons8-evaluaciones-32.png') }}" alt="Info">
                    <span class="text-success ml-3 mb-0">{{ session("success") }}</span>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="container-fluid mt-3">
                <div class="d-flex alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="align-self-center">
                        <img width="25px" src="{{ asset('images/icons8-general-warning-sign-48.png') }}" alt="Warning" class="">
                    </div>
                    <ul class="d-flex flex-column align-self-center list-unstyled ml-4 mb-0">
                        @foreach ($errors->all() as $error)
                            <span class="text-danger"><li>- {{ $error }}</li></span>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <main class="container-fluid main-container">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        @include('layouts.footer')

        @livewireScripts
    </div>
</body>
</html>

<style>
    body {
        background-color: #F2F3F4;
    }

    input[type=number] {
        text-align: right;
    }
</style>
