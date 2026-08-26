@extends('layouts.app2')

@section('content')
<div class="container_home">
    <div class="page-header">
        <h1>Gestión de notas</h1>
        <a href="{{ route('bolsadetrabajo.notas.create') }}" class="btn btn-primary">Nueva calificación</a>
    </div>

    @if($calificaciones->isEmpty())
        <p>No hay calificaciones registradas.</p>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Materia</th>
                        <th>Mesa</th>
                        <th>Nota</th>
                        <th>Aprobado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calificaciones as $calificacion)
                        <tr>
                            <td>{{ $calificacion->usuario->apellido }}, {{ $calificacion->usuario->nombre }}</td>
                            <td>{{ $calificacion->materia->materia }}</td>
                            <td>{{ optional($calificacion->mesa)->fecha ? \Carbon\Carbon::parse($calificacion->mesa->fecha)->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $calificacion->nota ?? '-' }}</td>
                            <td>{{ $calificacion->aprobado ? 'Sí' : 'No' }}</td>
                            <td>{{ $calificacion->fecha ? \Carbon\Carbon::parse($calificacion->fecha)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('bolsadetrabajo.notas.edit', $calificacion->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                                <form action="{{ route('bolsadetrabajo.notas.destroy', $calificacion->id) }}" method="POST" style="display:inline-block; margin-left: 4px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar esta calificación?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
