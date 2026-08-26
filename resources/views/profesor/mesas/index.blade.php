@extends('layouts.app2')

@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1>Alumnos inscriptos a mesas finales</h1>
    </div>

    @if($mesas->isEmpty())
        <div class="pf-card">
            <p class="pf-muted mb-0">No hay mesas cargadas todavía{{ auth('usuarios')->user()->rol === 'profesor' ? ' para tu carrera' : '' }}.</p>
        </div>
    @else
        <div class="pf-card pf-table-wrap">
            <table class="pf-table">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Carrera</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Inscriptos</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mesas as $mesa)
                        <tr>
                            <td>{{ $mesa->materia->descripcion ?? '-' }}</td>
                            <td>{{ $mesa->carrera->descripcion ?? '-' }}</td>
                            <td>{{ $mesa->fecha }}</td>
                            <td>{{ $mesa->horario ?? '-' }}</td>
                            <td>{{ $mesa->inscripciones_count }}</td>
                            <td>
                                <a href="{{ route('bolsadetrabajo.profesor.mesas.show', $mesa) }}" class="btn btn-primary">
                                    Ver inscriptos
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
