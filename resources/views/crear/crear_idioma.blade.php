<!-- // Vista para agregar un nuevo idioma al perfil del usuario, con formulario que incluye el nombre del idioma, nivel y botones para cancelar o guardar.
 -->


@extends('layouts.app2')

@section('content')
<div class="perfil-contenedor separador" style="margin-top: 100px;">
    <h2 class="titulo-principal">
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'idiomas']) }}" class="link-icono">
            <i class="ri-arrow-left-line icon-bordo"></i>
        </a>
        Añadir idioma
    </h2>
    <br>

    <form action="{{ route('bolsadetrabajo.idiomas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="usuario_id" value="{{ auth()->id() ?? 1 }}">

        <div class="form-group">
            <label>Idioma</label>

            <div class="dropdown dropdown-container dropdown-homogeneo">
                <input type="hidden" name="idioma" id="idiomaInput" value="{{ old('idioma') }}">

                <!-- Toggle del dropdown -->
                <div class="dropdown-toggle dropdown-homogeneo-toggle @error('idioma') input-error @enderror">
                    <div>
                        
                        <span id="idiomaLabel" class="dropdown-label">
                            {{ old('idioma') ?: 'Seleccioná un idioma' }}
                        </span>
                    </div>
                    <i class="ri-arrow-down-s-line flecha-dropdown"></i>
                </div>

                <!-- Opciones -->
                <div class="dropdown-menu oculto">
                    @foreach ($idiomasDisponibles as $idioma)
                    <h3 class="dropdown-opcion" data-value="{{ $idioma->nombre_idioma }}">
                        {{ $idioma->nombre_idioma }}
                    </h3>
                    @endforeach
                </div>
            </div>

            @error('idioma')
            <small class="error-mensaje">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Nivel</label>
            <div class="dropdown dropdown-container dropdown-homogeneo">
            <input type="hidden" name="nivel" id="nivelInput" value="{{ old('nivel') }}">

            <!-- Toggle del dropdown -->
            <div class="dropdown-toggle dropdown-homogeneo-toggle @error('nivel') input-error @enderror">
                <div>
                <span id="nivelLabel" class="dropdown-label">
                    {{ old('nivel') ?: 'Seleccioná el nivel' }}
                </span>
                </div>
                <i class="ri-arrow-down-s-line flecha-dropdown"></i>
            </div>

            <!-- Opciones -->
            <div class="dropdown-menu oculto">
                @php
                
                @endphp
                @foreach ($niveles as $nivel)
                <h3 class="dropdown-opcion" data-value="{{ $nivel }}">
                {{ $nivel }}
                </h3>
                @endforeach
            </div>
            </div>
            @error('nivel')
            <small class="error-mensaje">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 25px;">
            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'idiomas']) }}"
                class="boton-cancelar-experiencia">
                Cancelar
            </a>
            <button type="submit" class="btn-guardar-exp">
                <i class="ri-check-line"></i> Guardar idioma
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.dropdown-opcion').forEach(opcion => {
        opcion.addEventListener('click', () => {
            const value = opcion.dataset.value;
            const container = opcion.closest('.dropdown-container');
            const input = container.querySelector('input[type="hidden"]');
            const label = container.querySelector('.dropdown-label');

            if (input) input.value = value;
            if (label) label.textContent = value;
        });
    });
});
</script>

@endsection