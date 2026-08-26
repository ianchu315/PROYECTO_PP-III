@extends('backend.layouts.main')

@section('content')
<div class="container mt-4">
    <h2>Editar Salón</h2>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Se encontraron errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('salones.update', $salon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="numero_salon" class="form-label">Número de Salón</label>
            <input type="text" name="numero_salon" id="numero_salon" 
                   class="form-control" value="{{ old('numero_salon', $salon->numero_salon) }}" required>
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" name="capacidad" id="capacidad" 
                   class="form-control" value="{{ old('capacidad', $salon->capacidad) }}" required>
        </div>

        <div class="mb-3">
            <label for="carrera_id" class="form-label">Carrera</label>
            <select name="carrera_id" id="carrera_id" class="form-control" required>
                <option value="">-- Seleccione una carrera --</option>
                @foreach($carreras as $carrera)
                    <option value="{{ $carrera->id }}" 
                        {{ old('carrera_id', $salon->carrera_id) == $carrera->id ? 'selected' : '' }}>
                        {{ $carrera->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="anio_id" class="form-label">Año</label>
            <select name="anio_id" id="anio_id" class="form-control" required>
                <option value="">-- Seleccione un año --</option>
                @foreach($anios as $anio)
                    <option value="{{ $anio->id }}" 
                        {{ old('anio_id', $salon->anio_id) == $anio->id ? 'selected' : '' }}>
                        {{ $anio->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="comision_id" class="form-label">Comisión</label>
            <select name="comision_id" id="comision_id" class="form-control" required>
                <option value="">-- Seleccione una comisión --</option>
                @foreach($comisiones as $comision)
                    <option value="{{ $comision->id }}" 
                        {{ old('comision_id', $salon->comision_id) == $comision->id ? 'selected' : '' }}>
                        {{ $comision->comision }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="laboratorio" value="0"> {{-- valor por defecto --}}
            <input type="checkbox" name="laboratorio" id="laboratorio" class="form-check-input" value="1"
                {{ old('laboratorio', $salon->laboratorio) == 1 ? 'checked' : '' }}>
            <label for="laboratorio" class="form-check-label">Laboratorio</label>
        </div>


        
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('salones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
