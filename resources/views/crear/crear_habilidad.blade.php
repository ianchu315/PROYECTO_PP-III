<!-- // Vista para agregar una nueva habilidad blanda al perfil del usuario, con formulario para el nombre de la habilidad y botones para cancelar o guardar.

 -->

@extends('layouts.app2')

@section('content')
<div class="perfil-contenedor separador" style="margin-top: 100px;">
    <h2 class="titulo-principal">
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'habilidades']) }}" class="link-icono">
            <i class="ri-arrow-left-line icon-bordo"></i>
        </a>
        Añadir habilidad
    </h2>
    <br>

    <form action="{{ route('bolsadetrabajo.aptitudes.store') }}" method="POST">
        @csrf
        <input type="hidden" name="usuario_id" value="{{ auth()->id() ?? 1 }}">

        <div class="form-group">
            <label>Nombre de la habilidad</label>
            <input type="text" name="aptitud" class="form-control @error('aptitud') input-error @enderror" value="{{ old('aptitud') }}" >
            @error('aptitud')
            <small class="error-mensaje">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 25px;">
            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'habilidades']) }}"
                class="boton-cancelar-experiencia">
                Cancelar
            </a>
            <button type="submit" class="btn-guardar-exp">
                <i class="ri-check-line"></i> Guardar habilidad
            </button>
        </div>
    </form>
</div>
@endsection