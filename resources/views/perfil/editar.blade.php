<!-- // Muestra un formulario para completar o actualizar el perfil del usuario, permitiendo subir foto de perfil con preview y AJAX, editar información personal y profesional, validar campos y mostrar mensajes de error.
 -->


@extends($usuario->perfil_completado ? 'layouts.app2' : 'layouts.app_nuevo_usuario')

@section('content')
<form action="{{ route('bolsadetrabajo.perfil.actualizar') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if ($usuario->perfil_completado)
    <div class="volver_perfil">
        <a href="{{ route('bolsadetrabajo.perfil') }}" class="link-icono"><button><i
                    class="ri-arrow-left-line"></i>Volver al perfil</button></a>
    </div>
    @endif



    <div class="perfil-contenedor derecha" style="{{ $usuario->perfil_completado ? '' : 'margin-top:20px;' }}">
        <div class="bloque-titulo">

            <div class="bloque-titulo-texto">
                <h2 class="titulo-principal">
                    {{ $usuario->perfil_completado ? 'Actualizar perfil' : 'Completar perfil' }}
                </h2>
                <p class="subtitulo alineado">
                    {{ $usuario->perfil_completado ? 'Actualiza tu información personal y profesional' : 'Completa tu información personal y profesional' }}
                </p>
            </div>

        </div>


        <!-- // Fotos -->

        <div class="perf-foto-section">
            <div class="perf-foto-columna">
                <div class="foto-wrapper">
                    <img id="preview-foto" class="perf-foto"
                        src="{{ $usuario->foto_perfil ? url('perfil/' . $usuario->foto_perfil) : asset('images/user1.png') }}"
                        width="120" alt="Foto de {{$usuario->nombre}} {{$usuario->apellido}}">
                    <i class="ri-camera-line icono-camara"></i>
                </div>
            </div>

            <div class="perf-foto-label">
                <p class="texto-foto">
                    Sube una foto de perfil en formato PNG, JPG, JPEG, WEBP, se recomienda una imagen menor a 5MB.
                </p>
                <button type="button" class="btn-cambiar-foto"
                    onclick="document.getElementById('foto_perfil_input').click();">
                    <i class="ri-upload-line"></i> Cambiar foto
                </button>
                <input type="file" id="foto_perfil_input" name="foto_perfil" style="display: none;" accept="image/*">
                @error('foto_perfil')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <script>
            const inputFoto = document.getElementById('foto_perfil_input');
            const previewFoto = document.getElementById('preview-foto');

            inputFoto.addEventListener('change', function() {
                const archivo = this.files[0];
                if (archivo) {
                    // Mostrar preview inmediato
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewFoto.src = e.target.result;
                    }
                    reader.readAsDataURL(archivo);

                    // Subir foto automáticamente mediante AJAX para que quede guardada
                    const formData = new FormData();
                    formData.append('foto_perfil', archivo);

                    
                }
            });
        </script>

        <!-- // Fotos -->


    </div>
    <script>
        const input = document.getElementById('foto_perfil_input');
        const preview = document.getElementById('preview-foto');

        input.addEventListener('change', function() {
            const archivo = this.files[0];
            if (archivo) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(archivo);
            }
        });
    </script>




    <div class="perfil-contenedor separador perfil-editar-homogeneo">

        <h2 class="titulo-principal">Información personal</h2>

        <div class="form-row">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" placeholder="Ingrese su nombre"
                    value="{{ old('nombre', $usuario->nombre) }}"
                    class="@error('nombre') input-error @enderror">
                @error('nombre')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Apellido</label>
                <input type="text" name="apellido" placeholder="Ingrese su apellido"
                    value="{{ old('apellido', $usuario->apellido) }}"
                    class="@error('apellido') input-error @enderror">
                @error('apellido')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento"
                    value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento ? date('Y-m-d', strtotime($usuario->fecha_nacimiento)) : '') }}"
                    max="{{ \Carbon\Carbon::now()->subYears(17)->format('Y-m-d') }}"
                    class="@error('fecha_nacimiento') input-error @enderror">
                @error('fecha_nacimiento')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror

            </div>

        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Carrera</label>

                <div class="dropdown dropdown-container dropdown-homogeneo">
                    <input type="hidden" name="carrera_id" id="carreraInput" value="{{ old('carrera_id', $usuario->carrera_id) }}">

                    <!-- Toggle del dropdown -->
                    <div class="dropdown-toggle dropdown-homogeneo-toggle @error('carrera_id') input-error @enderror">
                        <div>
                            <span id="carreraLabel" class="dropdown-label">
                                {{ $usuario->carrera_id ? $carreras->firstWhere('id', $usuario->carrera_id)->descripcion : 'Seleccionar carrera' }}
                            </span>
                        </div>
                        <i class="ri-arrow-down-s-line flecha-dropdown"></i>
                    </div>

                    <!-- Opciones -->
                    <div class="dropdown-menu oculto">
                        @foreach ($carreras as $carrera)
                        <h3 class="dropdown-opcion" data-value="{{ $carrera->id }}" data-text="{{ $carrera->descripcion }}">
                            {{ $carrera->descripcion }}
                        </h3>
                        @endforeach
                    </div>
                </div>

                @error('carrera_id')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelectorAll('.dropdown-opcion').forEach(opcion => {
                        opcion.addEventListener('click', () => {
                            const value = opcion.dataset.value;
                            const text = opcion.dataset.text;
                            const container = opcion.closest('.dropdown-container');
                            const input = container.querySelector('input[type="hidden"]');
                            const label = container.querySelector('.dropdown-label');

                            if (input) input.value = value;
                            if (label) label.textContent = text;

                            // Cierra el menú al seleccionar
                            const menu = container.querySelector('.dropdown-menu');
                            menu.classList.add('oculto');

                            // Rota el icono al cerrar
                            const icono = container.querySelector('.flecha-dropdown');
                            if (icono) icono.classList.remove('rotado');
                        });
                    });

                    // Toggle del dropdown
                    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const menu = toggle.parentElement.querySelector('.dropdown-menu');
                            menu.classList.toggle('oculto');

                            // Rota el icono al abrir/cerrar
                            const icono = toggle.querySelector('.flecha-dropdown');
                            if (icono) icono.classList.toggle('rotado', !menu.classList.contains('oculto'));
                        });
                    });

                    // Cierra si se hace clic fuera
                    document.addEventListener('click', (e) => {
                        document.querySelectorAll('.dropdown-menu').forEach(menu => {
                            if (!menu.parentElement.contains(e.target)) {
                                menu.classList.add('oculto');
                                // Rota el icono al cerrar
                                const icono = menu.parentElement.querySelector('.flecha-dropdown');
                                if (icono) icono.classList.remove('rotado');
                            }
                        });
                    });
                });
            </script>
            <style>
                .flecha-dropdown.rotado {
                    transform: rotate(180deg);
                    transition: transform 0.2s;
                }
            </style>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Ingrese su email"
                    value="{{ old('email', $usuario->email) }}"
                    class="@error('email') input-error @enderror">
                @error('email')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Género</label>
                <div class="dropdown dropdown-container dropdown-homogeneo">
                    <input type="hidden" name="genero" id="generoInput" value="{{ old('genero', $usuario->genero) }}">
                    <div class="dropdown-toggle dropdown-homogeneo-toggle @error('genero') input-error @enderror">
                        <div>
                            <span id="generoLabel" class="dropdown-label">
                                {{ $usuario->genero ? $usuario->genero : 'Selecciona tu género' }}
                            </span>
                        </div>
                        <i class="ri-arrow-down-s-line flecha-dropdown"></i>
                    </div>
                    <div class="dropdown-menu oculto">
                        @php
                            $generos = [
                                'Masculino',
                                'Femenino',
                                'No Binario',
                                'Transgénero',
                                'Otro',
                                'Prefiero no decirlo'
                            ];
                        @endphp
                        @foreach ($generos as $genero)
                            <h3 class="dropdown-opcion" data-value="{{ $genero }}" data-text="{{ $genero }}">
                                {{ $genero }}
                            </h3>
                        @endforeach
                    </div>
                </div>
                @error('genero')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>
            


        </div>

        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" placeholder="Ingrese una descripción" rows="3" class="@error('descripcion') input-error @enderror">{{ old('descripcion', $usuario->descripcion) }}</textarea>
            @error('descripcion')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Ciudad</label>
                <input type="text" placeholder="Ingrese su ciudad" name="ciudad_residencia"
                    value="{{ old('ciudad_residencia', $usuario->ciudad_residencia) }}"
                    class="@error('ciudad_residencia') input-error @enderror">
                @error('ciudad_residencia')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>País de residencia</label>
                <input type="text" name="nacionalidad" placeholder="Ingrese su pais de residencia"
                    value="{{ old('nacionalidad', $usuario->nacionalidad) }}"
                    class="@error('nacionalidad') input-error @enderror">
                @error('nacionalidad')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" placeholder="Ingrese su telefono"
                value="{{ old('telefono', $usuario->telefono) }}" pattern="[0-9]*" inputmode="numeric"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="11"
                class="@error('telefono') input-error @enderror">
            @error('telefono')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror

        </div>
        <div class="form-group">
            <label>DNI</label>
            <input type="text" name="dni" maxlength="11" placeholder="Ingrese su DNI"
                value="{{ old('dni', $usuario->dni) }}" pattern="[0-9]*" inputmode="numeric"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                class="@error('dni') input-error @enderror">
            @error('dni')
            <div class="error-mensaje">{{ $message }}</div>
            @enderror

        </div>


        <div class="form-group" style="display: flex; align-items: center;">

            <div style="flex: 1;">
                <label>Sitio web personal</label>
                <input type="text" name="sitio_web" id="sitio_web_input"
                    placeholder="Ingrese su sitio web personal" value="{{ old('sitio_web', $usuario->sitio_web) }}"
                    class="@error('sitio_web') input-error @enderror">
                @error('sitio_web')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror

            </div>
        </div>

        <div style="text-align: right;">
            <button type="submit" class="boton-actualizar">
                <i class="ri-refresh-line"></i>
                {{ $usuario->perfil_completado ? 'Actualizar cambios' : 'Completar perfil' }}
            </button>
        </div>

    </div>

    <script>
        document.getElementById('sitio_web_input').addEventListener('input', function() {
            const valor = this.value.trim();
            const error = document.getElementById('sitio_web_error');

            if (valor === '') {
                // Campo vacío es válido
                error.style.display = 'none';
                this.setCustomValidity('');
            } else {
                try {
                    const url = new URL(valor);
                    error.style.display = 'none';
                    this.setCustomValidity('');
                } catch (e) {
                    // URL inválida
                    error.style.display = 'block';
                    this.setCustomValidity('URL inválida');
                }
            }
        });
    </script>

</form>
@endsection