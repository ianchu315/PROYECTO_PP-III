@extends(Auth::guard('usuarios')->user()->rol === 'superadministrador' ? 'layouts.panel' : 'layouts.app2')

@section('titulo', 'Asistencia')

@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1>Asistencia</h1>
    </div>

    @if($materias->isEmpty())
        <div class="pf-card">
            <p class="pf-muted mb-0">
                @if(in_array(Auth::guard('usuarios')->user()->rol, ['superadministrador', 'administrador']))
                    Todavía no hay materias cargadas.
                @else
                    Todavía no tenés materias asignadas. Pedile al superadministrador que te las asigne.
                @endif
            </p>
        </div>
    @else
        @foreach($materias->groupBy('carrera_id') as $materiasCarrera)
            @php $carrera = $materiasCarrera->first()->deCarrera; @endphp
            <div class="pf-card" style="margin-bottom:14px;">
                <h3 style="margin-bottom:10px;">{{ $carrera->descripcion ?? 'Sin carrera' }}</h3>
                <div class="pf-table-wrap">
                    <table class="pf-table">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Alumnos inscriptos</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materiasCarrera as $materia)
                                <tr>
                                    <td>{{ $materia->descripcion }}</td>
                                    <td>{{ $materia->alumnos_inscriptos_count }}</td>
                                    <td style="display:flex; gap:8px;">
                                        <a href="{{ route('bolsadetrabajo.profesor.asistencia.planilla', $materia) }}" class="btn btn-primary btn-sm">Tomar asistencia</a>
                                        <a href="{{ route('bolsadetrabajo.profesor.asistencia.qr', $materia) }}" class="btn btn-secondary btn-sm">Generar QR</a>
                                        <a href="{{ route('bolsadetrabajo.profesor.asistencia.porcentajes', $materia) }}" class="btn btn-secondary btn-sm">Ver porcentajes</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
