<!-- // Vista para agregar una nueva experiencia laboral al perfil del usuario, con campos para puesto, empresa, horario, fechas, descripción, logros y botones para cancelar o guardar.
 -->


@extends('layouts.app2')

@section('content')



<div class="perfil-contenedor separador" style="margin-top: 100px;">

    <h2 class="titulo-principal">
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'experiencia']) }}" class="link-icono">
            <i class="ri-arrow-left-line icon-bordo"></i>
        </a>
        Añadir experiencia laboral
    </h2>
    <br>



    <form action="{{ route('bolsadetrabajo.experiencias.store') }}" method="POST">
        @csrf
        <input type="hidden" name="usuario_id" value="{{ auth()->id() ?? 1 }}">

        <div class="form-group">
            <label>Puesto</label>
            <input type="text" name="puesto" value="{{ old('puesto') }}" class="form-control @error('puesto') input-error @enderror">
            @error('puesto')<div class="error-mensaje">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Empresa</label>
            <input type="text" name="empresa" value="{{ old('empresa') }}" class="form-control @error('empresa') input-error @enderror">
            @error('empresa')<div class="error-mensaje">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Horario
                <select name="horario" class="form-control @error('horario') input-error @enderror">
                    <option value="">Seleccione...</option>
                    <option value="Full-Time" {{ old('horario')=='Full-Time' ? 'selected' : '' }}>Full-Time</option>
                    <option value="Part-Time" {{ old('horario')=='Part-Time' ? 'selected' : '' }}>Part-Time</option>
                    <option value="Rotativo" {{ old('horario')=='Rotativo' ? 'selected' : '' }}>Rotativo</option>
                </select>
                @error('horario')<div class="error-mensaje">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Fecha de inicio <small>(MM/AA)</small></label>
            <input type="month" name="año_inicio" value="{{ old('año_inicio') }}" class="form-control @error('año_inicio') input-error @enderror" max="{{ now()->format('Y-m') }}">
            @error('año_inicio')<div class="error-mensaje">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Fecha de finalización <small>(MM/AA)</small></label>
            <input type="month" name="año_fin" value="{{ old('año_fin') }}" class="form-control @error('año_fin') input-error @enderror" max="{{ date('Y-m') }}">
            @error('año_fin')<div class="error-mensaje">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" rows="3" class="form-control @error('descripcion') input-error @enderror">{{ old('descripcion') }}</textarea>
            @error('descripcion')<div class="error-mensaje">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Logros</label>
            <textarea name="logros" rows="4" class="form-control @error('logros') input-error @enderror">{{ old('logros') }}</textarea>
            @error('logros')<div class="error-mensaje">{{ $message }}</div>@enderror
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 25px;">
            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'experiencia']) }}" class="boton-cancelar-experiencia">
                Cancelar
            </a>
            <button type="submit" class="btn-guardar-exp">
                <i class="ri-check-line"></i> Guardar experiencia
            </button>
        </div>

    </form>
</div>
@endsection