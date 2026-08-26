@extends('layouts.app2')

@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1>Mis materias</h1>
    </div>

    @if($materias->isEmpty())
        <div class="pf-card">
            <p class="pf-muted mb-0">Todavía no tenés materias asignadas. Un admin puede asignarte una puntualmente, o si tu perfil tiene una carrera cargada, van a aparecer acá automáticamente las materias de esa carrera.</p>
        </div>
    @else
        <div class="pf-card pf-table-wrap">
            <table class="pf-table">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Carrera</th>
                        <th>Origen</th>
                        <th>Alumnos inscriptos</th>
                        <th>Notas por cuatrimestre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materias as $materia)
                        <tr>
                            <td>{{ $materia->descripcion }}</td>
                            <td>{{ $materia->deCarrera->descripcion ?? '-' }}</td>
                            <td><span class="pf-muted">{{ $materia->origen }}</span></td>
                            <td>{{ $materia->alumnosInscriptos()->count() }}</td>
                            <td>
                                @if($materia->notas_configuradas)
                                    {{ $materia->cantidad_notas_cuatrimestre }}
                                @else
                                    <span class="pf-muted">Sin configurar</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('bolsadetrabajo.profesor.materias.show', $materia) }}" class="btn btn-primary">
                                    Gestionar notas
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
