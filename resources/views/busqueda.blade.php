<!-- //Esta vista Blade muestra la página de búsqueda de ofertas laborales, incluyendo un formulario con múltiples filtros (título, empresa, ubicación, carrera, habilidades técnicas y blandas, idiomas, modalidad, disponibilidad horaria, experiencia y rango salarial), permitiendo aplicar o limpiar filtros; genera dinámicamente la lista de ofertas con información detallada (imagen, título, empresa, ubicación, salario, horario, modalidad, experiencia, descripción, requisitos, habilidades blandas, idiomas, preguntas, beneficios y palabras clave) y botones para guardar o postularse; cada oferta tiene un modal con todos los detalles, adaptado a escritorio y móvil, y se muestran mensajes cuando no hay resultados. -->


@extends('layouts.app2')

@section('content')


<!-- Contenedor principal de la página de ofertas -->
<div class="container_home">

    <!-- Sección que contiene todos los filtros de búsqueda -->
    <section class="filtros_container">

        <!-- Formulario que envía los filtros por método GET a la ruta 'busqueda' -->
        <form method="GET" action="{{ route('bolsadetrabajo.busqueda') }}">

            <!-- Sección del buscador principal -->
            <div class="filtros_buscar_trabajo_busqueda">

                <div class="filtros_buscar_trabajo_busqueda_titulo">
                    <h1>Buscar trabajos</h1>

                    <!-- Dropdown para seleccionar el orden de las ofertas -->
                    <div class="filtros_buscar_trabajo_busqueda_ordenar dropdown dropdown-container">
                        <div class="dropdown-toggle">
                            <span class="dropdown-label">{{ $orden === 'antiguas' ? 'Más antiguas' : 'Más recientes' }}</span>
                            <i class="ri-arrow-down-s-line flecha-dropdown"></i>
                        </div>

                        <!-- Opciones del dropdown -->
                        <div class="filtros_buscar_trabajo_busqueda_ordenar_opciones dropdown-menu oculto">
                            <h3 class="dropdown-opcion">Más recientes</h3>
                            <h3 class="dropdown-opcion">Más antiguas</h3>
                        </div>
                    </div>
                    <!-- Input oculto que contiene el valor del orden actual -->
                    <input type="hidden" name="orden" id="ordenInput" value="{{ $orden ?? 'recientes' }}">
                </div>

                <!-- Input para buscar por título o empresa -->
                <div class="filtros_buscar_trabajo_busqueda_input">
                    <input class="effect-1" type="text" name="busqueda" placeholder="Buscar por título o empresa" value="{{ request('busqueda') }}">
                    <span class="focus-border"></span>
                </div>
            </div>

            <!-- Filtro por ubicación -->
            <div class="filtros_ubicacion">
                <div class="filtros_ubicacion_titulo">
                    <h2><i class="ri-map-pin-line"></i> Ubicación</h2>
                </div>
                <div class="filtros_ubicacion_input">
                    <input type="text" name="ubicacion" placeholder="Buscar por ciudad o país" value="{{ request('ubicacion') }}">
                </div>
            </div>


            <!--
                Bloque de filtros por carrera: muestra una lista de checkboxes para filtrar resultados según las carreras disponibles.
            -->
            <div class="filtros_carrera filtros_general">
                <div class="filtros_carrera_titulo filtros_general_titulo">
                    <h2><i class="ri-graduation-cap-line"></i> Carrera</h2>
                    <i class="ri-arrow-down-s-line flecha-carrera"></i>
                </div>

                <!-- Genera una lista de checkboxes para filtrar por carreras disponibles -->
                <div class="filtros_carrera_opciones filtros_general_opciones colapsado" id="contenido-carrera">
                    @foreach($carreras as $carrera)
                    <div class="filtros_carrera_opciones_item filtros_general_opciones_item">
                        <!-- Checkbox para seleccionar una carrera, marcando si ya está seleccionada en la solicitud -->
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





            <div class="filtros_habilidades_tecnicas">
                <div class="filtros_habilidades_tecnicas_titulo">
                    <h2><i class="ri-code-s-slash-line"></i> Habilidades técnicas</h2>
                </div>

                <div class="filtros_habilidades_tecnicas_opciones">
                    <div class="filtros_habilidades_tecnicas_opciones_item filtros_palabra_clave_input" style="display: flex; align-items: center; gap: 8px;">
                        <input type="text" id="inputPalabraClave" placeholder="Introduce una habilidad técnica">
                        <button id="btnAgregarPalabra" type="button" class="btn-agregar-palabra">+</button>
                        <input type="hidden" name="palabras_clave" id="palabrasClaveOculto" value="{{ request('palabras_clave') }}">
                    </div>

                    <div id="contenedorPalabras" class="tags-container"></div>
                </div>
            </div>


            <script>

            </script>


            <!--
                Muestra un filtro de habilidades blandas con checkboxes para seleccionar múltiples opciones.
            -->
            <div class="filtros_habilidades_blandas filtros_general">
                <div class="filtros_habilidades_blandas_titulo filtros_general_titulo">
                    <h2><i class="ri-shake-hands-line"></i> Habilidades blandas</h2>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                <!-- Muestra una lista de checkboxes para filtrar por habilidades blandas disponibles -->
                <div class="filtros_habilidades_blandas_opciones filtros_general_opciones colapsado">
                    @foreach($habilidades_blandas as $habilidad_blanda)
                    <div class="filtros_habilidades_blandas_opciones_item filtros_general_opciones_item">
                        <!-- Checkbox para seleccionar habilidades blandas, marcando las ya seleccionadas en la búsqueda -->
                        <input
                            type="checkbox"
                            id="habilidad_blanda_{{ $habilidad_blanda->id }}"
                            name="habilidades_blandas[]"
                            value="{{ $habilidad_blanda->id }}"
                            {{ is_array(request('habilidades_blandas')) && in_array($habilidad_blanda->id, request('habilidades_blandas')) ? 'checked' : '' }}>
                        <label for="habilidad_blanda_{{$habilidad_blanda -> id}}">{{ $habilidad_blanda->descripcion }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Muestra un filtro de selección múltiple de idiomas disponibles usando checkboxes en la vista de búsqueda. -->
            <div class="filtros_idiomas filtros_general">
                <div class="filtros_idiomas_titulo filtros_general_titulo">
                    <h2><i class="ri-translate"></i> Idiomas</h2>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                <!-- Muestra una lista de checkboxes para filtrar por idiomas disponibles en la búsqueda -->
                <div class="filtros_idiomas_opciones filtros_general_opciones colapsado">
                    @foreach($idiomas_disponibles as $idioma_disponible)
                    <div class="filtros_idiomas_opciones_item filtros_general_opciones_item">
                        <!-- Checkbox para seleccionar un idioma disponible, marcando si ya está seleccionado en la solicitud -->
                        <input
                            type="checkbox"
                            id="idioma_disponible_{{ $idioma_disponible->id }}"
                            name="idiomas_disponibles[]"
                            value="{{ $idioma_disponible->id }}"
                            {{ (is_array(request('idiomas_disponibles')) && in_array($idioma_disponible->id, request('idiomas_disponibles'))) ? 'checked' : '' }}>

                        <label for="idioma_disponible_{{ $idioma_disponible->id }}">{{ $idioma_disponible->nombre_idioma }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!--
                Bloque de filtros para seleccionar la modalidad de trabajo en la búsqueda.
                Genera checkboxes dinámicamente según las modalidades disponibles.
            -->
            <div class="filtros_modalidad filtros_general">
                <div class="filtros_modalidad_titulo filtros_general_titulo">
                    <h2><i class="ri-building-line"></i> Modalidad de trabajo</h2>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                <!-- Genera una lista de checkboxes para filtrar por modalidades disponibles -->
                <div class="filtros_modalidad_opciones filtros_general_opciones colapsado">
                    @foreach($modalidades as $modalidad)
                    <div class="filtros_modalidad_opciones_item filtros_general_opciones_item">
                        <!-- Checkbox para seleccionar modalidades, marcando como 'checked' si está seleccionada en la solicitud -->
                        <input
                            type="checkbox"
                            id="modalidad_{{ $modalidad->id }}"
                            name="modalidades[]"
                            value="{{ $modalidad->id }}"
                            {{ is_array(request('modalidades')) && in_array($modalidad->id, request('modalidades')) ? 'checked' : '' }}>

                        <label for="modalidad_{{ $modalidad->id }}">{{ $modalidad->tipo }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!--
                Este bloque muestra filtros de disponibilidad horaria como checkboxes,
                permitiendo seleccionar múltiples opciones de horarios disponibles.
            -->
            <div class="filtros_horarios filtros_general">
                <div class="filtros_horarios_titulo filtros_general_titulo">
                    <h2><i class="ri-time-line"></i> Disponibilidad horaria</h2>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                <!--
                    Muestra una lista de checkboxes para filtrar por disponibilidades, marcando los seleccionados según la petición actual.
                -->
                <div class="filtros_horarios_opciones filtros_general_opciones colapsado">
                    @foreach($disponibilidades as $disponibilidad)
                    <div class="filtros_horarios_opciones_item filtros_general_opciones_item">
                        <!-- Checkbox para seleccionar disponibilidades, marcando los ya seleccionados en la solicitud -->
                        <input
                            type="checkbox"
                            id="disponibilidad_{{ $disponibilidad->id }}"
                            name="disponibilidades[]"
                            value="{{ $disponibilidad->id }}"
                            {{ is_array(request('disponibilidades')) && in_array($disponibilidad->id, request('disponibilidades')) ? 'checked' : '' }}>

                        <label for="disponibilidad_{{ $disponibilidad->id }}">{{ $disponibilidad->tipo }}</label>
                    </div>
                    @endforeach


                </div>
            </div>

            <!-- Filtros para seleccionar el rango de años de experiencia (mínimo y máximo) en la búsqueda -->
            <div class="filtros_experiencia">
                <div class="filtros_experiencia_titulo ">
                    <h2><i class="ri-hourglass-line"></i> Años de experiencia</h2>
                </div>
                <!-- Filtros de experiencia: permite ingresar valores mínimo y máximo de experiencia para la búsqueda -->
                <div class="filtros_experiencia_opciones">

                    <div class="filtros_experiencia_opciones_item">
                        <input placeholder="Minimo" type="number" id="min_experiencia" name="min_experiencia" value="{{ request('min_experiencia') }}">
                    </div>
                    <p>-</p>
                    <div class="filtros_experiencia_opciones_item">
                        <input placeholder="Maximo" type="number" id="max_experiencia" name="max_experiencia" value="{{ request('max_experiencia') }}">
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const minExp = document.getElementById('min_experiencia');
                    const maxExp = document.getElementById('max_experiencia');

                    function actualizarMaxExp() {
                        maxExp.min = minExp.value || 0;
                        if (maxExp.value && parseInt(maxExp.value) < parseInt(minExp.value || 0)) {
                            maxExp.value = minExp.value;
                        }
                    }

                    minExp.addEventListener('input', actualizarMaxExp);
                });
            </script>



            <!-- Bloque de filtros para seleccionar un rango salarial y moneda en la búsqueda de ofertas -->
            <div class="filtros_salario">
                <div class="filtros_salario_titulo">
                    <h2><i class="ri-money-dollar-circle-line"></i> Rango salarial</h2>
                </div>
                <div class="filtros_salario_opciones">
                    <!-- Campos de entrada para filtrar por salario mínimo y máximo en la búsqueda -->
                    <div class="filtros_salario_opciones_item">
                        <input placeholder="Mínimo" type="number" id="min_salario" name="min_salario" value="{{ request('min_salario') }}">
                    </div>
                    <p>-</p>
                    <div class="filtros_salario_opciones_item">
                        <input placeholder="Máximo" type="number" id="max_salario" name="max_salario" value="{{ request('max_salario') }}">
                    </div>
                    <!-- Dropdown para seleccionar la moneda (ARS o USD) en el filtro de búsqueda -->

                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const minSalario = document.getElementById('min_salario');
                    const maxSalario = document.getElementById('max_salario');

                    function actualizarMaximo() {
                        maxSalario.min = minSalario.value || 0;
                        if (maxSalario.value && parseInt(maxSalario.value) < parseInt(minSalario.value || 0)) {
                            maxSalario.value = minSalario.value;
                        }
                    }

                    minSalario.addEventListener('input', actualizarMaximo);
                });
            </script>


            <!-- Botones para limpiar o aplicar los filtros en la búsqueda -->
            <div class="filtros_botones">
                <button type="reset" class="filtros_botones_limpiar" onclick="window.location.href='{{ route('bolsadetrabajo.busqueda') }}'">Limpiar filtros</button>

                <button type="submit" class="filtros_botones_aplicar">Aplicar filtros</button>
            </div>

        </form>

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

    </section>






    <section class="ofertas_container">

        <!-- Muestra las ofertas disponibles y genera un id único para el modal de cada una -->
        @if($ofertas->count())
        @foreach($ofertas as $oferta)
        @php $modalId = 'modal_' . $oferta->id; @endphp


        <div class="ofertas_item">
            <img src="{{ $oferta->imagen ? asset('storage/ofertas/' . $oferta->imagen) : asset('images/company9.jpg') }}" alt="Foto de {{ $oferta->empresa }}">


            <div class="ofertas_item_info">
                <!-- Muestra el título de la oferta, la empresa y un icono para guardar la oferta -->
                <div class="ofertas_item_info_titulo_empresa_guardar">
                    <div class="ofertas_item_info_titulo_empresa">
                        <h2>{{ $oferta->titulo }}</h2>
                        <h3>{{ $oferta->empresa }}</h3>
                    </div>
                    @if($oferta->guardada)
                    {{-- Mostrar botón para eliminar si ya está guardada --}}
                    <form action="{{ route('bolsadetrabajo.guardar.oferta.destroy', $oferta->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; cursor:pointer;">
                            <i style="color: #700101" class="ri-bookmark-fill"></i>
                        </button>
                    </form>
                    @else
                    {{-- Mostrar botón para guardar si aún no está guardada --}}
                    <form action="{{ route('bolsadetrabajo.guardar.oferta.store') }}" method="POST" style="display:inline">
                        @csrf
                        <input type="hidden" name="oferta_id" value="{{ $oferta->id }}">
                        <button class="guardar_oferta" type="submit" style="background:none; border:none; cursor:pointer;">
                            <i class="ri-bookmark-line"></i>
                        </button>
                    </form>
                    @endif
                </div>

                <!-- Muestra la ubicación y el tiempo transcurrido desde la publicación de la oferta -->
                <div class="ofertas_item_info_ubicacion_y_hora_de_subida hide_mobile">
                    <h3><i class="ri-map-pin-line"></i> {{ $oferta->ubicacion }}</h3>
                    <h3><i class="ri-book-open-line"></i> {{ $oferta->carrera->descripcion }}</h3>
                    <h3><i class="ri-time-line"></i> Publicado {{ $oferta->created_at->diffForHumans() }}</h3>
                </div>

                <!-- Muestra la descripción de la oferta en la vista de búsqueda -->
                <div class="ofertas_item_info_descripcion">
                    <p>{{ $oferta->descripcion }}</p>
                </div>

                <!-- Muestra las características principales de la oferta laboral (salario, horario, modalidad y experiencia) -->
                <div class="ofertas_item_info_botones">
                    <div class="ofertas_item_info_botones_caracteristicas">

                        <!-- Muestra el salario de la oferta con formato y moneda -->
                        <div class="ofertas_item_info_botones_caracteristicas_item  hide_mobile">
                            <h3><i class="ri-money-dollar-circle-line"></i> ARS${{ number_format($oferta->salario, 0, ',', '.') }}</h3>
                        </div>

                        <!-- Muestra el salario de la oferta en formato moneda solo en telefonos -->
                        <div class="ofertas_item_info_botones_caracteristicas_item hide_desktopp">
                            <h3><i class="ri-money-dollar-circle-line"></i> ARS{{ number_format($oferta->salario, 0, ',', '.') }}</h3>
                        </div>

                        <!-- Muestra el tipo de horario de la oferta -->
                        <div class="ofertas_item_info_botones_caracteristicas_item">
                            <h3><i class="ri-briefcase-4-line"></i> {{ $oferta->horario->tipo }}</h3>
                        </div>

                        <!-- Muestra el tipo de modalidad de la oferta  -->
                        <div class="ofertas_item_info_botones_caracteristicas_item">
                            <h3><i class="ri-building-line"></i> {{ $oferta->modalidad->tipo }}</h3>
                        </div>

                        <!-- Muestra los años de experiencia requeridos para la oferta -->
                        <div class="ofertas_item_info_botones_caracteristicas_item hide_mobile">
                            <h3><i class="ri-hourglass-line"></i>
                                @if($oferta->años_experiencia == 0)
                                Sin experiencia
                                @else
                                + {{ $oferta->años_experiencia }} años de experiencia
                                @endif</h3>
                        </div>

                        <!-- Muestra los años de experiencia requeridos para la oferta en celulares -->
                        <div class="ofertas_item_info_botones_caracteristicas_item hide_desktopp">
                            <h3><i class="ri-hourglass-line"></i>
                                @if($oferta->años_experiencia == 0)
                                Sin experiencia
                                @else
                                + {{ $oferta->años_experiencia }} años
                                @endif</h3>
                        </div>

                    </div>

                    <!-- Muestra la fecha de publicación y un botón para ver más detalles de la oferta en un modal -->
                    <div class="ofertas_item_info_botones_ver">

                        <h3 class="hide"><i class="ri-time-line"></i> Publicado {{ $oferta->created_at->diffForHumans() }}</h3>

                        <button class="open-modal-btn" data-modal-id="{{ $modalId }}">
                            <i class="ri-eye-line"></i> Ver más
                        </button>

                    </div>


                </div>
            </div>

        </div>
        <!-- Contenedor de un modal identificado por un ID dinámico -->
        <div class="modal-container" id="{{ $modalId }}">
            <div class="modal">

                <!-- Muestra la cabecera del modal con imagen, título, empresa, ubicación, fecha de publicación y botón de cierre -->
                <div class="modal_img_titulo_close">
                    <img src="{{ $oferta->imagen ? asset('storage/ofertas/' . $oferta->imagen) : asset('images/company9.jpg') }}" alt="Logo de {{ $oferta->empresa }}">

                    <div class="modal_titulo_empresa_close">
                        <!-- Muestra el título, empresa, ubicación y tiempo de publicación de una oferta -->
                        <div class="modal_titulo_empresa">
                            <h2>{{ $oferta->titulo }}</h2>
                            <h3>{{ $oferta->empresa }}</h3>
                            <div class="ubi_time">
                                <h4><i class="ri-map-pin-line"></i> {{ $oferta->ubicacion }}</h4>
                                <!-- Muestra la carrera -->
                                <h4><i class="ri-book-open-line"></i> {{ $oferta->carrera->descripcion }}</h4>
                                <h4 class="hide_mobile"><i class="ri-time-line"></i> Publicado {{ $oferta->created_at->diffForHumans() }}</h4>
                            </div>
                        </div>
                        <span class="close-modal-btn"><i class="ri-close-line"></i></span>
                    </div>
                </div>

                <!-- Muestra información de la oferta laboral (salario, horario, modalidad y experiencia), adaptando el formato según el dispositivo -->
                <div class="modal_info_oferta">
                    <!-- Muestra el salario de la oferta en formato moneda, solo en versión escritorio -->
                    <div class="modal_info_oferta_item hide_mobile">
                        <h3><i class="ri-money-dollar-circle-line"></i> ARS${{ number_format($oferta->salario, 0, ',', '.') }}</h3>
                    </div>
                    <!-- Muestra el salario de la oferta en formato legible solo en telefonos -->
                    <div class="modal_info_oferta_item hide_desktopp">
                        <h3><i class="ri-money-dollar-circle-line"></i> ARS{{ number_format($oferta->salario, 0, ',', '.') }}</h3>
                    </div>
                    <!-- Muestra el tipo de horario de la oferta -->
                    <div class="modal_info_oferta_item">
                        <h3><i class="ri-briefcase-4-line"></i> {{ $oferta->horario->tipo }}</h3>
                    </div>
                    <!-- Muestra la modalidad de la oferta-->
                    <div class="modal_info_oferta_item">
                        <h3><i class="ri-building-line"></i> {{ $oferta->modalidad->tipo }}</h3>
                    </div>
                    <!-- Muestra los años de experiencia requeridos para la oferta en la vista de modal -->
                    <div class="modal_info_oferta_item hide_mobile">
                        <h3><i class="ri-hourglass-line"></i>
                            @if($oferta->años_experiencia == 0)
                            Sin experiencia
                            @else
                            + {{ $oferta->años_experiencia }} años de experiencia
                            @endif</h3>
                    </div>
                    <!-- Muestra los años de experiencia requeridos para la oferta en vista de celular -->
                    <div class="modal_info_oferta_item hide_desktopp">
                        <h3><i class="ri-hourglass-line"></i>
                            @if($oferta->años_experiencia == 0)
                            Sin experiencia
                            @else
                            +{{ $oferta->años_experiencia }} años
                            @endif</h3>
                    </div>

                </div>

                <!-- Muestra la descripción del puesto de la oferta seleccionada en un modal -->
                <div class="modal_descripcion_oferta">
                    <h2><i class="ri-file-list-3-line"></i> Descripción del puesto</h2>
                    <p>{{ $oferta->descripcion }}</p>
                </div>



                <!-- Muestra una lista de requisitos de la oferta dentro de un modal -->
                <div class="modal_requisitos_oferta">
                    <h2><i class="ri-check-double-line"></i> Requisitos</h2>
                    @if($oferta->requisitos->isEmpty())
                    <p><i class="ri-information-line"></i> Esta oferta no tiene requisitos.</p>
                    @else
                    @foreach($oferta->requisitos as $requisito)
                    <p><i class="ri-checkbox-circle-line"></i> {{ $requisito->requisito }}</p>
                    @endforeach
                    @endif
                </div>

                <!-- Muestra una lista de habilidades blandas  -->
                <div class="modal_requisitos_oferta">
                    <h2><i class="ri-team-line"></i> Habilidades Blandas</h2>
                    @if($oferta->habilidadesBlandas->isEmpty())
                    <p><i class="ri-information-line"></i> Esta oferta no tiene habilidades blandas.</p>
                    @else
                    @foreach($oferta->habilidadesBlandas as $habilidad)
                    <p><i class="ri-user-heart-line"></i> {{ $habilidad->descripcion }}</p>
                    @endforeach
                    @endif
                </div>

                <div class="modal_tags_oferta">
                    <h2><i class="ri-global-line"></i> Idiomas</h2>
                    @if($oferta->idiomas->isEmpty())
                    <p><i class="ri-information-line"></i> Esta oferta no tiene idiomas.</p>
                    @else
                    @foreach($oferta->idiomas as $idioma)
                    <p><i class="ri-earth-line"></i> {{ $idioma->nombre_idioma }}</p>
                    @endforeach
                    @endif
                </div>

                <div class="modal_tags_oferta">
                    <h2><i class="ri-questionnaire-line"></i> Preguntas</h2>
                    @if($oferta->preguntas->isEmpty())
                    <p><i class="ri-information-line"></i> Esta oferta no tiene preguntas.</p>
                    @else
                    @foreach($oferta->preguntas as $pregunta)
                    <p><i class="ri-survey-line"></i> {{ $pregunta->pregunta }}</p>
                    @endforeach
                    @endif
                </div>

                <!-- Muestra una lista de beneficios asociados a la oferta -->
                <div class="modal_beneficios_oferta">
                    <h2><i class="ri-gift-2-line"></i> Beneficios</h2>
                    @if($oferta->beneficios->isEmpty())
                    <p><i class="ri-information-line"></i> Esta oferta no tiene beneficios.</p>
                    @else
                    @foreach($oferta->beneficios as $beneficio)
                    <p><i class="ri-bard-line"></i> {{ $beneficio->beneficio }}</p>
                    @endforeach
                    @endif
                </div>


                <div class="modal_tags_oferta">
                    <h2><i class="ri-price-tag-3-line"></i> Habilidades técnicas</h2>
                    @if($oferta->palabras->isEmpty())
                    <p><i class="ri-information-line"></i> Esta oferta no tiene Habilidades técnicas.</p>
                    @else
                    @foreach($oferta->palabras as $palabra)
                    <p><i class="ri-hashtag"></i> {{ $palabra->palabra }}</p>
                    @endforeach
                    @endif
                </div>



                <!-- Muestra información de la oferta y botones para guardar o aplicar -->
                <div class="modal_aplicar_oferta">
                    <h3 class="hide"><i class="ri-time-line"></i> Publicado {{ $oferta->created_at->diffForHumans() }}</h3>
                    <div class="modal_botones_aplicar">
                        @if($oferta->guardada)
                        {{-- Mostrar botón para eliminar si ya está guardada --}}
                        <form action="{{ route('bolsadetrabajo.guardar.oferta.destroy', $oferta->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; cursor:pointer;">
                                <i style="color: #700101" class="ri-bookmark-fill"></i>
                            </button>
                        </form>
                        @else
                        {{-- Mostrar botón para guardar si aún no está guardada --}}
                        <form action="{{ route('bolsadetrabajo.guardar.oferta.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="oferta_id" value="{{ $oferta->id }}">
                            <button class="btn-guardar-oferta" type="submit" style="background:none; border:none; cursor:pointer;">
                                <i class="ri-bookmark-line"></i>
                            </button>
                        </form>
                        @endif

                        {{-- Botón Aplicar / Despostularse --}}
                        @php
                        // Buscar si el usuario ya tiene una postulación "En proceso" para esta oferta
                        $postulacion = \App\Models\Postulacion::where('usuario_id', $usuario->id)
                        ->where('oferta_id', $oferta->id)
                        ->where('estado_postulacion', 'En proceso')
                        ->first();
                        @endphp

                        <div class="modal_botones_aplicar" style="display:flex; align-items:center; gap:10px;">
                            @if($postulacion)
                            {{-- Botón para despostularse --}}
                            <form action="{{ route('bolsadetrabajo.postulaciones.cancelar', $postulacion->id) }}"
                                method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('¿Seguro que quieres desaplicarte de esta oferta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminarpostulacion" title="Desaplicar" style="background:none; border:none; cursor:pointer;">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>

                            {{-- Botón deshabilitado que muestra "Aplicado" --}}
                            <button class="ofertas_item_info_botones_aplicar" disabled>
                                <i class="ri-send-plane-fill"></i> Aplicado
                            </button>
                            @else
                            {{-- Botón para aplicar --}}
                            <form action="{{ route('bolsadetrabajo.postulaciones.store') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="oferta_id" value="{{ $oferta->id }}">
                                <button type="submit" class="ofertas_item_info_botones_aplicar">
                                    <i class="ri-send-plane-fill"></i> Aplicar
                                </button>
                            </form>
                            @endif
                        </div>


                    </div>
                </div>

            </div>
        </div>
        <!-- Muestra un mensaje si no hay resultados en la búsqueda de ofertas -->
        @endforeach
        @else
        <p class="mensaje-sin-resultados">No se encuentran ofertas.</p>
        @endif

    </section>
</div>

@include('partials.popup_lista_espera')

@endsection
