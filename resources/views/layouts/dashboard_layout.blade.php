<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Bolsa de Trabajo ISFT N°38</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app_2.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



    <link rel="shortcut icon" href="/images/favicon_isft.ico" type="image/x-icon">
</head>

<!-- Plantilla de dashboard responsivo que incluye encabezados, sidebar con navegación, menú móvil con apertura/cierre, integración de Select2 y Chart.js, y secciones dinámicas para contenido. -->



<body class="dashboard_body">
  
    <header class="dashboard_header">

        <div class="dashboard_logo">
            <a href="http://www.isft38.edu.ar/novedades">
                <img src="/images/logo_isft.png" alt="Logo">
            </a>
        </div>


    </header>

    <header class="dashboard_header_mobile" id="dashboard_header_mobile">

        <button id="abrir-mobile">
            <i class="ri-menu-2-line"></i>
        </button>

        <nav id="nav-mobile">
            <button id="cerrar-mobile"><i class="ri-close-line"></i></button>
            <ul>

                <a href="/bolsadetrabajo/dashboard" class="{{ request()->is('bolsadetrabajo/dashboard') ? 'selected' : '' }}"><i class="ri-line-chart-line {{ request()->is('/bolsadetrabajo/dashboard') ? 'selected' : '' }}"></i>Dashboard</a>

                <a href="/bolsadetrabajo/ofertas" class="{{ request()->is('bolsadetrabajo/ofertas*') ? 'selected' : '' }}"><i class="ri-briefcase-4-line {{ request()->is('/bolsadetrabajo/ofertas*') ? 'selected' : '' }}"></i>Ofertas</a>

                <a href="/bolsadetrabajo/usuarios" class="{{ request()->is('bolsadetrabajo/usuarios*') ? 'selected' : '' }}"><i class="ri-group-line {{ request()->is('/bolsadetrabajo/usuarios*') ? 'selected' : '' }}"></i>Usuarios</a>

                <a href="/bolsadetrabajo/comunicaciones" class="{{ request()->is('bolsadetrabajo/comunicaciones*') ? 'selected' : '' }}"><i class="ri-mail-send-line {{ request()->is('/bolsadetrabajo/comunicaciones*') ? 'selected' : '' }}"></i>Comunicaciones</a>

                <a href="/bolsadetrabajo/configuracion" class="{{ request()->is('bolsadetrabajo/configuracion*') ? 'selected' : '' }}"><i class="ri-settings-4-line {{ request()->is('/bolsadetrabajo/configuracion*') ? 'selected' : '' }}"></i>Configuración</a>

                    {{-- <button onclick="window.location.href='{{ route('bolsadetrabajo.dashboard') }}'">Dashboard</button>

                    <button onclick="window.location.href='{{ route('bolsadetrabajo.ofertas') }}'">Ofertas</button>

                    <button onclick="window.location.href='{{ route('bolsadetrabajo.usuarios') }}'">Usuarios</button>

                    <button onclick="window.location.href='{{ route('bolsadetrabajo.comunicaciones') }}'">Comunicaciones</button>

                    <button onclick="window.location.href='{{ route('bolsadetrabajo.configuracion.index') }}'">Configuración</button> --}}

            </ul>
            <button class="dashboard_sidebar_volver_mobile" onclick="window.location.href='/bolsadetrabajo/home'"><i class="ri-arrow-left-line"></i>Volver al inicio</button>
        </nav>

        <div class="dashboard_logo_mobile">
            <a href="http://www.isft38.edu.ar/novedades">
                <img src="/images/logo_isft.png" alt="Logo" style="height: 50px;">
            </a>
        </div>
    </header>

    <script>
        const nav = document.querySelector('#nav-mobile');
        const abrir = document.querySelector('#abrir-mobile');
        const cerrar = document.querySelector('#cerrar-mobile');
        const body = document.body;

        abrir.addEventListener('click', () => {
            nav.classList.add('visible');
            body.classList.add('no-scroll'); // bloquear scroll
        });

        cerrar.addEventListener('click', () => {
            nav.classList.remove('visible');
            body.classList.remove('no-scroll'); // restaurar scroll
        });

        // Cerrar al hacer clic fuera
        document.addEventListener('click', (e) => {
            const esClickDentroNav = nav.contains(e.target);
            const esClickEnBoton = abrir.contains(e.target) || cerrar.contains(e.target);

            if (!esClickDentroNav && !esClickEnBoton) {
                nav.classList.remove('visible');
                body.classList.remove('no-scroll');
            }
        });
    </script>



    <div class="contenedor">

        <aside class="dashboard_sidebar">
            <nav>
                <button class="{{ request()->is('bolsadetrabajo/dashboard') ? 'selected' : '' }}" onclick="window.location.href='/bolsadetrabajo/dashboard'"><i class="ri-line-chart-line"></i>Dashboard</button>

                <button class="{{ request()->is('bolsadetrabajo/ofertas*') ? 'selected' : '' }}" onclick="window.location.href='/bolsadetrabajo/ofertas'"><i class="ri-briefcase-4-line"></i>Ofertas</button>

                <button class="{{ request()->is('bolsadetrabajo/usuarios*') ? 'selected' : '' }}" onclick="window.location.href='/bolsadetrabajo/usuarios'"><i class="ri-group-line"></i>Usuarios</button>

                <button class="{{ request()->is('bolsadetrabajo/comunicaciones*') ? 'selected' : '' }}" onclick="window.location.href='/bolsadetrabajo/comunicaciones'"><i class="ri-mail-send-line"></i>Comunicaciones</button>

                <button class="{{ request()->is('bolsadetrabajo/configuracion*') ? 'selected' : '' }}" onclick="window.location.href='/bolsadetrabajo/configuracion'"><i class="ri-settings-4-line"></i>Configuración</button>

                <button class="dashboard_sidebar_volver" onclick="window.location.href='/bolsadetrabajo/home'"><i class="ri-arrow-left-line"></i>Volver al inicio</button>
            </nav>
        </aside>


        <main>
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app2.js') }}"></script>
</body>

</html>