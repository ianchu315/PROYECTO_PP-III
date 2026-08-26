<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <!-- JS -->
    <script src ="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar-custom {
            background-color: #000000 !important;
        }

        .navbar-custom .nav-link {
            color: #ffffff !important;
            font-size: 0.9rem;
            padding: 6px 12px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-custom .nav-link:hover {
            background-color: #ffffff !important;
            color: #000000 !important;
            border-radius: 6px;
        }

        .logout-icon {
            font-size: 1.6rem !important; 
            color: #ffffff !important;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-icon:hover {
            color: #dddddd !important;
        }


        .navbar-brand img {
            height: 50px;
        }

        .Inicio {
            text-align: center;
            margin: 20px;
            font-weight: 800;
        }
    </style>

    <title>@yield('title')</title>
    @yield('scripts')
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="backend/inicio"><img src="{{ asset('img/logo.png') }}" alt="Logo"></a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @section('menu')
                    
                     @if (Auth::user()->is_admin == 1 )
                        <li class="nav-item"><a class="nav-link" href="{{ route('sede.index') }}">Sedes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('modulo.index') }}">Módulos</a></li>
                      @endif

                      @if (Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2)
                          <li class="nav-item"><a class="nav-link" href="{{ route('carrera.index') }}">Carreras</a></li>
                          <li class="nav-item"><a class="nav-link" href="{{ route('comision.index') }}">Comisiones</a></li>
                          <li class="nav-item"><a class="nav-link" href="{{ route('materia.index') }}">Materias</a></li>
                           <li class="nav-item"><a class="nav-link" href="{{ route('categoria.index') }}">Categorías</a></li>
                           <li class="nav-item"><a class="nav-link" href="{{ route('backend.correlativa.index') }}">Correlativas</a></li>
                      @endif
                      @if (Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2|| Auth::user()->is_admin == 3)
                            <li class="nav-item"><a class="nav-link" href="{{ route('horario.index') }}">Horarios</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('turnos.index') }}">Turnos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('cupos.index') }}">Cupos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('espera.index') }}">Lista Espera</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('ir_admin', ['date' => '']) }}">Pre-inscriptos</a></li>                             
                      @endif
                      @if (Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2)
                            <li class="nav-item"><a class="nav-link" href="{{ route('profesor.index') }}">Profesores</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('salones.index') }}">Salones</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('mesas.index') }}">Mesas</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('noticias.index') }}">Noticias</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('etiquetas.index') }}">Etiquetas</a></li>
                            
                     @endif
                     @if (Auth::user()->is_admin == 1)
                            <li class="nav-item"><a class="nav-link" href="{{ route('historia.index') }}">Historia</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('objetivo.index') }}">Objetivos</a></li>                           
                            <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Usuarios</a></li>
                      @endif   
                   @show
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link logout-icon" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                title="Cerrar sesión">
                                <i class="bi bi-box-arrow-right"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @yield('content')
    </div>

    
</body>

</html>
