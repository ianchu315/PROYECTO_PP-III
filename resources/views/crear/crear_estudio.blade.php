<!-- // Vista para agregar o editar educación del usuario, con campos para institución, título, descripción, fechas, estado, materias o promedio según estado, y botones para cancelar o guardar.
 -->


@extends('layouts.app2')

@section('content')
<div class="perfil-contenedor separador" style="margin-top: 100px;">

    <h2 class="titulo-principal">
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'educacion']) }}" class="link-icono">
            <i class="ri-arrow-left-line icon-bordo"></i>
        </a>
        Añadir educación
    </h2>
    <br>


    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif



    {{-- Mensaje de éxito --}}
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Determinar si es edición --}}
    @php
    $isEdit = isset($eduEdit);
    @endphp


    <form action="{{ $isEdit ? route('bolsadetrabajo.estudios.update', $eduEdit->id) : route('bolsadetrabajo.estudios.store') }}" method="POST">
        @csrf
        @if($isEdit)
        @method('PUT')
        @endif

        <input type="hidden" name="usuario_id" value="{{ auth()->check() ? auth()->user()->id : 1 }}">

        {{-- Institución --}}
        <div class="form-group" style="margin-bottom: 15px;">
            <label>Institución</label>
            <input type="text" name="institucion" class="form-control @error('institucion') input-error @enderror" style="width: 100%;"
                value="{{ old('institucion', $isEdit ? $eduEdit->institucion : '') }}" >
            @error('institucion')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror
        </div>

        {{-- Título --}}
        <div class="form-group" style="margin-bottom: 15px;">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control @error('titulo') input-error @enderror" style="width: 100%;"
                value="{{ old('titulo', $isEdit ? $eduEdit->titulo : '') }}" >
            @error('titulo')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="form-group" style="margin-bottom: 15px;">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control @error('descripcion') input-error @enderror" rows="4" style="width: 100%;">{{ old('descripcion', $isEdit ? $eduEdit->descripcion : '') }}</textarea>
            @error('descripcion')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror
        </div>
        {{-- Fecha inicio --}}
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="fecha_inicio">Fecha de inicio <small>(MM/AA)</small></label>
            <input type="month" name="fecha_inicio" class="form-control @error('fecha_inicio') input-error @enderror" style="width: 100%;"
                value="{{ old('fecha_inicio', $isEdit ? \Carbon\Carbon::parse($eduEdit->fecha_inicio)->format('Y-m') : '') }}" max="{{ now()->format('Y-m') }}">
            @error('fecha_inicio')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror
        </div>

        {{-- Fecha fin --}}
        <div id="fecha-fin-group" class="form-group" style="margin-bottom: 15px;">
            <label>Fecha fin</label>
            <input type="month" name="fecha_fin" class="form-control @error('fecha_fin') input-error @enderror" style="width: 100%;"
                value="{{ old('fecha_fin', $isEdit && $eduEdit->fecha_fin ? \Carbon\Carbon::parse($eduEdit->fecha_fin)->format('Y-m') : '') }}">
            @error('fecha_fin')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror
        </div>

        {{-- Estado --}}
        <div class="form-group" style="margin-bottom: 15px;">
            <label>Estado</label>

            <div class="dropdown dropdown-container dropdown-homogeneo">
                <input type="hidden" name="estado" id="estadoInput" value="{{ old('estado', $isEdit ? $eduEdit->estado : '') }}">

                <!-- Toggle del dropdown -->
                <div class="dropdown-toggle dropdown-homogeneo-toggle @error('estado') input-error @enderror" onclick="mostrarOpcionesEstado()">
                    <div>
                        <span id="estadoLabel" class="dropdown-label">
                            {{ old('estado', $isEdit ? ucfirst($eduEdit->estado) : '') ?: 'Seleccioná un estado' }}
                        </span>
                    </div>
                    <i class="ri-arrow-down-s-line flecha-dropdown"></i>
                </div>

                <!-- Opciones -->
                <div class="dropdown-menu oculto">
                    <h3 class="dropdown-opcion" data-value="cursando">Cursando</h3>
                    <h3 class="dropdown-opcion" data-value="recibido">Recibido</h3>
                </div>
            </div>

            @error('estado')
            <small class="error-mensaje">{{ $message }}</small>
            @enderror
        </div>


        {{-- Materias aprobadas --}}
        <div class="form-group" id="materias-aprobadas-group" style="margin-bottom: 15px;">
            <label>Materias aprobadas</label>
            <input type="number" name="materias_aprobadas" class="form-control @error('materias_aprobadas') input-error @enderror"
                value="{{ old('materias_aprobadas', $isEdit ? $eduEdit->materias_aprobadas ?? 0 : 0) }}">
            @error('materias_aprobadas')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror
        </div>

        {{-- Total de materias (solo cursando) --}}
        <div id="cursando-opciones" class="form-group" style="margin-bottom: 15px;">
            <label>Total de materias</label>
            <input type="number" name="materias_totales" class="form-control @error('materias_totales') input-error @enderror"
                value="{{ old('materias_totales', $isEdit ? $eduEdit->materias_totales ?? 0 : 0) }}">
            @error('materias_totales')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror
        </div>

        {{-- Promedio final (solo recibido) --}}
        <div id="recibido-opciones" class="form-group" style="margin-bottom: 15px;">
            <label>Promedio final</label>
            <input type="number" step="0.01" name="promedio_final" class="form-control @error('promedio_final') input-error @enderror"
                value="{{ old('promedio_final', $isEdit ? $eduEdit->promedio_final ?? 0 : 0) }}">
            @error('promedio_final')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror
        </div>

        <div style="display:flex; justify-content: space-between; margin-top:25px;">
            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'educacion']) }}" class="boton-cancelar-experiencia">
                Cancelar
            </a>
            <button type="submit" class="btn-guardar-exp">
                <i class="ri-check-line"></i> Guardar educación
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const opciones = document.querySelectorAll('.dropdown-opcion');
    const estadoInput = document.getElementById('estadoInput');
    const estadoLabel = document.getElementById('estadoLabel');
    const cursando = document.getElementById("cursando-opciones");
    const recibido = document.getElementById("recibido-opciones");
    const fechaFin = document.getElementById("fecha-fin-group");

    function mostrarOpcionesEstado(estado) {
        if (estado === 'cursando') {
            cursando.style.display = 'block';
            recibido.style.display = 'none';
            fechaFin.style.display = 'none';
        } else if (estado === 'recibido') {
            cursando.style.display = 'none';
            recibido.style.display = 'block';
            fechaFin.style.display = 'block';
        } else {
            cursando.style.display = 'none';
            recibido.style.display = 'none';
            fechaFin.style.display = 'none';
        }
    }

    // Evento al seleccionar una opción del dropdown
    opciones.forEach(opcion => {
        opcion.addEventListener('click', () => {
            const value = opcion.dataset.value;
            estadoInput.value = value;
            estadoLabel.textContent = opcion.textContent;
            mostrarOpcionesEstado(value);
        });
    });

    // Ejecutar al cargar la página con el valor actual
    mostrarOpcionesEstado(estadoInput.value);
});
</script>


@endsection