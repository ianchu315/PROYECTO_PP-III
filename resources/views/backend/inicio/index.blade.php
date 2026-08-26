@extends('backend.layouts.main')

@section('title', 'Inicio Backend')

@section('content')
<style>
    /* --- Estilos generales --- */
    body {
        font-family: 'Segoe UI', sans-serif;
        transition: background 0.5s ease, color 0.5s ease;
    }

    /* --- Modo Noche --- */
    body.night-mode {
        background: linear-gradient(135deg, #1f2937, #111827);
        color: #f3f4f6;
    }

    /* --- Modo Día --- */
    body.day-mode {
        background: linear-gradient(135deg, #f9fafb, #e5e7eb);
        color: #1f2937;
    }

    /* --- Título con brillo --- */
    .welcome-title {
        font-size: 2.5rem;
        font-weight: bold;
        background: linear-gradient(90deg, #00c6ff, #0072ff, #00c6ff);
        background-size: 300%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shine 6s linear infinite;
    }

    @keyframes shine {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* --- Tarjeta central --- */
    .welcome-card {
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.5s ease;
    }

    body.night-mode .welcome-card {
        background: rgba(31, 41, 55, 0.9);
    }

    body.day-mode .welcome-card {
        background: #ffffff;
    }

    .welcome-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.4);
    }

    .welcome-text {
        font-size: 1.1rem;
    }

    
    .toggle-btn {
        position: fixed; 
        bottom: 20px;
        right: 20px;
        border: none;
        padding: 10px 15px;
        border-radius: 50px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease, color 0.3s ease;
        z-index: 1000;


    body.night-mode .toggle-btn {
        background: #f3f4f6;
        color: #111827;
    }

    body.day-mode .toggle-btn {
        background: #111827;
        color: #f3f4f6;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="welcome-card text-center">
        <h1 class="welcome-title mb-4">
            Bienvenido {{ Auth::user()->name }}
        </h1>
        <p class="welcome-text">
            <strong>Panel de Administración</strong>.
        </p>
    </div>
</div>

<!-- Botón Día/Noche -->
<button class="toggle-btn" onclick="toggleMode()">🌙</button>

<script>
    // Cargar el modo guardado o por defecto
    document.body.classList.add(localStorage.getItem("theme") || "night-mode");

    function toggleMode() {
        if (document.body.classList.contains("night-mode")) {
            document.body.classList.replace("night-mode", "day-mode");
            localStorage.setItem("theme", "day-mode");
            document.querySelector(".toggle-btn").textContent = "🌙";
        } else {
            document.body.classList.replace("day-mode", "night-mode");
            localStorage.setItem("theme", "night-mode");
            document.querySelector(".toggle-btn").textContent = "☀️";
        }
    }

    // Ajustar ícono al cargar
    document.querySelector(".toggle-btn").textContent =
        document.body.classList.contains("night-mode") ? "☀️" : "🌙";
</script>
@endsection
