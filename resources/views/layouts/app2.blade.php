<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bolsa de Trabajo ISFT N°38</title>
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

<!-- Plantilla base del sitio que carga estilos, íconos y scripts, muestra notificaciones con Flasher, y define un header con navegación dinámica según el rol del usuario y un contenedor principal para el contenido -->




<body>

    <header id="panel-navbar">
        <div class="logo">
            <a href="http://www.isft38.edu.ar/novedades">
                <img src="/images/logo_isft.png" alt="Logo">
            </a>
        </div>


        <nav>
            <ul>
                @auth('usuarios')
                    @php($rolNav = auth('usuarios')->user()->rol)
                    <li>
                        <a href="{{ route('bolsadetrabajo.panel') }}">
                            <i class="ri-dashboard-line{{ request()->routeIs('bolsadetrabajo.panel') ? ' selected' : '' }}"></i>
                            <span>Panel</span>
                        </a>
                    </li>

                    @if($rolNav === 'usuario')
                        <li>
                            <a href="{{ route('bolsadetrabajo.alumno.materias.index') }}">
                                <i class="ri-book-2-line{{ request()->routeIs('bolsadetrabajo.alumno.materias.*') ? ' selected' : '' }}"></i>
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

                    @if(in_array($rolNav, ['profesor', 'administrador', 'superadministrador'], true))
                        <li>
                            <a href="{{ route('bolsadetrabajo.profesor.materias.index') }}">
                                <i class="ri-book-open-line{{ request()->routeIs('bolsadetrabajo.profesor.materias.*') ? ' selected' : '' }}"></i>
                                <span>{{ $rolNav === 'superadministrador' ? 'Materias' : 'Mis materias' }}</span>
                            </a>
                        </li>
                        @if($rolNav !== 'superadministrador')
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
                        @endif
                    @endif

                    @if($rolNav === 'administrador')
                        <li>
                            <a href="/bolsadetrabajo/dashboard">
                                <i class="ri-settings-2-line{{ request()->is('bolsadetrabajo/dashboard') ? ' selected' : '' }}"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @endif

                    @if(in_array($rolNav, ['profesor', 'administrador', 'superadministrador'], true))
                        <li>
                            <a href="{{ route('bolsadetrabajo.profesor.mesas.index') }}">
                                <i class="ri-file-list-3-line{{ request()->routeIs('bolsadetrabajo.profesor.mesas.*') ? ' selected' : '' }}"></i>
                                <span>Inscriptos a mesas</span>
                            </a>
                        </li>
                    @endif

                    @if(in_array($rolNav, ['preceptor', 'superadministrador'], true))
                        <li>
                            <a href="{{ route('bolsadetrabajo.preceptor.carreras') }}">
                                <i class="ri-school-line{{ request()->routeIs('bolsadetrabajo.preceptor.carreras') ? ' selected' : '' }}"></i>
                                <span>Carreras{{ $rolNav === 'superadministrador' ? ' (preceptor)' : '' }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bolsadetrabajo.preceptor.alumnos.index') }}">
                                <i class="ri-group-line{{ request()->routeIs('bolsadetrabajo.preceptor.alumnos.*') ? ' selected' : '' }}"></i>
                                <span>Alumnos</span>
                            </a>
                        </li>
                    @endif

                    @if(in_array($rolNav, ['usuario', 'superadministrador'], true))
                        <li>
                            <a href="{{ route('bolsadetrabajo.alumno.mesas.index') }}">
                                <i class="ri-file-list-3-line{{ request()->routeIs('bolsadetrabajo.alumno.mesas.*') ? ' selected' : '' }}"></i>
                                <span>Mesas</span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('bolsadetrabajo.home') }}">
                            <i class="ri-briefcase-line{{ request()->routeIs('bolsadetrabajo.home') ? ' selected' : '' }}"></i>
                            <span>Bolsa de trabajo</span>
                        </a>
                    </li>
                    <li>
                        <form id="logout-form-app2" action="{{ route('bolsadetrabajo.logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-app2').submit();">
                            <i class="ri-logout-box-r-line"></i>
                            <span>Salir</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="/bolsadetrabajo/home">
                            <i class="ri-home-2-line{{ request()->is('bolsadetrabajo/home') ? ' selected' : '' }}"></i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="/bolsadetrabajo/busqueda">
                            <i class="ri-search-2-line{{ request()->is('bolsadetrabajo/busqueda') ? ' selected' : '' }}"></i>
                            <span>Búsqueda</span>
                        </a>
                    </li>
                    <li>
                        <a href="/bolsadetrabajo/guardar">
                            <i class="ri-bookmark-line{{ request()->is('bolsadetrabajo/guardar') ? ' selected' : '' }}"></i>
                            <span>Guardados</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>

        <!-- <div class="salir-sesion">
            <a href="{{ route('logout') }}">
                <i class="ri-logout-box-r-line"></i>
                <span>Cerrar Sesión</span>
            </a>
        </div> -->
    </header>


    <main class="editar-perfil-ya-creado">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app2.js') }}"></script>
</body>

</html>