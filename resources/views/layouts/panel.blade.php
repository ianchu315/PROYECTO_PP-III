<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'Panel') - Bolsa de Trabajo ISFT N°38</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app_2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}">
    <link rel="shortcut icon" href="/images/favicon_isft.ico" type="image/x-icon">
    @yield('estilos_extra')
</head>

<!-- Dashboard nuevo post-login: mismo header/paleta que el resto de bolsa de
     trabajo (app_2.css), pero con nav propia según el rol logueado. -->

<body>

@php
    $usuarioPanel = Auth::guard('usuarios')->user();
    $rolPanel = $usuarioPanel->rol ?? null;
    $esSuperadmin = $rolPanel === 'superadministrador';
@endphp

<header id="panel-navbar" class="{{ $esSuperadmin && request()->routeIs('bolsadetrabajo.panel') ? 'panel-navbar-amplio' : '' }}">
    <div class="logo">
        <a href="{{ route('novedades') }}" aria-label="Ir a novedades del instituto">
            <img src="/images/logo_isft.png" alt="Logo">
        </a>
    </div>

    <nav>
        <ul>
            <li>
                <a href="{{ route('bolsadetrabajo.panel') }}">
                    <i class="ri-dashboard-line{{ request()->routeIs('bolsadetrabajo.panel') ? ' selected' : '' }}"></i>
                    <span>Panel</span>
                </a>
            </li>

            {{-- ===== ALUMNO ===== --}}
            @if($esSuperadmin || $rolPanel === 'usuario')
                @if($rolPanel === 'usuario')
                <li>
                    <a href="{{ route('bolsadetrabajo.alumno.materias.index') }}">
                        <i class="ri-book-2-line{{ request()->routeIs('bolsadetrabajo.alumno.materias.index') ? ' selected' : '' }}"></i>
                        <span>Mis materias</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bolsadetrabajo.asistencia.index') }}">
                        <i class="ri-calendar-check-line{{ request()->routeIs('bolsadetrabajo.asistencia.index') ? ' selected' : '' }}"></i>
                        <span>Mi asistencia</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('bolsadetrabajo.alumno.mesas.index') }}">
                        <i class="ri-file-list-3-line{{ request()->routeIs('bolsadetrabajo.alumno.mesas.*') ? ' selected' : '' }}"></i>
                        <span>Mesas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bolsadetrabajo.home') }}">
                        <i class="ri-briefcase-line"></i>
                        <span>Bolsa de trabajo</span>
                    </a>
                </li>
            @endif

            {{-- ===== PROFESOR / ADMINISTRADOR ===== --}}
            @if($esSuperadmin || $rolPanel === 'profesor' || $rolPanel === 'administrador')
                <li>
                    <a href="{{ route('bolsadetrabajo.profesor.materias.index') }}">
                        <i class="ri-book-open-line{{ request()->routeIs('bolsadetrabajo.profesor.materias.*') ? ' selected' : '' }}"></i>
                        <span>{{ $esSuperadmin ? 'Materias' : 'Mis materias' }}</span>
                    </a>
                </li>
                @unless($esSuperadmin)
                <li>
                    <a href="{{ route('bolsadetrabajo.profesor.asistencia.index') }}">
                        <i class="ri-calendar-check-line{{ request()->routeIs('bolsadetrabajo.profesor.asistencia.*') ? ' selected' : '' }}"></i>
                        <span>Asistencia</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bolsadetrabajo.profesor.materias.index') }}">
                        <i class="ri-edit-2-line"></i>
                        <span>Notas</span>
                    </a>
                </li>
                @endunless
            @endif

            {{-- ===== PROFESOR / ADMINISTRADOR / SUPERADMIN: inscriptos a mesas ===== --}}
            @if($esSuperadmin || $rolPanel === 'administrador' || $rolPanel === 'profesor')
                <li>
                    <a href="{{ route('bolsadetrabajo.profesor.mesas.index') }}">
                        <i class="ri-file-list-3-line{{ request()->routeIs('bolsadetrabajo.profesor.mesas.*') ? ' selected' : '' }}"></i>
                        <span>Inscriptos a mesas</span>
                    </a>
                </li>
            @endif

            {{-- ===== PRECEPTOR ===== --}}
            @if($esSuperadmin || $rolPanel === 'preceptor')
                <li>
                    <a href="{{ route('bolsadetrabajo.preceptor.carreras') }}">
                        <i class="ri-school-line{{ request()->routeIs('bolsadetrabajo.preceptor.carreras') ? ' selected' : '' }}"></i>
                        <span>Carreras{{ $esSuperadmin ? ' (preceptor)' : '' }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bolsadetrabajo.preceptor.alumnos.index') }}">
                        <i class="ri-group-line{{ request()->routeIs('bolsadetrabajo.preceptor.alumnos.*') ? ' selected' : '' }}"></i>
                        <span>Alumnos</span>
                    </a>
                </li>
            @endif

            <li>
                <form id="logout-form-panel" action="{{ route('bolsadetrabajo.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-panel').submit();">
                    <i class="ri-logout-box-r-line"></i>
                    <span>Salir</span>
                </a>
            </li>
        </ul>
    </nav>
</header>

<main class="pf-page {{ $esSuperadmin && request()->routeIs('bolsadetrabajo.panel') ? 'pf-page-amplio' : '' }}">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
