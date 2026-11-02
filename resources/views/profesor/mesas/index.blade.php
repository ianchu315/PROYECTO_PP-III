@extends(in_array(Auth::guard('usuarios')->user()->rol, ['administrador', 'superadministrador']) ? 'layouts.panel' : 'layouts.app2')

@section('titulo', 'Inscriptos a mesas finales')

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
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Inscriptos</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mesas->groupBy('carrera_id') as $mesasCarrera)
                        @php
                            $carreraNombre = $mesasCarrera->first()->carrera->descripcion ?? 'Sin carrera';
                        @endphp
                        <tr class="pm-carrera-grupo">
                            <td colspan="5">
                                {{ $carreraNombre }}
                                <span>{{ $mesasCarrera->count() }} {{ $mesasCarrera->count() === 1 ? 'mesa' : 'mesas' }}</span>
                            </td>
                        </tr>
                        @foreach($mesasCarrera as $mesa)
                            <tr>
                                <td>{{ $mesa->materia->descripcion ?? '-' }}</td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    .pm-carrera-grupo td {
        background: #f5f3f2;
        color: #700101;
        font-weight: 700;
        border-top: 1px solid #e7e2e0;
    }

    .pm-carrera-grupo td span {
        color: #777;
        font-size: 12px;
        font-weight: 400;
        margin-left: 8px;
    }
</style>
@endsection
