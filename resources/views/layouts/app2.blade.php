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

    <header id="navbar">
        <div class="logo">
            <a href="http://www.isft38.edu.ar/novedades">
                <img src="/images/logo_isft.png" alt="Logo">
            </a>
        </div>


        <nav>
            <ul>
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
                @auth('usuarios')
                    @if(auth('usuarios')->user()->rol === 'administrador')
                        <li>
                            <a href="/bolsadetrabajo/dashboard">
                                <i class="ri-settings-2-line{{ request()->is('bolsadetrabajo/dashboard') ? ' selected' : '' }}"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bolsadetrabajo.profesor.mesas.index') }}">
                                <i class="ri-file-list-3-line{{ request()->is('bolsadetrabajo/profesor/mesas*') ? ' selected' : '' }}"></i>
                                <span>Alumnos inscriptos a mesas</span>
                            </a>
                        </li>
                    @else
                        @if(auth('usuarios')->user()->rol === 'profesor')
                            <li>
                                <a href="{{ route('bolsadetrabajo.profesor.materias.index') }}">
                                    <i class="ri-book-2-line{{ request()->is('bolsadetrabajo/profesor/materias*') ? ' selected' : '' }}"></i>
                                    <span>Mis materias</span>
                                </a>
                            </li>
                        @endif
                        @if(in_array(auth('usuarios')->user()->rol, ['profesor', 'superadministrador']))
                            <li>
                                <a href="{{ route('bolsadetrabajo.profesor.mesas.index') }}">
                                    <i class="ri-file-list-3-line{{ request()->is('bolsadetrabajo/profesor/mesas*') ? ' selected' : '' }}"></i>
                                    <span>Alumnos inscriptos a mesas</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="/bolsadetrabajo/perfil">
                                <i class="ri-user-line{{ request()->is('bolsadetrabajo/perfil') ? ' selected' : '' }}"></i>
                                <span>Perfil</span>
                            </a>
                        </li>
                    @endif
                @endauth
                <li>
                    <form id="logout-form" action="{{ route('bolsadetrabajo.logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>

                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ri-logout-box-r-line"></i>
                        <span>Salir</span>
                    </a>
                </li>

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