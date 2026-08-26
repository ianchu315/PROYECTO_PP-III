<!-- //Esta vista Blade muestra el perfil del usuario con su información personal, experiencias laborales y aptitudes; incluye una sección móvil con filtros rápidos de ofertas de trabajo; lista las ofertas recientes con detalles completos en modales y permite al usuario guardar, aplicar o desaplicarse de las ofertas, mostrando mensajes cuando no hay datos disponibles y adaptándose a escritorio y móvil. -->


@extends('layouts.app2')

@section('content')

<div class="container_home">


    <section class="perfil_container">
        <div class="perfil_info">
            <div class="perfil_info_img">
                <img src="{{ $usuario->foto_perfil ? url('perfil/' . $usuario->foto_perfil) : asset('images/user1.png') }}" width="120" alt="Foto de {{$usuario->nombre}} {{$usuario->apellido}}">

            </div>
            <div class="perfil_info_personal">
                <h1> {{ $usuario->nombre }} {{ $usuario->apellido }} </h1>
                <h2>{{ $usuario->carrera->descripcion ?? 'Sin carrera asignada' }}</h2>
                <h3><i class="ri-map-pin-line"></i> {{ $usuario->ciudad_residencia ?? 'Sin ciudad asignada' }}</h3>
            </div>
            <div class="perfil_info_boton">
                <a href="{{ route('bolsadetrabajo.perfil.editar') }}">
                    <button><i class="ri-pencil-line"></i> Editar perfil</button>
                </a>
            </div>

        </div>

        <div class="perfil_info_experiencias">
            <h2>Experiencias</h2>
            @if($usuario->experienciasLaborales->isEmpty())
            <p class="sin-datos">Sin experiencias registradas.</p>
            @else
            <div class="perfil_info_experiencias_items">
                @foreach($usuario->experienciasLaborales->take(3) as $exp)
                <div class="perfil_info_experiencias_item">
                    <img src="/images/company9.jpg" alt="Foto de $oferta->empresa" width="50" height="50">
                    <div class="perfil_info_experiencias_item_info">
                        <h3>{{ $exp->puesto }}</h3>
                        <h4>{{ $exp->empresa }} <span class="dot"></span> <span class="horario-badge">{{ $exp->horario }}</span></h4>
                        <p>{{ \Carbon\Carbon::parse($exp->año_inicio)->format('m/Y') }}
                            -
                            {{ $exp->año_fin ? \Carbon\Carbon::parse($exp->año_fin)->format('m/Y') : 'Actualidad' }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="perfil_info_aptitudes">
            <h2>Aptitudes</h2>
            @if($usuario->aptitudes->isEmpty())
            <p class="sin-datos">Sin aptitudes registradas.</p>
            @else
            <div class="perfil_info_aptitudes_item">
                @foreach($usuario->aptitudes->take(4) as $apt)
                <div class="aptitud_item">
                    <span><i class="ri-verified-badge-line"></i></span>
                    <p>{{ $apt->aptitud }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>


    </section>


    <div class="perfil_mobile">
        <div class="perfil_mobile_info">
            <h1>Hola</h1>
            <h1 class="rojo">{{ $usuario->nombre }} {{ $usuario->apellido }}</h1>
        </div>

        <div class="perfil_mobile_trabajo">
            <h3>Encontrá tu trabajo</h3>
            <div class="perfil_mobile_trabajo_filtros">

                <!-- Remotos -->
                <a href="{{ route('bolsadetrabajo.busqueda', ['modalidades[]' => 2]) }}">
                    <div class="perfil_mobile_trabajo_filtros_item">
                        <i class="ri-home-4-line"></i>
                        <div class="perfil_mobile_trabajo_item_texto">
                            <h4>{{ $remotas }}</h4>
                            <h5>Remotos</h5>
                        </div>
                    </div>
                </a>

                <!-- Full-Time -->
                <a href="{{ route('bolsadetrabajo.busqueda', ['disponibilidades[]' => 1]) }}">
                    <div class="perfil_mobile_trabajo_filtros_item">
                        <i class="ri-time-line"></i>
                        <div class="perfil_mobile_trabajo_item_texto">
                            <h4>{{ $fullTime }}</h4>
                            <h5>Full-Time</h5>
                        </div>
                    </div>
                </a>

                <!-- Presenciales -->
                <a href="{{ route('bolsadetrabajo.busqueda', ['modalidades[]' => 1]) }}">
                    <div class="perfil_mobile_trabajo_filtros_item">
                        <i class="ri-building-line"></i>
                        <div class="perfil_mobile_trabajo_item_texto">
                            <h4>{{ $presenciales }}</h4>
                            <h5>Presenciales</h5>
                        </div>
                    </div>
                </a>

                <!-- Part-Time -->
                <a href="{{ route('bolsadetrabajo.busqueda', ['disponibilidades[]' => 2]) }}">
                    <div class="perfil_mobile_trabajo_filtros_item">
                        <i class="ri-timer-2-line"></i>
                        <div class="perfil_mobile_trabajo_item_texto">
                            <h4>{{ $partTime }}</h4>
                            <h5>Part-Time</h5>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>






    <section class="ofertas_container">
        <h3 class="hide_desktop">Ofertas recientes</h3>
        @if($ofertas->count())
        @foreach($ofertas as $oferta)
        @php $modalId = 'modal_' . $oferta->id; @endphp


        <div class="ofertas_item">
            <img src="{{ $oferta->imagen ? asset('storage/ofertas/' . $oferta->imagen) :  asset('images/company9.jpg') }}" alt="Foto de {{ $oferta->empresa }}">


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
                    <h3><i class="ri-book-open-line"></i> {{ str_replace('Tecnicatura Superior en ', '', $oferta->carrera->descripcion) }}</h3>
                    <h3 ><i class="ri-time-line"></i> Publicado {{ $oferta->created_at->diffForHumans() }}</h3>
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
                            <h3><i class="ri-money-dollar-circle-line"></i> ARS{{ number_format($oferta->salario, 0, ',', '.')}}</h3>
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
                        <h3><i class="ri-money-dollar-circle-line"></i> ARS{{ number_format($oferta->salario, 0, ',', '.')}}</h3>
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
                            @endif
                        </h3>
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

                        @php
                        $postulacion = $usuario->postulaciones
                        ->where('oferta_id', $oferta->id)
                        ->where('estado_postulacion', 'En proceso')
                        ->first();
                        @endphp

                        <div class="modal_botones_aplicar" style="display:flex; align-items:center; gap:10px;">

                            @if($postulacion)
                            <!-- Tachito para desaplicarse -->
                            <form action="{{ route('bolsadetrabajo.postulaciones.cancelar', $postulacion->id) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('¿Seguro que quieres desaplicarte de esta oferta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminarpostulacion" title="Desaplicar" style="background:none; border:none; cursor:pointer;">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>

                            <!-- Botón Aplicado con estilo original -->
                            <button class="ofertas_item_info_botones_aplicar" disabled>
                                <i class="ri-send-plane-fill"></i> Aplicado
                            </button>
                            @else
                            <!-- Botón Aplicar -->
                            <form action="{{ route('bolsadetrabajo.postulaciones.store') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="oferta_id" value="{{ $oferta->id }}">
                                <button type="submit" class="ofertas_item_info_botones_aplicar">
                                    <i class="ri-send-plane-fill"></i> Aplicar
                                </button>
                            </form>
                            @endif

                        </div>
                        <script>
                            document.querySelectorAll('.form-desaplicar-modal').forEach(form => {
                                form.addEventListener('submit', function(e) {
                                    e.preventDefault();
                                    if (confirm('¿Seguro que quieres desaplicarte de esta oferta?')) {
                                        fetch(this.action, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': this.querySelector('[name=_token]').value,
                                                'Accept': 'application/json'
                                            }
                                        }).then(res => {
                                            if (res.ok) {
                                                // Oculta el formulario y habilita el botón Aplicar
                                                this.remove();
                                                const botonAplicar = this.nextElementSibling;
                                                if (botonAplicar) {
                                                    botonAplicar.disabled = false;
                                                    botonAplicar.innerHTML = '<i class="ri-send-plane-fill"></i> Aplicar';
                                                }
                                            } else {
                                                alert('Error al desaplicarse');
                                            }
                                        });
                                    }
                                });
                            });
                        </script>

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
@endsection