@extends('layouts.panel')

@section('titulo', 'Asistencia')

@section('content')
<div class="pf-page-header">
    <h1>Asistencia</h1>
</div>

<div class="pf-card" style="border-color: {{ $ok ? '#2e7d32' : '#c0392b' }}; background: {{ $ok ? '#eaf6ec' : '#fdecea' }}; text-align:center; padding:28px;">
    <p style="font-size:16px; margin:0;">{{ $mensaje }}</p>
</div>

<div style="text-align:center; margin-top:14px;">
    <a href="{{ route('bolsadetrabajo.asistencia.index') }}" class="btn btn-primary btn-sm">Ver mi asistencia</a>
</div>
@endsection
