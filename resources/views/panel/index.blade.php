@extends('layouts.panel')

@section('titulo', 'Panel')

@section('content')
<div class="pf-card" style="text-align:center; padding: 45px 22px;">
    <h1 style="margin-bottom: 8px;">Bienvenido de nuevo, {{ $usuario->nombre ?? $usuario->email }} 👋</h1>
    <p class="pf-muted" style="margin-bottom:0;">
        Usá el menú de arriba para moverte por las secciones disponibles para tu usuario.
    </p>
</div>
@endsection
