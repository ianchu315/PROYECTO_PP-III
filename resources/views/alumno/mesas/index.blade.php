@extends('layouts.panel')

@section('titulo', 'Mesas')

@section('content')
<div class="pf-page-header">
    <h1>Mesas finales — Inscripción</h1>
</div>

@if(session('success'))
    <div class="pf-card" style="border-color:#2e7d32; background:#eaf6ec;">
        <p class="mb-0">{{ session('success') }}</p>
    </div>
@endif
@if(session('error'))
    <div class="pf-card" style="border-color:#c0392b; background:#fbebe9;">
        <p class="mb-0">{{ session('error') }}</p>
    </div>
@endif

@if(!$mostrar)
    <div class="pf-card">
        <p class="pf-muted mb-0">Las mesas todavía no están disponibles.</p>
    </div>
@elseif($mesas->isEmpty())
    <div class="pf-card">
        <p class="pf-muted mb-0">No hay mesas cargadas para tu carrera por el momento.</p>
    </div>
@else
    @foreach($mesas as $fecha => $mesasPorFecha)
        <div class="pf-card">
            <h3>{{ mb_strtoupper(\Carbon\Carbon::parse($fecha)->translatedFormat('l d/m')) }}</h3>

            <div class="pf-table-wrap">
                <table class="pf-table pf-table-mesas">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Presidente</th>
                            <th>Vocal</th>
                            <th>Salón</th>
                            <th class="pf-col-accion">Inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mesasPorFecha as $mesa)
                            <tr>
                                <td>{{ $mesa->materia->descripcion ?? '-' }}</td>
                                <td>{{ $mesa->profesor->apellido ?? '-' }}, {{ $mesa->profesor->nombre ?? '-' }}</td>
                                <td>{{ $mesa->vocal->apellido ?? '-' }}, {{ $mesa->vocal->nombre ?? '-' }}</td>
                                <td>{{ $mesa->Salon->numero_salon ?? '-' }}</td>
                                <td class="pf-col-accion">
                                    @if($inscriptoEnMap->has($mesa->id))
                                        <span class="pf-chip pf-chip-ok">Ya inscripto</span>
                                    @elseif($canRegisterMap[$mesa->id] ?? false)
                                        <a href="{{ route('frontend.mesas.inscribir.confirmar', $mesa) }}" class="pf-chip pf-chip-accion">
                                            Inscribirme
                                        </a>
                                    @else
                                        <span class="pf-chip pf-chip-muted">No disponible</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endif
@endsection
