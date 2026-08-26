@extends('layouts.dashboard_layout')

@section('content')
<div class="container">
    <h2>Usuarios pendientes de aprobación</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Tipo de usuario</th>
                <th>Fecha de registro</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ ucfirst($usuario->rol) }}</td>
                <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ ucfirst($usuario->estado) }}</td>
                <td>
                    <form action="{{ route('admin.aprobacion.approve', $usuario->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button class="btn btn-sm btn-success" type="submit">Aprobar</button>
                    </form>

                    <form action="{{ route('admin.aprobacion.reject', $usuario->id) }}" method="POST" style="display:inline; margin-left:8px">
                        @csrf
                        <button class="btn btn-sm btn-danger" type="submit">Rechazar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection
