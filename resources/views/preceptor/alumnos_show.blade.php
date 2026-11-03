@extends('layouts.panel')

@section('titulo', $alumno->apellido . ', ' . $alumno->nombre)

@section('content')
<div class="pf-page-header">
    <h1>{{ $alumno->apellido }}, {{ $alumno->nombre }}</h1>
    <a href="{{ route('bolsadetrabajo.preceptor.alumnos.index') }}" class="pf-muted" style="font-size:13px;">&larr; Volver al listado de alumnos</a>
</div>

<div class="pf-card">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <div>
            <p class="pf-muted mb-0">{{ $alumno->email }}</p>
            <p class="pf-muted mb-0">Carrera: {{ $alumno->carrera->descripcion ?? 'Sin carrera asignada' }}</p>
        </div>
        <div>
            <span class="pf-muted" style="font-size:13px;">Asistencia general</span><br>
            @if($asistenciaGeneral === null)
                <span class="pf-badge" style="background-color:#8a8a88;">Sin datos</span>
            @else
                <span class="pf-badge" style="background-color: {{ $asistenciaGeneral >= 75 ? '#2e7d32' : ($asistenciaGeneral >= 60 ? '#b8860b' : '#c62828') }};">
                    {{ $asistenciaGeneral }}%
                </span>
            @endif
        </div>
    </div>
</div>

<div class="pf-card">
    <h3>Asignar carrera</h3>
    @if($carreras->isEmpty())
        <p class="pf-muted mb-0">No tenés carreras asignadas. Pedile al superadministrador que te asigne una.</p>
    @else
        <form method="POST" action="{{ route('bolsadetrabajo.preceptor.alumnos.asignarCarrera', $alumno) }}" class="pf-form-inline">
            @csrf
            <select name="carrera_id" required>
                <option value="" disabled {{ $alumno->carrera_id ? '' : 'selected' }}>Seleccionar carrera</option>
                @foreach($carreras as $carrera)
                    <option value="{{ $carrera->id }}" {{ (string) $alumno->carrera_id === (string) $carrera->id ? 'selected' : '' }}>
                        {{ $carrera->descripcion }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Guardar carrera</button>
        </form>
        @error('carrera_id')
            <p class="pf-muted mb-0" style="color:#c62828;">{{ $message }}</p>
        @enderror
    @endif
</div>

{{-- Asignar una nueva materia de la carrera del alumno --}}
<div class="pf-card">
    <h3>Asignar materia</h3>
    @if(!$alumno->carrera_id)
        <p class="pf-muted mb-0">El alumno no tiene carrera asignada; pedile al superadministrador que se la asigne antes de sumarle materias.</p>
    @elseif($materiasDisponibles->isEmpty())
        <p class="pf-muted mb-0">Ya está asignado a todas las materias de su carrera.</p>
    @else
        <form method="POST" action="{{ route('bolsadetrabajo.preceptor.alumnos.asignarMateria', $alumno) }}" class="pf-form-inline">
            @csrf
            @include('partials.filtro_rapido', ['target' => '#select-materia-alta', 'placeholder' => 'Filtrar materias...'])
            <select name="materia_id" id="select-materia-alta" required>
                <option value="" selected disabled>Seleccionar materia</option>
                @foreach($materiasDisponibles as $materia)
                    <option value="{{ $materia->id }}">{{ $materia->descripcion }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Asignar</button>
        </form>
        @error('materia_id')
            <p class="pf-muted mb-0" style="color:#c62828;">{{ $message }}</p>
        @enderror
    @endif
</div>

<div class="pf-page-header" style="margin-top:24px;">
    <h2>Materias asignadas</h2>
</div>

@if($materiasData->isEmpty())
    <div class="pf-card">
        <p class="pf-muted mb-0">Este alumno todavía no tiene materias asignadas.</p>
    </div>
@else
    @foreach($materiasData as $item)
        @php $materia = $item['materia']; @endphp
        <div class="pf-card" id="materia-{{ $materia->id }}">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:10px;">
                <div>
                    <h3 style="margin-bottom:2px;">{{ $materia->descripcion }}</h3>
                    <span class="pf-muted" style="font-size:13px;">{{ $materia->deCarrera->descripcion ?? '-' }}</span>
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <span class="pf-badge pf-badge-{{ $item['condicion'] }}">{{ ucfirst($item['condicion']) }}</span>
                    @if($item['asistencia'] === null)
                        <span class="pf-badge" style="background-color:#8a8a88;">Asistencia: sin datos</span>
                    @else
                        <span class="pf-badge" style="background-color: {{ $item['asistencia'] >= 75 ? '#2e7d32' : ($item['asistencia'] >= 60 ? '#b8860b' : '#c62828') }};">
                            Asistencia: {{ $item['asistencia'] }}%
                        </span>
                    @endif
                    <form method="POST" action="{{ route('bolsadetrabajo.preceptor.alumnos.quitarMateria', [$alumno, $materia]) }}" onsubmit="return confirm('¿Quitar esta materia? Se borran sus notas y asistencia cargadas.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Quitar</button>
                    </form>
                </div>
            </div>

            {{-- Notas: de solo lectura. Las carga el profesor a cargo de la materia. --}}
            <div style="margin-top:16px;">
                <h4 style="font-size:14px; margin-bottom:8px;">Notas</h4>
                <div class="pf-table-wrap">
                    <table class="pf-table">
                        <thead>
                            <tr>
                                <th>1° cuatrimestre</th>
                                <th>2° cuatrimestre</th>
                                <th>Promediada</th>
                                <th>Extra / recuperatorio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach([1, 2] as $cuatrimestre)
                                    <td>{{ optional($item['notas']->firstWhere('cuatrimestre', $cuatrimestre))->nota ?? '-' }}</td>
                                @endforeach
                                <td>{{ optional($item['notaPromediada'])->nota ?? '-' }}</td>
                                <td>{{ optional($item['notaExtra'])->nota ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Asistencia: de solo lectura. La carga el profesor a cargo de la materia. --}}
            <div style="margin-top:16px;">
                <h4 style="font-size:14px; margin-bottom:8px;">Asistencia</h4>
                <p class="pf-muted mb-0" style="font-size:12px; margin-bottom:8px;">La carga el profesor a cargo de la materia. Acá solo se puede consultar.</p>

                @if($item['ultimasClases']->isEmpty())
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
                                @foreach($item['ultimasClases'] as $clase)
                                    <tr>
                                        <td>{{ $clase->fecha->format('d/m/Y') }}</td>
                                        <td>{{ $clase->etiqueta_estado }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p class="pf-muted mb-0" style="font-size:12px; margin-top:6px;">Se muestran las últimas 10 clases registradas.</p>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
@endif
@endsection
