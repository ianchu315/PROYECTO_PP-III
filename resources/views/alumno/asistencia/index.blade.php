@extends('layouts.panel')

@section('titulo', 'Mi asistencia')

@section('content')
<div class="pf-page-header">
    <h1>Mi asistencia</h1>
    <a href="{{ route('bolsadetrabajo.asistencia.escaner') }}" class="btn btn-primary btn-sm">Escanear QR de clase</a>
</div>

<div class="pf-card" style="margin-bottom:14px;">
    <span class="pf-muted" style="font-size:13px;">Asistencia general</span><br>
    @if($porcentaje === null)
        <span class="pf-badge" style="background-color:#8a8a88;">Sin datos</span>
    @else
        <span class="pf-badge" style="background-color: {{ $porcentaje >= 75 ? '#2e7d32' : ($porcentaje >= 60 ? '#b8860b' : '#c62828') }};">
            {{ $porcentaje }}%
        </span>
    @endif
</div>

@if($materias->isEmpty())
    <div class="pf-card">
        <p class="pf-muted mb-0">Todavía no estás inscripto en ninguna materia.</p>
    </div>
@else
    @foreach($materias as $item)
        @php $materia = $item['materia']; @endphp
        <div class="pf-card" style="margin-bottom:14px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                <div>
                    <span class="pf-muted" style="font-size:12px;">{{ $materia->deCarrera->descripcion ?? '' }}</span>
                    <h3 style="margin:2px 0 0 0;">{{ $materia->descripcion }}</h3>
                </div>
                @if($item['porcentaje'] === null)
                    <span class="pf-badge" style="background-color:#8a8a88;">Sin datos</span>
                @else
                    <span class="pf-badge" style="background-color: {{ $item['porcentaje'] >= 75 ? '#2e7d32' : ($item['porcentaje'] >= 60 ? '#b8860b' : '#c62828') }};">
                        {{ $item['porcentaje'] }}%
                    </span>
                @endif
            </div>

            @if($item['ultimas']->isEmpty())
                <p class="pf-muted mb-0" style="font-size:13px;">Todavía no hay clases registradas en esta materia.</p>
            @else
                <div class="pf-table-wrap">
                    <table class="pf-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item['ultimas'] as $clase)
                                <tr>
                                    <td>{{ $clase->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $clase->etiqueta_estado }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="pf-muted mb-0" style="font-size:12px; margin-top:6px;">Se muestran las últimas 10 clases.</p>
                </div>
            @endif
        </div>
    @endforeach
@endif
@endsection
