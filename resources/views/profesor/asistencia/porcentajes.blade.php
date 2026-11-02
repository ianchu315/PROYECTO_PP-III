@extends(Auth::guard('usuarios')->user()->rol === 'superadministrador' ? 'layouts.panel' : 'layouts.app2')

@section('titulo', 'Porcentajes - ' . $materia->descripcion)

@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1>{{ $materia->descripcion }} — porcentajes</h1>
        <a href="{{ route('bolsadetrabajo.profesor.asistencia.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>

    <div class="pf-card">
        <p class="pf-muted" style="font-size:13px;">
            Se calcula solo a partir de las planillas diarias cargadas; no hace falta ningún paso extra.
        </p>

        @if($alumnos->isEmpty())
            <p class="pf-muted mb-0">Esta materia todavía no tiene alumnos inscriptos.</p>
        @else
            @include('partials.filtro_rapido', ['target' => '#tabla-porcentajes', 'celdas' => 1, 'placeholder' => 'Buscar alumno...'])

            <div class="pf-table-wrap">
                <table class="pf-table" id="tabla-porcentajes">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>% de asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumnos as $alumno)
                            <tr>
                                <td>{{ $alumno->apellido }}, {{ $alumno->nombre }}</td>
                                <td>
                                    @if($alumno->asistencia_materia === null)
                                        <span class="pf-badge" style="background-color:#8a8a88;">Sin datos</span>
                                    @else
                                        <span class="pf-badge" style="background-color: {{ $alumno->asistencia_materia >= 75 ? '#2e7d32' : ($alumno->asistencia_materia >= 60 ? '#b8860b' : '#c62828') }};">
                                            {{ $alumno->asistencia_materia }}%
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
</div>
@endsection
