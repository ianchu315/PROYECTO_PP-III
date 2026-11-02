@extends('layouts.panel')

@section('titulo', 'Carreras')

@section('content')
<div class="pf-page-header">
    <h1>Carreras</h1>
</div>

@if($carreras->isEmpty())
    <div class="pf-card">
        <p class="pf-muted mb-0">Todavía no hay carreras cargadas.</p>
    </div>
@else
    <div class="pf-card pf-table-wrap">
        <table class="pf-table">
            <thead>
                <tr>
                    <th>Carrera</th>
                    <th>Alumnos</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($carreras as $carrera)
                    <tr>
                        <td>{{ $carrera->descripcion }}</td>
                        <td>{{ $carrera->usuarios_count }}</td>
                        <td>
                            <a href="{{ route('bolsadetrabajo.preceptor.alumnos.index', ['carrera_id' => $carrera->id]) }}" class="btn btn-primary btn-sm">
                                Ver alumnos
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
