@extends('layouts.app2')

@section('content')
<div class="container_home">
    <h1>Registrar calificación</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bolsadetrabajo.notas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="usuario_id">Alumno</label>
            @include('partials.filtro_rapido', ['target' => '#usuario_id', 'placeholder' => 'Filtrar alumnos por nombre, apellido o email...'])
            <select name="usuario_id" id="usuario_id" class="form-control" required>
                <option value="">Seleccione un alumno</option>
                @foreach($alumnos as $alumno)
                    <option value="{{ $alumno->id }}" {{ old('usuario_id') == $alumno->id ? 'selected' : '' }}>{{ $alumno->apellido }}, {{ $alumno->nombre }} ({{ $alumno->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="materia_id">Materia</label>
            <select name="materia_id" id="materia_id" class="form-control" required>
                <option value="">Seleccione una materia</option>
                @foreach($materias as $materia)
                    <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>{{ $materia->descripcion }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="mesa_id">Mesa (opcional)</label>
            <select name="mesa_id" id="mesa_id" class="form-control">
                <option value="">Sin mesa</option>
                @foreach($mesas as $mesa)
                    <option value="{{ $mesa->id }}" {{ old('mesa_id') == $mesa->id ? 'selected' : '' }}>{{ optional($mesa->materia)->descripcion }} - {{ \Carbon\Carbon::parse($mesa->fecha)->format('d/m/Y') }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nota">Nota</label>
            <input type="number" name="nota" id="nota" class="form-control" value="{{ old('nota') }}" min="0" max="100" step="0.01">
        </div>

        <div class="form-group">
            <label>Aprobado</label>
            <div>
                <label><input type="radio" name="aprobado" value="1" {{ old('aprobado') === '1' ? 'checked' : '' }}> Sí</label>
                <label style="margin-left: 16px;"><input type="radio" name="aprobado" value="0" {{ old('aprobado') === '0' ? 'checked' : '' }}> No</label>
            </div>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" class="form-control" value="{{ old('fecha') }}">
        </div>

        <button type="submit" class="btn btn-primary">Guardar calificación</button>
        <a href="{{ route('bolsadetrabajo.notas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
