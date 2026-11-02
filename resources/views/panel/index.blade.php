@extends('layouts.panel')

@section('titulo', 'Panel')

@section('content')

@if(session('success'))
    <div class="pf-card" style="border-color:#2e7d32; background:#eaf6ec;">
        <p class="mb-0">{{ session('success') }}</p>
    </div>
@endif

@if($esSuperadmin)
    {{-- Para el superadmin, la caja de "Bienvenido" pasa a ser este panel de
         2 secciones (profesores + usuarios) en vez del saludo genérico. --}}
    @include('partials.panel_admin_asignaciones')
@else
    <div class="pf-card" style="text-align:center; padding: 45px 22px;">
        <h1 style="margin-bottom: 8px;">Bienvenido de nuevo, {{ $usuario->nombre ?? $usuario->email }} 👋</h1>
        <p class="pf-muted" style="margin-bottom:0;">
            Usá el menú de arriba para moverte por las secciones disponibles para tu usuario.
        </p>
    </div>
@endif

@endsection
