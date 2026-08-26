<!-- // Vista de dashboard que muestra todas las postulaciones a una oferta específica, permite ver el perfil completo de cada postulante en un modal y exportar a Excel los seleccionados.

 -->

@extends('layouts.dashboard_layout')

@section('content')
<div class="comunicaciones_container">

    <div class="editar_oferta_boton_container">
        <button onclick="window.location.href='/bolsadetrabajo/ofertas'">
            <i class="ri-arrow-left-line"></i> Volver a ofertas
        </button>
    </div>

    <div class="comunicaciones_titulo">
        <h1>Postulaciones para la oferta: {{ $oferta->titulo }}</h1>
        <h2>Selecciona los postulantes que deseas exportar a Excel.</h2>
    </div>

    {{-- Mensaje de error arriba (inicialmente oculto) --}}
    <p id="mensaje-error" style="color: #b71c1c; display: none; font-weight: 500; margin-top:10px;">
        Debes seleccionar al menos un postulante para exportar.
    </p>



    <section class="postulaciones_container">
        <section class="filtros_container">
            <form method="GET" action="{{ route('bolsadetrabajo.ofertas.postulaciones', $oferta->id) }}">
                <div class="filtros_buscar_trabajo_busqueda_titulo">
                    <h1>Filtrar postulantes</h1>
                </div>

                <!-- Carrera -->
                <div class="filtros_carrera filtros_general">
                    <div class="filtros_carrera_titulo filtros_general_titulo">
                        <h2><i class="ri-graduation-cap-line"></i> Carrera</h2>
                        <i class="ri-arrow-down-s-line flecha-carrera"></i>
                    </div>
                    <div class="filtros_carrera_opciones filtros_general_opciones colapsado" id="contenido-carrera">
                        @foreach($carreras as $carrera)
                        <div class="filtros_carrera_opciones_item filtros_general_opciones_item">
                            <input
                                type="checkbox"
                                id="carrera_{{ $carrera->id }}"
                                name="carreras[]"
                                value="{{ $carrera->id }}"
                                {{ is_array(request('carreras')) && in_array($carrera->id, request('carreras')) ? 'checked' : '' }}>
                            <label for="carrera_{{ $carrera->id }}">{{ $carrera->descripcion }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Idiomas -->
                <div class="filtros_idiomas filtros_general">
                    <div class="filtros_idiomas_titulo filtros_general_titulo">
                        <h2><i class="ri-translate"></i> Idiomas</h2>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="filtros_idiomas_opciones filtros_general_opciones colapsado">
                        @foreach($idiomas_disponibles as $idioma)
                        <div class="filtros_idiomas_opciones_item filtros_general_opciones_item">
                            <input
                                type="checkbox"
                                id="idioma_{{ $idioma->id }}"
                                name="idiomas_disponibles[]"
                                value="{{ $idioma->id }}"
                                {{ is_array(request('idiomas_disponibles')) && in_array($idioma->id, request('idiomas_disponibles')) ? 'checked' : '' }}>
                            <label for="idioma_{{ $idioma->id }}">{{ $idioma->nombre_idioma }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>



                <div class="filtros_aptitudes">
                    <div class="filtros_aptitudes_titulo filtros_general_titulo">
                        <h2><i class="ri-tools-line"></i> Aptitudes</h2>
                    </div>

                    <!-- Bloque de filtros para ingresar y mostrar palabras clave -->
                    <div class="filtros_aptitudes_opciones">
                        <div class="filtros_aptitudes_opciones_item filtros_palabra_clave_input" style="display: flex; align-items: center; gap: 8px;">
                            <input
                                type="text"
                                id="inputAptitudClave"
                                placeholder="Introduce aptitudes">
                            <button id="btnAgregarAptitud" type="button" class="btn-agregar-aptitud btn-agregar-palabra">+</button>
                            <input
                                type="hidden"
                                name="aptitudes_palabras"
                                id="aptitudesOculto"
                                value="{{ request('aptitudes_palabras') }}">
                        </div>

                        <div id="contenedorAptitudes" class="tags-container"></div>
                    </div>
                </div>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputAptitud = document.getElementById('inputAptitudClave');
                        const contenedorAptitudes = document.getElementById('contenedorAptitudes');
                        const campoOculto = document.getElementById('aptitudesOculto');
                        const btnAgregar = document.getElementById('btnAgregarAptitud');

                        // Cargar valores previos (si existen)
                        let aptitudes = campoOculto.value ?
                            campoOculto.value.split(',').map(a => a.trim()).filter(Boolean) :
                            [];

                        // Función para renderizar las etiquetas visuales
                        function renderAptitudes() {
                            contenedorAptitudes.innerHTML = '';
                            aptitudes.forEach((aptitud, index) => {
                                const tag = document.createElement('div');
                                tag.classList.add('tag-item');
                                tag.innerHTML = `
                <span>${aptitud}</span>
                <button type="button" class="remove-tag" data-index="${index}">&times;</button>
            `;
                                contenedorAptitudes.appendChild(tag);
                            });
                            campoOculto.value = aptitudes.join(',');
                        }

                        // Función para agregar aptitud (usada por Enter y botón +)
                        function agregarAptitud() {
                            const valor = inputAptitud.value.trim();
                            if (valor !== '' && !aptitudes.includes(valor)) {
                                aptitudes.push(valor);
                                renderAptitudes();
                                inputAptitud.value = '';
                            }
                        }

                        // Agregar aptitud al presionar Enter
                        inputAptitud.addEventListener('keydown', function(e) {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                agregarAptitud();
                            }
                        });

                        // Agregar aptitud al hacer clic en el botón +
                        btnAgregar.addEventListener('click', agregarAptitud);

                        // Eliminar aptitud al hacer clic en la X
                        contenedorAptitudes.addEventListener('click', function(e) {
                            if (e.target.classList.contains('remove-tag')) {
                                const index = e.target.getAttribute('data-index');
                                aptitudes.splice(index, 1);
                                renderAptitudes();
                            }
                        });

                        renderAptitudes(); // Inicializar etiquetas si había filtros guardados
                    });
                </script>







                <div class="filtros_botones">
                    <button type="reset" class="filtros_botones_limpiar" onclick="window.location.href='{{ route('bolsadetrabajo.ofertas.postulaciones', $oferta->id) }}'">
                        Limpiar filtros
                    </button>
                    <button type="submit" class="filtros_botones_aplicar">Aplicar filtros</button>
                </div>
            </form>
        </section>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".filtros_general").forEach(bloque => {
                    const header = bloque.querySelector(".filtros_general_titulo");
                    const content = bloque.querySelector(".filtros_general_opciones");
                    const arrow = header.querySelector("i[class*='ri-arrow']"); // toma la flecha dentro del header

                    if (!header || !content) return;

                    // Estado inicial
                    if (content.classList.contains("expandido")) {
                        content.style.maxHeight = content.scrollHeight + "px";
                        arrow?.classList.add("flecha-rotada");
                    } else {
                        content.style.maxHeight = "0px";
                    }

                    // Click toggle
                    header.addEventListener("click", () => {
                        const vaAExpandir = !content.classList.contains("expandido");

                        if (vaAExpandir) {
                            content.classList.add("expandido");
                            content.classList.remove("colapsado");
                            content.style.maxHeight = content.scrollHeight + "px";
                            arrow?.classList.add("flecha-rotada");
                        } else {
                            content.style.maxHeight = content.scrollHeight + "px";
                            void content.offsetHeight; // reflow
                            content.style.maxHeight = "0px";
                            content.classList.remove("expandido");
                            content.classList.add("colapsado");
                            arrow?.classList.remove("flecha-rotada");
                        }
                    });

                    // Recalcular en resize si está abierto
                    window.addEventListener("resize", () => {
                        if (content.classList.contains("expandido")) {
                            content.style.maxHeight = content.scrollHeight + "px";
                        }
                    });
                });
            });
        </script>






        @if($postulaciones->isEmpty())
        <p>No hay postulaciones aún.</p>
        @else
        <form id="exportForm" action="{{ route('bolsadetrabajo.postulaciones.export') }}" method="POST">
            @csrf
            <input type="hidden" name="oferta_id" value="{{ $oferta->id }}">



            <div class="postulaciones_container_items">
                @foreach($postulaciones as $postulacion)
                @php
                $user = $postulacion->usuario;
                $modalId = 'user_modal_' . $user->id;
                @endphp

                <div class="usuario_item">
                    <div class="usuario_item_foto_nombre_boton">
                        <div class="usuario_foto_nombre">
                            <div class="usuario_item_foto">
                                <img src="{{ $user->foto_perfil ? asset('storage/usuarios/' . $user->foto_perfil) : asset('images/user1.png') }}" width="120" alt="Foto de perfil">
                            </div>
                            <div class="usuario_item_nombre_boton">
                                <h2>{{ $user->nombre }}</h2>
                                <h3>{{ $user->apellido }}</h3>
                            </div>
                        </div>
                        <div class="usuario_item_boton">
                            <button type="button" class="open-modal-btn" data-modal-id="{{ $modalId }}" title="Ver perfil">
                                <i class="ri-eye-line"></i>
                            </button>
                            {{-- Checkbox con id del usuario --}}
                            <input type="checkbox" name="usuarios[]" value="{{ $user->id }}">
                        </div>
                    </div>
                    <p title="{{ optional($user->carrera)->descripcion }}"><i class="ri-graduation-cap-line"></i> {{ optional($user->carrera)->descripcion }}</p>
                    <p><i class="ri-mail-line"></i> {{ $user->email }}</p>
                    <p><i class="ri-calendar-line"></i> Postulado el {{ $postulacion->fecha_postulacion }}</p>
                </div>


                <div class="modal-container" id="{{ $modalId }}">
                    <div class="modal">
                        <div class="modal_img_titulo_close">
                            <img src="{{ $user->foto_perfil 
                                ? asset('storage/usuarios/' . $user->foto_perfil) 
                                : asset('images/user1.png') }}"
                                width="120"
                                alt="Foto de perfil">
                            <div class="modal_titulo_empresa_close">
                                <div class="modal_titulo_empresa">
                                    <h2>{{ $user->nombre }} {{ $user->apellido }}</h2>
                                    <div class="ubi_time">

                                        <h4><i class="ri-mail-line"></i> {{ $user->email }}</h4>
                                        <h4><i class="ri-graduation-cap-line"></i> {{ optional($user->carrera)->descripcion }}</h4>
                                        <h4><i class="ri-file-user-line"></i>{{ $user->dni }}</h4>
                                        <h4><i class="ri-phone-line"></i> {{ $user->telefono ?? '—' }}</h4>
                                        <h4><i class="ri-flag-line"></i> {{ $user->nacionalidad }}</h4>
                                        <h4><i class="ri-map-pin-line"></i> {{ $user->ciudad_residencia }}</h4>
                                        <h4><i class="ri-genderless-line"></i> {{ $user->genero }}</h4>
                                        <h4><i class="ri-calendar-line"></i>
                                            {{ $user->fecha_nacimiento ? \Carbon\Carbon::parse($user->fecha_nacimiento)->format('d/m/Y') : '—' }}


                                            @if(!empty($user->sitio_web))
                                            <h4><i class="ri-global-line"></i> {{ $user->sitio_web }}</h4>
                                            @endif

                                    </div>
                                </div>
                                <span class="close-modal-btn"><i class="ri-close-line"></i></span>
                            </div>
                        </div>


                        @if($user->experiencias?->count())
                        <div class="modal_requisitos_oferta">
                            <h2><i class="ri-briefcase-4-line"></i> Experiencia</h2>
                            @foreach($user->experiencias as $exp)
                            <p><i class="ri-checkbox-circle-line"></i> {{ $exp->puesto }} — {{ $exp->empresa }} ({{ $exp->año_inicio }} – {{ $exp->año_fin ?? 'Actualidad' }})</p>
                            @endforeach
                        </div>
                        @endif


                        @if($user->estudios?->count())
                        <div class="modal_beneficios_oferta">
                            <h2><i class="ri-book-open-line"></i> Estudios</h2>
                            @foreach($user->estudios as $est)
                            <p><i class="ri-graduation-cap-line"></i> {{ $est->titulo }} — {{ $est->institucion }} ({{ \Carbon\Carbon::parse($est->fecha_inicio)->format('Y') }} – {{ $est->fecha_fin ? \Carbon\Carbon::parse($est->fecha_fin)->format('Y') : 'Actualidad' }})</p>
                            @endforeach
                        </div>
                        @endif


                        @if($user->aptitudes?->count())
                        <div class="modal_beneficios_oferta">
                            <h2><i class="ri-tools-fill"></i> Aptitudes</h2>
                            @foreach($user->aptitudes as $aptitud)
                            <p><i class="ri-pushpin-line"></i> {{ $aptitud->aptitud }}</p>
                            @endforeach
                        </div>
                        @endif


                        @if($user->idiomas?->count())
                        <div class="modal_tags_oferta">
                            <h2><i class="ri-global-line"></i> Idiomas</h2>
                            @foreach($user->idiomas as $idioma)
                            <p><i class="ri-earth-line"></i> {{ $idioma->idioma }} {{ isset($idioma->nivel) ? "— Nivel: $idioma->nivel" : '' }}</p>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>


            <button type="submit" class="btn btn-success mt-3 boton-excel">
                <i class="ri-file-excel-2-line"></i> Exportar seleccionados a Excel
            </button>
        </form>
    </section>



    <script>
        document.getElementById('exportForm').addEventListener('submit', function(e) {
            const seleccionados = document.querySelectorAll('input[name="usuarios[]"]:checked');
            const mensaje = document.getElementById('mensaje-error');

            if (seleccionados.length === 0) {
                e.preventDefault();
                mensaje.style.display = 'block';
                mensaje.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Ocultar automáticamente después de 3 segundos
                setTimeout(() => {
                    mensaje.style.display = 'none';
                }, 3000);
            } else {
                mensaje.style.display = 'none';
            }
        });
    </script>
    @endif

</div>
@endsection