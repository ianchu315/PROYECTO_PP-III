@extends('layouts.app2')

@section('content')
<div class="container_home">
    <h1>Mis notas</h1>

    @if($calificaciones->isEmpty())
        <p>Aún no tenés calificaciones registradas.</p>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Mesa</th>
                        <th>Nota</th>
                        <th>Aprobado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calificaciones as $calificacion)
                        <tr>
                            <td>{{ $calificacion->materia->materia }}</td>
                            <td>{{ optional($calificacion->mesa)->fecha ? \Carbon\Carbon::parse($calificacion->mesa->fecha)->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $calificacion->nota ?? '-' }}</td>
                            <td>{{ $calificacion->aprobado ? 'Sí' : 'No' }}</td>
                            <td>{{ $calificacion->fecha ? \Carbon\Carbon::parse($calificacion->fecha)->format('d/m/Y') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
