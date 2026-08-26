<!-- Plantilla base de autenticación que carga estilos, íconos y scripts, muestra notificaciones con Flasher y define un contenedor dinámico para el contenido.
 -->


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Autenticación - Bolsa de Trabajo ISFT N°38</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app_2.css') }}">




    <link rel="shortcut icon" href="/images/favicon_isft.ico" type="image/x-icon">
</head>

<body>
 
    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app2.js') }}"></script>
</body>

</html>