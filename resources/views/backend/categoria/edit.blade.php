@extends('backend.layouts.main')
@section('title', 'Editar Categoría')
@section('content')

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Editar Categoría</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('categoria.update', $categoria) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="categoria" class="form-label">Nombre de Categoría</label>
                    <input type="text" class="form-control @error('categoria') is-invalid @enderror" name="categoria" id="categoria" value="{{ old('categoria', $categoria->categoria) }}" required>
                    @error('categoria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" rows="3">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('categoria.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection