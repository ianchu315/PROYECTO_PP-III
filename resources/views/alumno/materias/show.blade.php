@extends('layouts.panel')

@section('titulo', $materia->descripcion)

@section('content')
<div class="pf-page-header">
    <div>
        <a href="{{ route('bolsadetrabajo.alumno.materias.index') }}" class="pf-muted">&larr; Mis materias</a>
        <h1 style="margin:8px 0 2px;">{{ $materia->descripcion }}</h1>
        <span class="pf-muted">{{ $materia->deCarrera->descripcion ?? 'Carrera sin asignar' }}</span>
    </div>
    <span class="pf-badge pf-badge-{{ $condicion }}">{{ ucfirst($condicion) }}</span>
</div>

<section class="pf-card alumno-curso-resumen">
    <div>
        <span class="alumno-curso-etiqueta">DOCENTE</span>
        <strong>{{ $materia->profesorUsuario ? $materia->profesorUsuario->nombre . ' ' . $materia->profesorUsuario->apellido : 'Sin docente asignado' }}</strong>
    </div>
    <div>
        <span class="alumno-curso-etiqueta">UNIDADES</span>
        <strong>{{ $unidades->count() }}</strong>
    </div>
    <div>
        <span class="alumno-curso-etiqueta">CALIFICACIONES</span>
        <strong>{{ $calificaciones->count() }}</strong>
    </div>
</section>

<div class="pf-page-header alumno-seccion-titulo">
    <h2>Contenido del curso</h2>
</div>

@if($unidades->isEmpty())
    <div class="pf-card">
        <p class="pf-muted mb-0">El docente todavía no publicó unidades ni materiales.</p>
    </div>
@else
    <div class="alumno-unidades">
        @foreach($unidades as $unidad)
            <details class="pf-card alumno-unidad">
                <summary>
                    <span class="alumno-unidad-numero">{{ str_pad($unidad->orden, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="alumno-unidad-titulo">
                        <strong>{{ $unidad->titulo }}</strong>
                        <small>{{ $unidad->recursos->count() }} {{ $unidad->recursos->count() === 1 ? 'recurso' : 'recursos' }}</small>
                    </span>
                    <i class="ri-arrow-down-s-line" aria-hidden="true"></i>
                </summary>
                @if($unidad->descripcion)
                    <p class="alumno-unidad-descripcion">{{ $unidad->descripcion }}</p>
                @endif
                @if($unidad->recursos->isEmpty())
                    <p class="pf-muted mb-0">Todavía no hay archivos en esta unidad.</p>
                @else
                    <ul class="alumno-recursos">
                        @foreach($unidad->recursos as $recurso)
                            <li>
                                <span class="alumno-recurso-icono"><i class="ri-file-text-line" aria-hidden="true"></i></span>
                                <span class="alumno-recurso-datos">
                                    <strong>{{ $recurso->nombre_original }}</strong>
                                    <small>{{ $recurso->tamano_bytes ? number_format($recurso->tamano_bytes / 1048576, 1) . ' MB' : 'Archivo' }}</small>
                                </span>
                                <a class="btn btn-secondary btn-sm" href="{{ route('bolsadetrabajo.materias.recursos.descargar', [$materia, $recurso]) }}">
                                    <i class="ri-download-line" aria-hidden="true"></i> Descargar
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </details>
        @endforeach
    </div>
@endif

<div class="pf-page-header alumno-seccion-titulo">
    <h2>Mis calificaciones</h2>
</div>

<div class="pf-card">
    @if($calificaciones->isEmpty())
        <p class="pf-muted mb-0">Todavía no hay calificaciones cargadas para esta materia.</p>
    @else
        <div class="pf-table-wrap">
            <table class="pf-table">
                <thead>
                    <tr>
                        <th>Evaluación</th>
                        <th>Instancia</th>
                        <th>Nota</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calificaciones as $calificacion)
                        @php
                            $tipo = $calificacion->tipo ?? 'cuatrimestre';
                            $tituloEvaluacion = $tipo === 'extra'
                                ? 'Recuperatorio'
                                : ($tipo === 'promediada' ? 'Promedio' : 'Nota de cursada');
                            $instancia = $tipo === 'cuatrimestre' && $calificacion->cuatrimestre
                                ? $calificacion->cuatrimestre . '° cuatrimestre' . ($calificacion->numero_nota ? ' · Nota ' . $calificacion->numero_nota : '')
                                : 'Final';
                        @endphp
                        <tr>
                            <td>{{ $tituloEvaluacion }}</td>
                            <td>{{ $instancia }}</td>
                            <td><strong>{{ $calificacion->nota ?? 'Pendiente' }}</strong></td>
                            <td>
                                @if($calificacion->nota === null)
                                    <span class="pf-muted">Pendiente</span>
                                @else
                                    <span class="pf-badge {{ $calificacion->aprobado ? 'alumno-nota-aprobada' : 'alumno-nota-pendiente' }}">
                                        {{ $calificacion->aprobado ? 'Aprobada' : 'En curso' }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    .alumno-curso-resumen {
        display: flex;
        flex-wrap: wrap;
        gap: 28px;
        align-items: center;
    }

    .alumno-curso-resumen > div {
        display: grid;
        gap: 3px;
    }

    .alumno-curso-etiqueta {
        color: #8a8a88;
        font-size: 10px;
        font-weight: 700;
    }

    .alumno-seccion-titulo {
        margin: 26px 0 12px;
    }

    .alumno-seccion-titulo h2 {
        margin: 0;
        font-size: 19px;
    }

    .alumno-unidades {
        display: grid;
        gap: 10px;
    }

    .alumno-unidad {
        margin: 0;
        padding: 0;
    }

    .alumno-unidad summary {
        display: flex;
        align-items: center;
        gap: 13px;
        list-style: none;
        cursor: pointer;
        padding: 15px 18px;
    }

    .alumno-unidad summary::-webkit-details-marker {
        display: none;
    }

    .alumno-unidad summary > i {
        margin-left: auto;
        color: #700101;
        font-size: 20px;
        transition: transform 180ms ease;
    }

    .alumno-unidad[open] summary > i {
        transform: rotate(180deg);
    }

    .alumno-unidad-numero {
        display: grid;
        place-items: center;
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        background: #f5f3f2;
        color: #700101;
        border-radius: 8px;
        font-weight: 700;
    }

    .alumno-unidad-titulo {
        display: grid;
        gap: 3px;
    }

    .alumno-unidad-titulo small,
    .alumno-recurso-datos small {
        color: #777;
        font-size: 12px;
    }

    .alumno-unidad-descripcion {
        margin: 0 18px 12px 69px;
        color: #555;
        white-space: pre-line;
    }

    .alumno-recursos {
        list-style: none;
        padding: 0 18px 16px;
        margin: 0;
        display: grid;
        gap: 8px;
    }

    .alumno-recursos li {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        border: 1px solid #eaeae9;
        border-radius: 8px;
        min-width: 0;
    }

    .alumno-recurso-icono {
        display: grid;
        place-items: center;
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        border-radius: 8px;
        background: #f5f3f2;
        color: #700101;
        font-size: 18px;
    }

    .alumno-recurso-datos {
        display: grid;
        gap: 3px;
        min-width: 0;
        flex: 1;
    }

    .alumno-recurso-datos strong {
        overflow-wrap: anywhere;
        font-size: 13px;
    }

    .alumno-nota-aprobada {
        background: #2e7d32;
    }

    .alumno-nota-pendiente {
        background: #8a8a88;
    }

    @media (prefers-reduced-motion: reduce) {
        .alumno-unidad summary > i {
            transition: none;
        }
    }

    @media (max-width: 600px) {
        .alumno-curso-resumen {
            gap: 16px;
        }

        .alumno-recursos li {
            flex-wrap: wrap;
        }

        .alumno-recurso-datos {
            flex-basis: calc(100% - 50px);
        }
    }
</style>
@endsection
