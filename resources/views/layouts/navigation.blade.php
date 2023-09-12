<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm px-3">
    <!--div class="container"-->
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="rounded" width="90px" src="{{ asset('images/logo.jpeg') }}" alt="Logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Socios</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('members.index') }}">Gestión de Socios</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Proveedores</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('providers.index') }}">Gestión de Proveedores</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Libros</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('books.index') }}">Gestión de Libros</a>
                        <a class="dropdown-item" href="{{ route('publishers.index') }}">Gestión de Editoriales</a>
                        <a class="dropdown-item" href="{{ route('categories.index') }}">Gestión de Categorías</a>
                        <a class="dropdown-item" href="{{ route('collections.index') }}">Gestión de Colecciones</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ingresos</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('entries.create') }}">Carga de Libros Recibidos</a>
                        <a class="dropdown-item" href="{{ route('entries.index') }}">Consulta de Libros Recibidos</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Préstamos</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('loans.create') }}">Nuevo Préstamo</a>
                        <a class="dropdown-item" href="{{ route('loans.index') }}">Consulta de Préstamos</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reservas</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('reservations.index') }}">Nueva Reserva</a>
                        <a class="dropdown-item" href="{{ route('reservations.index') }}">Consulta de Reservas</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Devoluciones</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('devolutions.create') }}">Nueva Devolución</a>
                        <a class="dropdown-item" href="{{ route('devolutions.index') }}">Consulta de Devoluciones</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Stock</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('stocks.index') }}">Control de Stock</a>
                    </div>
                </li>
                {{--
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Informes</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item disabled" href="#">Egresos de Caja</a>
                        <div class="dropdown-divider disabled"></div>
                        <a class="dropdown-item disabled" href="#">Depósitos Bancarios</a>
                        <a class="dropdown-item disabled" href="#">Ctas. Ctes. Bancarias</a>
                    </div>
                </li>
                --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mantenimiento</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item disabled" href="#">Configuración</a>
                        <a class="dropdown-item disabled" href="#">Respaldo BD</a>
                    </div>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Ingresar</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->username }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Salir
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    <!--/div-->
</nav>
