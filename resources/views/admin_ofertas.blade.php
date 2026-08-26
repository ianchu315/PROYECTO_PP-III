<!-- // Muestra y administra la lista de ofertas laborales, permitiendo filtrarlas, ordenarlas, crear nuevas, editar, eliminar, ver postulaciones y mostrar todos los detalles de cada oferta en un modal.
 -->


@extends('layouts.dashboard_layout')

@section('content')

<section class="admin_ofertas_container">

    <div class="admin_ofertas_titulo">
        <h1>Ofertas</h1>
    </div>


    <form method="GET" action="{{ route('bolsadetrabajo.ofertas') }}" id="filtroForm" class="admin_ofertas_botones">

        {{-- Campo de búsqueda --}}
        <div class="campo-icono">
            <i class="ri-search-2-line"></i>
            <input type="text" name="busqueda" class="admin_ofertas_buscar" placeholder="Buscar oferta..." value="{{ request('busqueda') }}">
        </div>


        {{-- Dropdown de estado --}}
        <div class="filtros_buscar_trabajo_busqueda_ordenar dropdown dropdown-container dropdown-container-admin">
            <div class="dropdown-toggle">
                <div>
                    <span class="dropdown-label">{{ ucfirst($estado ?? 'Seleccionar estado') }}</span>
                </div>
                <i class="ri-arrow-down-s-line flecha-dropdown"></i>
            </div>
            <div class="filtros_buscar_trabajo_busqueda_ordenar_opciones dropdown-menu oculto">
                <h3 class="dropdown-opcion" data-value="Activa">Activa</h3>
                <h3 class="dropdown-opcion" data-value="Finalizada">Finalizada</h3>
                <h3 class="dropdown-opcion" data-value="Borrador">Borrador</h3>
                <h3 class="dropdown-opcion" data-value="Expirada">Expirada</h3>

            </div>
        </div>
        <input type="hidden" name="estado" id="estadoInput" value="{{ $estado ?? '' }}">

        {{-- Dropdown de orden --}}
        <div class="filtros_buscar_trabajo_busqueda_ordenar dropdown dropdown-container dropdown-container-admin">
            <div class="dropdown-toggle">
                <div>
                    <span class="dropdown-label">{{ $orden === 'antiguas' ? 'Más antiguas' : 'Más recientes' }}</span>
                </div>
                <i class="ri-arrow-down-s-line flecha-dropdown"></i>
            </div>
            <div class="filtros_buscar_trabajo_busqueda_ordenar_opciones dropdown-menu oculto">
                <h3 class="dropdown-opcion">Más recientes</h3>
                <h3 class="dropdown-opcion">Más antiguas</h3>
            </div>
        </div>
        <input type="hidden" name="orden" id="ordenInput" value="{{ $orden ?? 'recientes' }}">

        <button type="button" class="btn-resetear-filtros" onclick="window.location='{{ route('bolsadetrabajo.ofertas') }}'">
            <i class="ri-refresh-line"></i> Limpiar filtros
        </button>

        <button type="button" class="admin_ofertas_crear" onclick="window.location='{{ route('bolsadetrabajo.admin.ofertas.crear') }}'">

            <i class="ri-add-line"></i> Nueva oferta
        </button>



    </form>


    <section class="ofertas_container admin_ofertas_lista">

        @if($ofertas->count())
        @foreach($ofertas as $oferta)
        @php $modalId = 'modal_' . $oferta->id; @endphp


        <div class="ofertas_item">
            <img src="{{ $oferta->imagen ? asset('storage/ofertas/' . $oferta->imagen) : asset('images/company9.jpg') }}" alt="Logo de {{ $oferta->empresa }}">




            <div class="ofertas_item_info">

                <div class="ofertas_item_info_titulo_empresa_guardar">
                    <div class="ofertas_item_info_titulo_empresa">
                        <h2>
                            {{ $oferta->titulo }}
                            <span class="ofertas_item_info_titulo_empresa_estado 
    {{ $oferta->estado->tipo === 'Activa' ? 'estado_activa' : 
       ($oferta->estado->tipo === 'Finalizada' ? 'estado_finalizada' : 
       ($oferta->estado->tipo === 'Borrador' ? 'estado_borrador' : 
       ($oferta->estado->tipo === 'Expirada' ? 'estado_expirada' : ''))) }}">
                                {{ $oferta->estado->tipo }}
                            </span>

                        </h2>
                        <h3>{{ $oferta->empresa }}</h3>
                    </div>

                    <div class="acciones_oferta_botones">


                        <div class="postulaciones_oferta_boton">

                            <a href="{{ route('bolsadetrabajo.ofertas.postulaciones', $oferta->id) }}" class="postulaciones_oferta_boton">
                                <i class="ri-group-line"></i>
                            </a>

                        </div>


                        <div class="editar_oferta_boton">
                            <a href="{{ route('bolsadetrabajo.ofertas.edit', $oferta->id) }}">
                                <button type="button">
                                    <i class="ri-edit-box-line"></i>
                                </button>
                            </a>
                        </div>


                        <div class="eliminar_oferta_boton">
                            <form action="{{ route('bolsadetrabajo.ofertas.destroy', $oferta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que querés eliminar esta oferta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>




                    </div>


                </div>


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
                            <h3><i class="ri-money-dollar-circle-line"></i> {{ number_format($oferta->salario, 0, ',', '.')}} ARS</h3>
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
                            <h3>
                                <i class="ri-hourglass-line"></i>
                                @if($oferta->años_experiencia == 0)
                                Sin experiencia
                                @else
                                + {{ $oferta->años_experiencia }} años
                                @endif
                            </h3>
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
                                <h4><i class="ri-time-line"></i> Publicado {{ $oferta->created_at->diffForHumans() }}</h4>
                            </div>
                        </div>
                        <span class="close-modal-btn"><i class="ri-close-line"></i></span>
                    </div>
                </div>

                <!-- Muestra información de la oferta laboral (salario, horario, modalidad y experiencia), adaptando el formato según el dispositivo -->
                <div class="modal_info_oferta">
                    <!-- Muestra el salario de la oferta en formato moneda, solo en versión escritorio -->
                    <div class="modal_info_oferta_item hide_mobile">
                        <h3><i class="ri-money-dollar-circle-line"></i>ARS${{ number_format($oferta->salario, 0, ',', '.') }}</h3>
                    </div>
                    <!-- Muestra el salario de la oferta en formato legible solo en telefonos -->
                    <div class="modal_info_oferta_item hide_desktopp">
                        <h3><i class="ri-money-dollar-circle-line"></i> {{ number_format($oferta->salario, 0, ',', '.')}} ARS</h3>
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
                            + {{ $oferta->años_experiencia }} años
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

</section>

@endsection