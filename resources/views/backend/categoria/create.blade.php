@extends('backend.layouts.main')
@section('title', 'Crear Categoría')
@section('content')

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Nueva Categoría</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('categoria.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="categoria" class="form-label">Nombre de Categoría</label>
                    <input type="text" class="form-control @error('categoria') is-invalid @enderror" name="categoria" id="categoria" value="{{ old('categoria') }}" required>
                    @error('categoria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('categoria.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection