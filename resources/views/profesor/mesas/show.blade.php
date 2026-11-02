@extends(in_array(Auth::guard('usuarios')->user()->rol, ['administrador', 'superadministrador']) ? 'layouts.panel' : 'layouts.app2')

@section('titulo', 'Alumnos inscriptos a mesa')

@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1>{{ $mesa->materia->descripcion ?? 'Mesa' }}</h1>
        <a href="{{ route('bolsadetrabajo.profesor.mesas.index') }}" class="btn btn-secondary">Volver a mesas</a>
    </div>

    <div class="pf-card">
        <p><strong>Carrera:</strong> {{ $mesa->carrera->descripcion ?? '-' }}</p>
        <p><strong>Fecha:</strong> {{ $mesa->fecha }}</p>
        <p class="mb-0"><strong>Horario:</strong> {{ $mesa->horario ?? '-' }}</p>
    </div>

    <div class="pf-card">
        <h3>Alumnos inscriptos ({{ $inscriptos->count() }})</h3>

        @if($inscriptos->isEmpty())
            <p class="pf-muted mb-0">Todavía no hay alumnos inscriptos en esta mesa.</p>
        @else
            @include('partials.filtro_rapido', ['target' => '#tabla-inscriptos', 'placeholder' => 'Buscar por nombre, email o DNI...'])

            <div class="pf-table-wrap">
                <table class="pf-table" id="tabla-inscriptos">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Email</th>
                            <th>DNI</th>
                            <th>Condición</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inscriptos as $inscripcion)
                            <tr>
                                <td>{{ $inscripcion->usuario->apellido ?? '-' }}, {{ $inscripcion->usuario->nombre ?? '-' }}</td>
                                <td>{{ $inscripcion->usuario->email ?? '-' }}</td>
                                <td>{{ $inscripcion->usuario->dni ?? '-' }}</td>
                                <td>
                                    <span class="pf-badge pf-badge-{{ $inscripcion->condicion === 'regular' ? 'regular' : 'libre' }}">
                                        {{ ucfirst($inscripcion->condicion) }}
                                    </span>
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
