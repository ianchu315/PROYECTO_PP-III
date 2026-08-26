@extends('backend.layouts.main')
@section('title', 'Profesores')
@section('content')

<div class="mb-3">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filtrar Profesores</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('profesor.index') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ request('nombre') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" name="apellido" id="apellido" class="form-control" value="{{ request('apellido') }}">
                    </div>
                </div>
                <div class="mt-4 d-flex flex-wrap justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel-fill me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('profesor.index') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@if(Session::has('status'))
<div class="mt-1">
    <div class="alert alert-success alert-dismissible fade show">
        {{ Session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<div class="card shadow border-0 rounded-3 mb-3">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="bi bi-file-person"></i> Profesores</h4>
        <a href="{{ route('profesor.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
            <img src="{{ asset('svg/new.svg') }}" height="20" width="20" alt="Crear" title="Crear">
            Crear Profesor
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @forelse($profesores as $profesor)
                    <tr>
                        <td class="ps-4">{{ $profesor->nombre }}</td>
                        <td class="ps-4">{{ $profesor->apellido }}</td>
                        <td class="text-end">
                            {{ Form::model($profesores, ['method' => 'delete', 'route' => ['profesor.destroy', $profesor->id]]) }}
                            @csrf
                            <a href="{{ route('profesor.edit', ['profesor' => $profesor->id, 'page' => request('page', $profesores->currentPage())]) }}" 
                                class="btn btn-primary me-1">
                                <img src="{{ asset('svg/edit.svg') }}" width="20" height="20" alt="Editar" title="Editar">
                            </a>

                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de borrar el profesor?');">
                                <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar" title="Borrar">
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay profesores.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    <div class="d-flex justify-content-center mt-4">
        {{ $profesores->links() }}
    </div>

@endsection