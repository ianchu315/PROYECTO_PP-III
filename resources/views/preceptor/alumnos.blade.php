@extends('layouts.panel')

@section('titulo', 'Alumnos')

@section('content')
<div class="pf-page-header">
    <h1>Alumnos</h1>
</div>

<div class="pf-card">
    <form method="GET" action="{{ route('bolsadetrabajo.preceptor.alumnos.index') }}" class="pf-form-inline">
        <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por nombre, apellido o email...">

        <select name="carrera_id">
            <option value="">Todas mis carreras y alumnos sin carrera</option>
            <option value="sin_carrera" {{ $carreraId === 'sin_carrera' ? 'selected' : '' }}>Sin carrera asignada</option>
            @foreach($carreras as $carrera)
                <option value="{{ $carrera->id }}" {{ (string) $carreraId === (string) $carrera->id ? 'selected' : '' }}>
                    {{ $carrera->descripcion }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
    </form>
</div>

@if($alumnos->isEmpty())
    <div class="pf-card">
        <p class="pf-muted mb-0">No se encontraron alumnos con ese filtro.</p>
    </div>
@else
    <div class="pf-card pf-table-wrap">
        <table class="pf-table">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Email</th>
                    <th>Carrera</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                    <tr>
                        <td>{{ $alumno->apellido }}, {{ $alumno->nombre }}</td>
                        <td>{{ $alumno->email }}</td>
                        <td>{{ $alumno->carrera->descripcion ?? '-' }}</td>
                        <td>
                            <a href="{{ route('bolsadetrabajo.preceptor.alumnos.show', $alumno) }}" class="btn btn-primary btn-sm">
                                Gestionar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:14px;">
        {{ $alumnos->links() }}
    </div>
@endif
@endsection
