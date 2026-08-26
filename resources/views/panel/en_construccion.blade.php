@extends('layouts.panel')

@section('titulo', $titulo)

@section('content')
<div class="pf-card" style="text-align:center; padding: 40px 22px;">
    <i class="ri-tools-line" style="font-size: 2.5rem; color: #c9c8c6;"></i>
    <h3 style="margin-top: 14px;">{{ $titulo }}</h3>
    <p class="pf-muted" style="margin-bottom:0;">{{ $mensaje }}</p>
</div>
@endsection
