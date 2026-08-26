<!-- // Vista para agregar un curso del usuario, incluyendo nombre, institución, fechas, temas principales y botones para cancelar o guardar.
 -->


@extends('layouts.app2')

@section('content')
<div class="perfil-contenedor separador" style="margin-top: 100px;">

    <h2 class="titulo-principal">
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'cursos']) }}" class="link-icono">
            <i class="ri-arrow-left-line icon-bordo"></i>
        </a>
        Añadir curso
    </h2>
    <br>

    <form id="form-crear-curso" action="{{ route('bolsadetrabajo.cursos.store') }}" method="POST">
        @csrf

        <input type="hidden" name="usuario_id" value="{{ auth()->id() ?? 1 }}">

        <div class="form-group">
            <label>Nombre del curso</label>
            <input type="text" name="nombre" class="form-control @error('nombre') input-error @enderror" value="{{ old('nombre') }}">
            @error('nombre')
            <small class="error-mensaje">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Ubicacion de la institución</label>
            <input type="text" name="institucion" class="form-control @error('institucion') input-error @enderror" value="{{ old('institucion') }}">
            @error('institucion')
            <small class="error-mensaje">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Fecha de inicio <small>(MM/AA)</small></label>
            <input type="month" name="fecha" id="fecha-inicio" class="form-control @error('fecha') input-error @enderror" value="{{ old('fecha') }}" max="{{ now()->format('Y-m') }}">
            @if ($errors->has('fecha'))
            <small class="error-mensaje">{{ $errors->first('fecha') }}</small>
            @endif
        </div>

        <div class="form-group">
            <label>Fecha de fin <small>(MM/AA)</small></label>
            <input type="month" name="fecha_fin" id="fecha-fin" class="form-control @error('fecha_fin') input-error @enderror" value="{{ old('fecha_fin') }}">
            @if ($errors->has('fecha_fin'))
            <small class="error-mensaje">{{ $errors->first('fecha_fin') }}</small>
            @endif
        </div>


        <div class="form-group">
            <label>Temas principales</label>
            <textarea name="temas_principales" class="form-control @error('temas_principales') input-error @enderror" rows="4" placeholder="Escriba los temas principales del curso">{{ old('temas_principales') }}</textarea>
            @error('temas_principales')
            <small class="error-mensaje">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 25px;">
            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'cursos']) }}" class="boton-cancelar-experiencia">
                Cancelar
            </a>
            <button type="submit" class="btn-guardar-exp">
                <i class="ri-check-line"></i> Guardar curso
            </button>
        </div>
    </form>



    @endsection