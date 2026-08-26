@extends('backend.layouts.main')
@section('title', 'Turnos')

@section('content')

<div class="container mt-4">

    {{-- ALERTAS UNIFICADAS --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center shadow-sm fw-bold" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center shadow-sm fw-bold" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('deleted'))
        <div class="alert alert-warning alert-dismissible fade show text-center shadow-sm fw-bold" role="alert">
            {{ session('deleted') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- TÍTULO --}}
    <div class="text-center mb-3">
        <h3 class="fw-bold">Turnos</h3>
    </div>

    {{-- TABLA DE TURNOS --}}
    @forelse ($turnos as $turno)
        @if ($loop->first)
            <table class="table table-bordered border-2 border-dark align-middle text-center shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>Dia y Hora</th>
                        <th>DNI</th>
                        <th>Carrera</th>
                        @if (Auth::user()->is_admin)
                            <th>
                                <a href="{{ route('turnos.create') }}" class="btn btn-success fw-bold">
                                    <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" class="me-1">
                                    Crear Turno
                                </a>
                            </th>
                        @endif
                    </tr>
                </thead>
        @endif

        <tbody>
            <tr>
                <td>{{ date('d-m-Y H:i', strtotime($turno->dia_hora)) }}</td>
                <td>{{ $turno->dni ?? 'No asignado' }}</td>
                <td>{{ $turno->carrera->descripcion ?? 'No asignado' }}</td>

                @if (Auth::user()->is_admin)
                    <td class="d-flex justify-content-center gap-1">
                        {{-- Mostrar --}}
                        <a href="{{ route('turnos.show', $turno->id) }}" class="btn btn-info" title="Mostrar">
                            <img src="{{ asset('svg/show.svg') }}" width="20" height="20" alt="Mostrar">
                        </a>

                        {{-- Editar --}}
                        <a href="{{ route('turnos.edit', $turno->id) }}" class="btn btn-primary" title="Editar">
                            <img src="{{ asset('svg/edit.svg') }}" width="20" height="20" alt="Editar">
                        </a>

                        {{-- Eliminar con confirmación --}}
                        {!! Form::open(['method' => 'DELETE', 'route' => ['turnos.destroy', $turno->id], 'onsubmit' => "return confirm('¿Seguro que desea eliminar este turno?')"]) !!}
                            <button type="submit" class="btn btn-danger" title="Eliminar">
                                <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar">
                            </button>
                        {!! Form::close() !!}
                    </td>
                @endif
            </tr>
        </tbody>

        @if ($loop->last)
            </table>
            <div class="d-flex justify-content-center mt-3">
                {!! $turnos->links() !!}
            </div>
        @endif
    @empty
        <div class="alert alert-secondary text-center shadow-sm">
            No hay turnos creados aún.
        </div>
        @if (Auth::user()->is_admin)
            <div class="text-center">
                <a href="{{ route('turnos.create') }}" class="btn btn-success fw-bold">
                    <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" class="me-1">
                    Crear Turno
                </a>
            </div>
        @endif
    @endforelse

</div>

@endsection
