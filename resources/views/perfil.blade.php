<!-- // Muestra el perfil completo del usuario con su foto, información personal y secciones de experiencia, educación, aptitudes, cursos y CV; permite agregar, editar o eliminar elementos de cada sección mediante formularios y modales, mostrando mensajes de éxito o error según corresponda. -->



@extends('layouts.app2')

@section('content')

<div>


    <div class="card-unica">
        <div class="perfil-banner"></div>

        <div class="perfil-header">
            <img class="perfil-foto" {{--  src="{{ $usuario->foto_perfil ? asset('storage/usuarios/' . $usuario->foto_perfil) : asset('images/user1.png') }}" --}}
                src="{{ $usuario->foto_perfil ? url('perfil/' . $usuario->foto_perfil) : asset('images/user1.png') }}"
                width="120" alt="Foto de {{$usuario->nombre}} {{$usuario->apellido}}">

            <div class="perfil-info">
                <h2 class="perfil-nombre">{{ $usuario->nombre }} {{ $usuario->apellido }} </h2>
                <p class="perfil-titulo">{{ $usuario->carrera ? $usuario->carrera->descripcion : 'Sin carrera asignada' }}
                </p>

                <div class="perfil-datos">
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <!-- <span><i class="ri-earth-line icon-bordo"></i> {{ $usuario->nacionalidad }}</span> -->
                        <span><i class="ri-flag-line icon-bordo"></i>
                            {{ $usuario->nacionalidad ?? 'Sin nacionalidad asignada' }}</span>
                        <!-- <span><i class="ri-flag-line icon-bordo"></i> {{ $usuario->pais_residencia }}</span> -->
                        <span><i class="ri-map-pin-2-line icon-bordo"></i>
                            {{ $usuario->ciudad_residencia ?? 'Sin ciudad asignada' }}</span>
                        <span><i
                                class="ri-genderless-line icon-bordo"></i>{{ $usuario->genero ?? 'Sin género asignado' }}</span>
                    </div>

                    <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 4px;">
                        <span><i class="ri-mail-line icon-bordo"></i> {{ $usuario->email }}</span>

                        @if ($usuario->sitio_web)
                        <span>
                            <i class="ri-global-line icon-bordo"></i>
                            <a href="{{ $usuario->sitio_web }}" target="_blank">{{ $usuario->sitio_web }}</a>
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="perfil-editar perfil-editar-mobile">
                <a href="{{ route('bolsadetrabajo.perfil.editar') }}"><button class="btn-editar"><i
                            class="ri-edit-line"></i> Editar perfil</button></a>
            </div>
        </div>

        <div class="perfil-descripcion">
            <p>{{ $usuario->descripcion ?? 'Sin descripción asignada' }}</p>
        </div>
    </div>

    <div class="perfil-tabs">
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'experiencia']) }}"
            class="{{ $seccion == 'experiencia' ? 'tab-activa' : '' }}">Experiencia</a>
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'educacion']) }}"
            class="{{ $seccion == 'educacion' ? 'tab-activa' : '' }}">Educación</a>
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes']) }}"
            class="{{ $seccion == 'aptitudes' ? 'tab-activa' : '' }}">Aptitudes</a>
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'cursos']) }}"
            class="{{ $seccion == 'cursos' ? 'tab-activa' : '' }}">Cursos</a>
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'postulaciones']) }}"
            class="{{ $seccion == 'postulaciones' ? 'tab-activa' : '' }}">Postulaciones</a>
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'cv']) }}"
            class="{{ $seccion == 'cv' ? 'tab-activa' : '' }}">CV</a>
    </div>

    <div class="contenido-tab">
        @if ($seccion == 'experiencia')


        <div class="btn-container">
            <a href="{{ route('bolsadetrabajo.experiencias.create') }}">
                <button class="btn-agregar"><i class="ri-add-line"></i> Añadir experiencia</button>
            </a>
        </div>



    </div>

    <br>



    @if ($usuario->experienciasLaborales->isEmpty())
    <p class="mensaje-sin-resultados">No has agregado ninguna experiencia laboral aún.</p>
    @else
    <div class="perfil_homogeneo">

        @foreach ($usuario->experienciasLaborales as $experiencia)
        <div class="card-experiencia" style="position: relative;">
            <div class="exp-header">
                <div class="exp-titulo-con-logo flex items-start space-x-3">
                    <img src="{{ asset('images/company9.jpg') }}" alt="Foto de experiencia" width="40" height="40"
                        class="exp-logo mt-1">

                    <div>
                        <h3 class="exp-titulo text-base font-semibold">{{ $experiencia->puesto }}</h3>
                        <p class="exp-empresa">
                            <i class="ri-building-line icon-bordo"></i>
                            {{ $experiencia->empresa }} <span class="dot"></span> <span
                                class="horario-badge">{{ $experiencia->horario }}</span>
                        </p>
                        <p class="exp-fechas">
                            <i class="ri-calendar-line icon-bordo"></i>
                            {{ \Carbon\Carbon::parse($experiencia->año_inicio)->format('m/Y') }}
                            -
                            {{ $experiencia->año_fin ? \Carbon\Carbon::parse($experiencia->año_fin)->format('m/Y') : 'Actualidad' }}
                        </p>
                    </div>
                </div>

                <div style="display: flex; gap: 4px; align-items: center; flex-direction: column;">
                    <form action="{{ route('bolsadetrabajo.experiencias.destroy', $experiencia->id) }}"
                        method="POST"
                        onsubmit="return confirm('¿Estás seguro de que quieres borrar esta experiencia?');"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminarexperiencia" title="Eliminar experiencia">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                    <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'experiencia', 'editarId' => $experiencia->id]) }}"
                        class="exp-editar" title="Editar experiencia"
                        style="text-decoration:none; color:inherit;">
                        <i class="ri-edit-box-line"></i>
                    </a>
                </div>
            </div>

            <p class="exp-descripcion">{{ $experiencia->descripcion }}</p>

            @if (isset($experiencia->logros) && is_array($experiencia->logros) && count($experiencia->logros) > 0)
            <ul class="exp-logros">
                <p>Logros principales</p>
                @foreach ($experiencia->logros as $logro)
                <li>{{ $logro }}</li>
                @endforeach
            </ul>
            @endif
        </div>
        @endforeach
        @endif

    </div>


    @php
    $editarId = request()->get('editarId');
    @endphp
    @if ($editarId || session('error') || session('success'))
    @php
    $expEdit = $usuario->experienciasLaborales->where('id', $editarId)->first();
    @endphp

    @if ($expEdit)
    <div class="simulado-modal">
        <div class="simulado-modal-contenido">

            <div class="modal-header">
                <h3 class="modal-titulo">Editar experiencia</h3>
                <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'experiencia']) }}" class="modal-cerrar"
                    title="Cerrar">&times;</a>
            </div>

            {{-- Popups de éxito y error --}}
            @if (session('success'))
            <div class="toast"
                style="position: fixed; top: 20px; right: 20px; background: #4CAF50; color: white; padding: 15px 25px; border-radius: 8px; z-index: 9999;">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="toast"
                style="position: fixed; top: 20px; right: 20px; background: #f44336; color: white; padding: 15px 25px; border-radius: 8px; z-index: 9999;">
                {{ session('error') }}
            </div>
            @endif

            <script>
                setTimeout(() => {
                    document.querySelectorAll('.toast').forEach(t => t.style.display = 'none');
                }, 5000);
            </script>

            <form action="{{ route('bolsadetrabajo.experiencias.update', $expEdit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-form">

                    {{-- Puesto --}}
                    <div class="form-grupo">
                        <label>Puesto</label>
                        <input type="text" name="puesto" value="{{ old('puesto', $expEdit->puesto) }}"
                            class="@error('puesto') input-error @enderror">
                        @error('puesto')
                        <span class="error-mensaje">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Empresa --}}
                    <div class="form-grupo">
                        <label>Empresa</label>
                        <input type="text" name="empresa" value="{{ old('empresa', $expEdit->empresa) }}"
                            class="@error('empresa') input-error @enderror">
                        @error('empresa')
                        <span class="error-mensaje">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Horario --}}
                    <div class="form-grupo">
                        <label>Horario</label>
                        <select name="horario" class="@error('horario') input-error @enderror">
                            <option disabled selected value="">Selecciona una opción</option>
                            <option value="Full-Time" {{ old('horario', $expEdit->horario) == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                            <option value="Part-Time" {{ old('horario', $expEdit->horario) == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                            <option value="Rotativo" {{ old('horario', $expEdit->horario) == 'Rotativo' ? 'selected' : '' }}>Rotativo</option>
                        </select>
                        @error('horario')
                        <span class="error-mensaje">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Fecha inicio --}}
                    <div class="form-grupo">
                        <label>Fecha inicio</label>
                        <input type="month" name="año_inicio" max="{{ date('Y-m') }}"
                            value="{{ old('año_inicio', $expEdit->año_inicio ? \Carbon\Carbon::parse($expEdit->año_inicio)->format('Y-m') : '') }}"
                            class="@error('año_inicio') input-error @enderror">
                        @error('año_inicio')
                        <span class="error-mensaje">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Fecha fin --}}
                    <div class="form-grupo">
                        <label>Fecha fin</label>
                        <input type="month" name="año_fin" max="{{ date('Y-m') }}"
                            value="{{ old('año_fin', $expEdit->año_fin ? \Carbon\Carbon::parse($expEdit->año_fin)->format('Y-m') : '') }}"
                            class="@error('año_fin') input-error @enderror">
                        @error('año_fin')
                        <span class="error-mensaje">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="form-grupo">
                        <label>Descripción</label>
                        <textarea name="descripcion" rows="3" class="@error('descripcion') input-error @enderror">{{ old('descripcion', $expEdit->descripcion) }}</textarea>
                        @error('descripcion')
                        <span class="error-mensaje">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Logros --}}
                    <div class="form-grupo">
                        <label>Logros</label>
                        <textarea name="logros" rows="4" class="@error('logros') input-error @enderror">{{ old('logros', is_array($expEdit->logros) ? implode("\n", $expEdit->logros) : '') }}</textarea>
                        @error('logros')
                        <span class="error-mensaje">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="form-acciones">
                        <button type="submit" class="btn-guardar-exp">Guardar</button>
                        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'experiencia']) }}" class="btn-cancelar">Cancelar</a>
                    </div>

                </div>

            </form>
        </div>
    </div>
    @endif
    @endif
    @elseif($seccion == 'educacion')
    <div class="btn-container">
        <a href="{{ route('bolsadetrabajo.estudios.create') }}">
            <button class="btn-agregar"><i class="ri-add-line"></i> Añadir educación</button>
        </a>
    </div>
    <br>

    @php
    $editarId = request()->get('editarId');
    @endphp

    <div class="educaciones perfil_homogeneo">
        @if ($usuario->estudios->isEmpty())
        <p class="mensaje-sin-resultados">No has agregado ninguna educación aún.</p>
        @else
        @foreach ($usuario->estudios as $educacion)
        <div class="card-experiencia">
            <div class="exp-header flex justify-between items-center">
                <div class="exp-titulo-con-logo flex items-start space-x-3">
                    <img src="{{ asset('images/school.png') }}" alt="Foto de educacion" width="40" height="40"
                        class="exp-logo mt-1">
                    <div>
                        <h3 class="exp-titulo text-base font-semibold text-bordo">{{ $educacion->titulo }}</h3>
                        <p class="exp-empresa">
                            <i class="ri-school-line icon-bordo"></i>
                            {{ $educacion->institucion }}
                        </p>
                        <p class="exp-fechas">
                            <i class="ri-calendar-line icon-bordo"></i>
                            {{ optional($educacion->fecha_inicio)->format('m/Y') }} -
                            {{ $educacion->fecha_fin ? optional($educacion->fecha_fin)->format('m/Y') : 'Actualidad' }}
                        </p>

                        {{-- Mostrar materias según estado --}}
                        @if ($educacion->estado == 'cursando')
                        <p class="exp-materias">
                            <i class="ri-book-line icon-bordo"></i>
                            Materias aprobadas: {{ $educacion->materias_aprobadas ?? 0 }} /
                            {{ $educacion->materias_totales ?? 0 }}
                        </p>
                        @elseif($educacion->estado == 'recibido')
                        <p class="exp-materias">
                            <i class="ri-book-line icon-bordo"></i>
                            Materias aprobadas: {{ $educacion->materias_aprobadas ?? 0 }} | Promedio final:
                            {{ $educacion->promedio_final ?? 'N/A' }}
                        </p>
                        @endif
                    </div>
                </div>

                <div style="display: flex; gap: 8px; align-items: center;">
                    <form action="{{ route('bolsadetrabajo.estudios.destroy', $educacion->id) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de que quieres borrar esta educación?');"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminareducacion" title="Eliminar educación">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                    <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'educacion', 'editarId' => $educacion->id]) }}"
                        class="exp-editar" title="Editar educación" style="text-decoration:none; color:inherit;">
                        <i class="ri-edit-box-line"></i>
                    </a>
                </div>
            </div>

            <p class="exp-descripcion">{{ $educacion->descripcion }}</p>
        </div>
        @endforeach
        @endif
    </div>


    @if ($editarId)
    @php
    $eduEdit = $usuario->estudios->where('id', $editarId)->first();

    // Formatear fechas para input type="date" usando la clase completa
    $fecha_inicio = $eduEdit->fecha_inicio
    ? \Carbon\Carbon::parse($eduEdit->fecha_inicio)->format('Y-m-d')
    : '';
    $fecha_fin = $eduEdit->fecha_fin ? \Carbon\Carbon::parse($eduEdit->fecha_fin)->format('Y-m-d') : '';
    @endphp

    @if ($eduEdit)
    <div class="simulado-modal">
        <div class="simulado-modal-contenido" style="position: relative; max-width: 600px; width: 90%;">
            <div class="modal-header">
                <h3 class="modal-titulo">Editar educación</h3>
                <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'educacion']) }}" class="modal-cerrar"
                    title="Cerrar">&times;</a>
            </div>

            <form action="{{ route('bolsadetrabajo.estudios.update', $eduEdit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-form">

                    {{-- Institución --}}
                    <div class="form-group">
                        <label>Institución</label>
                        <input type="text" name="institucion"
                            value="{{ old('institucion', $eduEdit->institucion) }}"
                            class="@error('institucion') input-error @enderror">
                        @error('institucion')
                        <div class="error-mensaje">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Título --}}
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="titulo" value="{{ old('titulo', $eduEdit->titulo) }}"
                            class="@error('titulo') input-error @enderror">
                        @error('titulo')
                        <div class="error-mensaje">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control @error('descripcion') input-error @enderror" rows="4" style="width: 100%;">{{ old('descripcion', $eduEdit->descripcion) }}</textarea>
                        @error('descripcion')
                        <div class="error-mensaje">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Fecha inicio</label>
                        <input type="month" name="fecha_inicio"
                            value="{{ old('fecha_inicio', $eduEdit->fecha_inicio ? \Carbon\Carbon::parse($eduEdit->fecha_inicio)->format('Y-m') : '') }}"
                            max="{{ now()->format('Y-m') }}"
                            class="@error('fecha_inicio') input-error @enderror">
                        @error('fecha_inicio')
                        <div class="error-mensaje">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fecha fin --}}
                    <div id="fecha-fin-group" class="form-group"
                        style="margin-bottom: 15px; display: {{ old('estado', $eduEdit->estado) == 'recibido' ? 'block' : 'none' }};">
                        <label>Fecha fin</label>
                        <input type="month" name="fecha_fin"
                            value="{{ old('fecha_fin', $eduEdit->fecha_fin ? \Carbon\Carbon::parse($eduEdit->fecha_fin)->format('Y-m') : '') }}"
                            class="@error('fecha_fin') input-error @enderror">
                        @error('fecha_fin')
                        <div class="error-mensaje">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Estado --}}
                    <div class="form-group">
                        <label>Estado</label>

                        <div class="dropdown dropdown-container dropdown-homogeneo">
                            <input type="hidden" name="estado" id="estadoInput"
                                value="{{ old('estado', $eduEdit->estado ?? '') }}">

                            <!-- Toggle del dropdown -->
                            <div class="dropdown-toggle dropdown-homogeneo-toggle @error('estado') input-error @enderror" onclick="toggleDropdown(this)">
                                <div>
                                    <span id="estadoLabel" class="dropdown-label">
                                        {{ old('estado', $eduEdit->estado ?? '') ? ucfirst(old('estado', $eduEdit->estado)) : 'Seleccioná un estado' }}
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
                        <div class="error-mensaje">{{ $message }}</div>
                        @enderror
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const opciones = document.querySelectorAll('.dropdown-opcion');
                            const estadoInput = document.getElementById('estadoInput');
                            const estadoLabel = document.getElementById('estadoLabel');

                            // Mostrar u ocultar opciones del formulario según el estado
                            function mostrarOpcionesEstado(estado) {
                                const cursando = document.getElementById("cursando-opciones");
                                const recibido = document.getElementById("recibido-opciones");
                                const fechaFin = document.getElementById("fecha-fin-group");

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

                            // Al seleccionar una opción
                            opciones.forEach(opcion => {
                                opcion.addEventListener('click', () => {
                                    const value = opcion.dataset.value;
                                    estadoInput.value = value;
                                    estadoLabel.textContent = opcion.textContent;

                                    // Cerrar el menú
                                    opcion.closest('.dropdown-menu').classList.add('oculto');

                                    // Actualizar la vista según el estado
                                    mostrarOpcionesEstado(value);
                                });
                            });

                            // Al cargar la página, mantener el estado actual
                            mostrarOpcionesEstado(estadoInput.value);
                        });
                    </script>

                    {{-- Materias aprobadas (si cursando o recibido) --}}
                    <div class="form-group" id="materias-aprobadas-group"
                        style="display: {{ in_array(old('estado', $eduEdit->estado), ['cursando', 'recibido']) ? 'block' : 'none' }};">
                        <label>Materias aprobadas</label>
                        <input type="number" name="materias_aprobadas" class="form-control @error('materias_aprobadas') input-error @enderror"
                            value="{{ old('materias_aprobadas', $eduEdit->materias_aprobadas) }}">
                        @error('materias_aprobadas')
                        <div class="error-mensaje">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Total de materias (solo cursando) --}}
                    <div id="cursando-opciones"
                        style="display: {{ old('estado', $eduEdit->estado) == 'cursando' ? 'block' : 'none' }};">
                        <div class="form-group">
                            <label>Total de materias</label>
                            <input type="number" name="materias_totales" class="form-control @error('materias_totales') input-error @enderror"
                                value="{{ old('materias_totales', $eduEdit->materias_totales) }}">
                            @error('materias_totales')
                            <div class="error-mensaje">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Promedio final (solo recibido) --}}
                    <div id="recibido-opciones"
                        style="display: {{ old('estado', $eduEdit->estado) == 'recibido' ? 'block' : 'none' }};">
                        <div class="form-group">
                            <label>Promedio final</label>
                            <input type="number" step="0.01" name="promedio_final" class="form-control @error('promedio_final') input-error @enderror"
                                value="{{ old('promedio_final', $eduEdit->promedio_final) }}">
                            @error('promedio_final')
                            <div class="error-mensaje">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div class="form-acciones"
                        style="display:flex; gap:10px; justify-content:flex-end; margin-top:20px;">
                        <button type="submit" class="btn-guardar-exp">Guardar</button>
                        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'educacion']) }}"
                            class="boton-cancelar-experiencia">Cancelar</a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Script para mostrar/ocultar campos según estado --}}

    @endif
    @endif
    @elseif ($seccion === 'aptitudes')
    <div class="aptitudestab">

        <div class="aptitud-tabs" style="display: flex; gap: 12px;">
            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'habilidades']) }}"
                class="{{ request('subseccion', 'habilidades') == 'habilidades' ? 'tab-activa' : '' }}">
                Habilidades
            </a>
            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'idiomas']) }}"
                class="{{ request('subseccion') == 'idiomas' ? 'tab-activa' : '' }}">
                Idiomas
            </a>
        </div>


        @if (request('subseccion', 'habilidades') == 'habilidades')
        <a href="{{ route('bolsadetrabajo.aptitudes.create') }}" class="btn-agregarhab btn-agregar "
            style="text-decoration: none;">+ Agregar habilidad</a>
        @elseif(request('subseccion') == 'idiomas')
        <a href="{{ route('bolsadetrabajo.idiomas.create') }}" class="btn-agregarhab btn-agregar"
            style="text-decoration: none;">+ Agregar idioma</a>
        @endif
    </div>

    @php
    $editarId = request()->get('editarId');
    $tipo = request()->get('tipo');
    @endphp


    @if (request('subseccion', 'habilidades') == 'habilidades')


    @if ($usuario->aptitudes->isEmpty())
    <p class="mensaje-sin-resultados">No has agregado ninguna habilidad aún.</p>
    @else
    <div class="card-skills ">
        <ul class="skills-list">
            @foreach ($usuario->aptitudes as $aptitud)
            <li style="display: flex; justify-content: space-between; align-items: center;">
                <span><i class="ri-checkbox-circle-line icon-bordo"></i> {{ $aptitud->aptitud }}</span>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <form action="{{ route('bolsadetrabajo.aptitudes.destroy', $aptitud->id) }}"
                        method="POST"
                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta habilidad?');"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminarhabilidad" title="Eliminar habilidad">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                    <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'habilidades', 'editarId' => $aptitud->id, 'tipo' => 'habilidad']) }}"
                        title="Editar" style="font-size: 20px; color: #730000; text-decoration: none;">
                        <i class="ri-edit-box-line editar-habilidad-icono"></i>
                    </a>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
    @elseif(request('subseccion') == 'idiomas')
    @if ($usuario->idiomas->isEmpty())
    <p class="mensaje-sin-resultados">No has agregado ningún idioma aún.</p>
    @else
    <div class="card-skills">
        <div class="skills-header">
            <!-- <h3 style="color: #730000; margin-bottom: 12px;">Idiomas</h3> -->
            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'idiomas', 'editarId' => null]) }}"
                class="ap-editar" title="Editar idiomas" style="text-decoration:none;">
            </a>
        </div>

        <ul class="skills-list">
            @foreach ($usuario->idiomas as $idioma)
            <li style="display: flex; justify-content: space-between; align-items: center;">
                <span>
                    <i class="ri-global-fill icon-bordo"></i>
                    {{ $idioma->idioma }} - <span style="color: #555;">{{ $idioma->nivel }}</span>
                </span>

                <div style="display: flex; gap: 8px; align-items: center;">
                    <form action="{{ route('bolsadetrabajo.idiomas.destroy', $idioma->id) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar este idioma?');"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminaridioma" title="Eliminar idioma">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                    <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'idiomas', 'editarId' => $idioma->id, 'tipo' => 'idioma']) }}"
                        title="Editar" style="font-size: 20px; color: #730000; text-decoration: none;">
                        <i class="ri-edit-box-line editar-habilidad-icono"></i>
                    </a>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
    @endif


    @if ($editarId && ($tipo == 'habilidad' || $tipo == 'idioma'))
    @php
    if ($tipo == 'habilidad') {
    $itemEdit = $usuario->aptitudes->where('id', $editarId)->first();
    } else {
    $itemEdit = $usuario->idiomas->where('id', $editarId)->first();
    }
    @endphp

    @if ($itemEdit)
    <div class="simulado-modal">
        <div class="simulado-modal-contenido">

            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => $tipo == 'habilidad' ? 'habilidades' : 'idiomas']) }}"
                class="modal-cerrar" title="Cerrar">&times;</a>
            <div class="modal-header">
                <h3 class="modal-titulo">
                    Editar {{ $tipo == 'habilidad' ? 'habilidad' : 'idioma' }}
                </h3>
            </div>
            @if ($tipo == 'habilidad')
            <form action="{{ route('bolsadetrabajo.aptitudes.update', $itemEdit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-form">
                    <div class="form-grupo">
                        <label>Habilidad</label>
                        <input type="text" name="aptitud"
                            value="{{ old('aptitud', $itemEdit->aptitud) }}"
                            class="@error('aptitud') input-error @enderror">
                        @error('aptitud')<div class="error-mensaje">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-acciones" style="display:flex; gap:10px; justify-content:flex-end;">
                        <button type="submit" class="btn-guardar-exp">Guardar</button>
                        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'habilidades']) }}"
                            class="btn-cancelar">Cancelar</a>
                    </div>
                </div>
            </form>
            @else
            <form action="{{ route('bolsadetrabajo.idiomas.update', $itemEdit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-form">
                    <div class="form-grupo">
                        <label>Idioma</label>
                        <div class="dropdown dropdown-container dropdown-homogeneo">
                            <input type="hidden" name="idioma" id="idiomaInput" value="{{ old('idioma', $itemEdit->idioma) }}">

                            <!-- Toggle del dropdown -->
                            <div class="dropdown-toggle dropdown-homogeneo-toggle">
                                <div>
                                    <span id="idiomaLabel" class="dropdown-label">
                                        {{ old('idioma', $itemEdit->idioma) ?: 'Seleccioná un idioma' }}
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
                    </div>

                    <div class="form-grupo">
                        <label>Nivel</label>
                        <div class="dropdown dropdown-container dropdown-homogeneo">
                            <input type="hidden" name="nivel" id="nivelInput" value="{{ old('nivel', $itemEdit->nivel) }}">

                            <!-- Toggle del dropdown -->
                            <div class="dropdown-toggle dropdown-homogeneo-toggle">
                                <div>
                                    <span id="nivelLabel" class="dropdown-label">
                                        {{ old('nivel', $itemEdit->nivel) ?: 'Seleccioná el nivel' }}
                                    </span>
                                </div>
                                <i class="ri-arrow-down-s-line flecha-dropdown"></i>
                            </div>

                            <!-- Opciones -->
                            <div class="dropdown-menu oculto">
                                @php
                                $niveles = ['Básico', 'Intermedio', 'Avanzado', 'Nativo'];
                                @endphp
                                @foreach ($niveles as $nivel)
                                <h3 class="dropdown-opcion" data-value="{{ $nivel }}">
                                    {{ $nivel }}
                                </h3>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-acciones" style="display:flex; gap:10px; justify-content:flex-end;">
                        <button type="submit" class="btn-guardar-exp">Guardar</button>
                        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'idiomas']) }}"
                            class="btn-cancelar">Cancelar</a>
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


            </form>
            @endif
        </div>
    </div>
    @endif
    @endif
    @elseif($seccion == 'cursos')
    @php
    $editarId = request()->get('editarId');
    @endphp

    @if ($seccion == 'cursos')
    <div class="btn-container">
        <a href="{{ route('bolsadetrabajo.cursos.create') }}">
            <button class="btn-agregar"><i class="ri-add-line"></i> Añadir curso</button>
        </a>
    </div>
    <br>

    @if ($usuario->cursos->isEmpty())
    <p class="mensaje-sin-resultados">No has agregado ningún curso aún.</p>
    @else
    <div class="perfil_homogeneo">

        @foreach ($usuario->cursos as $curso)
        <div class="card-experiencia">
            <div class="exp-header flex justify-between items-center">
                <div class="exp-titulo-con-logo flex items-start space-x-3">
                    <img src="{{ asset('images/school.png') }}" alt="Foto de curso" width="40"
                        height="40" class="exp-logo mt-1">

                    <div>
                        <h3 class="exp-titulo text-base font-semibold text-bordo">
                            {{ $curso->nombre }}
                            @if ($curso->certificado)
                            <span class="badge-certificado"><i class="ri-medal-fill"></i>
                                Certificado</span>
                            @endif
                        </h3>
                        <p class="exp-empresa">
                            <i class="ri-building-line icon-bordo"></i>
                            {{ $curso->institucion }}
                        </p>
                        <p class="exp-fechas">
                            <i class="ri-calendar-line icon-bordo"></i>
                            @if ($curso->fecha)
                            {{ \Illuminate\Support\Str::substr($curso->fecha, 5, 2) }}/{{ \Illuminate\Support\Str::substr($curso->fecha, 2, 2) }}
                            @endif
                            <span class="dot"></span>
                            @if ($curso->fecha_fin)
                            {{ \Illuminate\Support\Str::substr($curso->fecha_fin, 5, 2) }}/{{ \Illuminate\Support\Str::substr($curso->fecha_fin, 2, 2) }}
                            @else
                            Actualidad
                            @endif
                        </p>

                    </div>
                </div>

                <div style="display: flex; gap: 8px; align-items: center;">
                    <form action="{{ route('bolsadetrabajo.cursos.destroy', $curso->id) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar este curso?');"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminarcurso" title="Eliminar curso"
                            style="background:none; border:none; cursor:pointer; color:#730000; font-size: 20px;">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>

                    <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'cursos', 'editarId' => $curso->id]) }}"
                        class="exp-editar" title="Editar curso"
                        style="font-size: 20px; color: #730000; text-decoration: none;">
                        <i class="ri-edit-box-line"></i>
                    </a>
                </div>
            </div>

            @if ($curso->temas_principales)
            <p class="mt-2 font-semibold cursos-titulo">Temas principales:</p>
            <ul class="exp-logros list-disc pl-6">
                @foreach (explode("\n", $curso->temas_principales) as $tema)
                <li>{{ $tema }}</li>
                @endforeach
            </ul>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Modal editar curso --}}
    @if ($editarId)
    @php
    $cursoEdit = $usuario->cursos->where('id', $editarId)->first();
    @endphp

    @if ($cursoEdit)
    <div class="simulado-modal">
        <div class="simulado-modal-contenido" style="position: relative; max-width: 600px; width: 90%;">


            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'cursos']) }}" class="modal-cerrar"
                title="Cerrar">&times;</a>
            <div class="modal-header">
                <h3 class="modal-titulo">
                    Editar curso
                </h3>
            </div>


            <form action="{{ route('bolsadetrabajo.cursos.update', $cursoEdit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-form">
                    <div class="form-grupo">
                        <label>Nombre del curso</label>
                        <input type="text" name="nombre"
                            value="{{ old('nombre', $cursoEdit->nombre) }}"
                            class="@error('nombre') input-error @enderror">
                        @error('nombre')<div class="error-mensaje">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-grupo">
                        <label>Ubicación de la Institución</label>
                        <input type="text" name="institucion"
                            value="{{ old('institucion', $cursoEdit->institucion) }}"
                            class="@error('institucion') input-error @enderror">
                        @error('institucion')<div class="error-mensaje">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Fecha de inicio</label>
                        <input type="month" name="fecha" class="form-control @error('fecha') input-error @enderror" placeholder="MM/AA"
                            value="{{ old('fecha', isset($cursoEdit) ? $cursoEdit->fecha : '') }}">
                        @error('fecha')
                        <span class="error-mensaje">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Fecha fin</label>
                        <input type="month" name="fecha_fin" class="form-control @error('fecha_fin') input-error @enderror" placeholder="MM/AA"
                            value="{{ old('fecha_fin', isset($cursoEdit) ? $cursoEdit->fecha_fin : '') }}">
                        @error('fecha_fin')
                        <span class="error-mensaje">{{ $message }}</span>
                        @enderror
                    </div>



                    <div class="form-grupo"> <label>Temas principales</label>
                        <textarea name="temas_principales" rows="4" class="w-full border rounded p-2">{{ old('temas_principales', isset($cursoEdit->temas_principales) ? str_replace(';', "\n", $cursoEdit->temas_principales) : '') }}</textarea>
                    </div>

                    <div class="form-acciones">
                        <button type="submit" class="btn-guardar-exp">Guardar</button>
                        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'cursos']) }}"
                            class="boton-cancelar-experiencia">Cancelar</a>
                    </div>

            </form>

        </div>
    </div>
    @endif
    @endif
    @endif
    @elseif($seccion == 'postulaciones')
    <br>

    <div class="perfil_homogeneo">

        @forelse ($usuario->postulaciones->where('estado_postulacion', '!=', 'Cancelado') as $postulacion)
        <div class="card-experiencia postulacion-item">
            <div class="exp-header" style="display: flex; justify-content: space-between; align-items: center;">
                <div class="exp-titulo-con-logo flex items-start space-x-3"
                    style="display: flex; align-items: flex-start; gap: 12px;">
                    <img src="{{ asset('images/company9.jpg') }}" alt="Logo empresa" width="40" height="40"
                        class="exp-logo mt-1">

                    <div>
                        <h3 class="exp-titulo text-base font-semibold text-bordo">
                            {{ $postulacion->oferta->titulo }}
                        </h3>
                        <p class="exp-empresa">
                            <i class="ri-building-line icon-bordo"></i>
                            {{ $postulacion->oferta->empresa }} • {{ $postulacion->oferta->ubicacion }}
                        </p>
                        <p class="exp-fechas">
                            <i class="ri-calendar-line icon-bordo"></i>
                            {{ date('d \d\e F \d\e Y', strtotime($postulacion->fecha_postulacion)) }}
                        </p>
                    </div>
                </div>

                <div style="text-align: right; display: flex; align-items: center; gap: 8px;">
                    {{-- Estado de la postulación --}}
                    <span
                        class="post-editar
                        {{ $postulacion->estado_postulacion == 'En proceso' ? 'badge-en-proceso' : '' }}
                        {{ $postulacion->estado_postulacion == 'Rechazado' ? 'badge-rechazado' : '' }}
                        {{ $postulacion->estado_postulacion == 'Aceptado' ? 'badge-aceptado' : '' }}">
                        {{ $postulacion->estado_postulacion }}
                    </span>

                    {{-- Icono de tachito para eliminar --}}
                    @if ($postulacion->estado_postulacion == 'En proceso')
                    <form action="{{ route('bolsadetrabajo.postulaciones.cancelar', $postulacion->id) }}"
                        method="POST" class="cancelar-postulacion-form" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminarpostulacion" title="Eliminar postulación">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="mensaje-sin-resultados">No has realizado ninguna postulación aún.</p>
        @endforelse

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.cancelar-postulacion-form');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Confirmación antes de eliminar
                    if (!confirm('¿Seguro que quieres eliminar esta postulación?')) return;

                    const url = form.action;
                    const postulacionItem = form.closest('.postulacion-item');
                    const formData = new FormData(form);

                    // Método DELETE
                    formData.append('_method', 'DELETE');

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': formData.get('_token')
                            },
                            body: formData
                        })
                        .then(response => {
                            if (response.ok) {
                                postulacionItem.remove(); // desaparece la tarjeta
                            } else {
                                response.text().then(text => console.log(text));
                                alert('Error al eliminar la postulación');
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            alert('Error al eliminar la postulación');
                        });
                });
            });
        });
    </script>
    @elseif($seccion == 'cv')
    <div style="margin-top: 20px;">
        <div class="cv-section">
            <div class="card-cv" style="background: #fff; padding: 20px; border-radius: 10px; ">

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <h3>Curriculum Vitae</h3>

                    <form action="{{ route('bolsadetrabajo.cv.subir') }}" method="POST" enctype="multipart/form-data"
                        style="margin:0; display:inline;">
                        @csrf
                        <input type="file" name="cv[]" multiple accept=".pdf,.doc,.docx" style="display:none;"
                            id="input-cv" onchange="document.getElementById('form-subir-cv').submit();">

                        <button type="button" id="btn-subir-cv" onclick="document.getElementById('input-cv').click();">
                            <i class="ri-upload-cloud-line" style="margin-right: 4px;"></i> Subir CV
                        </button>
                    </form>



                    <script>
                        // Cuando el input cambia, enviar el formulario automáticamente
                        document.getElementById('input-cv').addEventListener('change', function() {
                            if (this.files.length > 0) {
                                this.form.submit();
                            }
                        });
                    </script>
                </div>

                <p style="margin-bottom: 20px;">Sube tu Curriculum Vitae para que te puedan contactar</p>
                @php
                
                $usuarioId = Auth::id();
                $cv = \App\Models\Cv::where('usuario_id', $usuarioId)->latest()->first();
                $cvList = \App\Models\Cv::where('usuario_id', $usuarioId)->latest()->get();
                @endphp

                @if ($cv)
                <div class="perfil_homogeneo-cv">
                    @foreach ($cvList as $cv)
                    <div class="cv-box"
                        style="border: 1px solid #eee; padding: 16px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; background: #fafafa; margin-bottom: 12px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="/images/curriculum-vitae.jpg" alt="Logo empresa" width="40"
                                height="40" class="exp-logo mt-1">
                            <div>
                                <p style="font-weight: bold;">{{ $cv->nombre_archivo }}</p>
                                <p style="font-size: 14px; color: #666;">
                                    Actualizado:
                                    {{ \Illuminate\Support\Carbon::parse($cv->updated_at)->translatedFormat('d \d\e F \d\e Y') }}
                                </p>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 12px;">
                            <a href="{{ url('cv/' . $cv->nombre_archivo) }}" download>
                                <i class="ri-download-line"></i>
                            </a>
                            <form action="{{ route('bolsadetrabajo.cv.eliminar', $cv->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres borrar el CV?')"
                                style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar">
                                    <i class="ri-delete-bin-line" style="margin-right: 4px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="no-cv">No has subido ningún CV aún.</p>
                @endif
            </div>
        </div>
    </div>
    @endif


</div>
</div>

</div>

@endsection