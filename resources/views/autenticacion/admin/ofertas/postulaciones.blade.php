<!-- // Vista de dashboard que muestra todas las postulaciones a una oferta específica, permite ver el perfil completo de cada postulante en un modal y exportar a Excel los seleccionados.

 -->

@extends('layouts.dashboard_layout')

@section('content')
<div class="comunicaciones_container">

    <div class="editar_oferta_boton_container">
        <button onclick="window.location.href='/ofertas'">
            <i class="ri-arrow-left-line"></i> Volver a ofertas
        </button>
    </div>

    <div class="comunicaciones_titulo">
        <h1>Postulaciones para la oferta: {{ $oferta->titulo }}</h1>
    </div>

    {{-- Mensaje de error arriba (inicialmente oculto) --}}
    <p id="mensaje-error" style="color: red; display: none; font-weight: bold; margin-top:10px;">
        Debes seleccionar al menos un postulante para exportar.
    </p>

    @if($postulaciones->isEmpty())
    <p>No hay postulaciones aún.</p>
    @else

    <form id="exportForm" action="{{ route('postulaciones.export') }}" method="POST">
        @csrf

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
                <p><i class="ri-graduation-cap-line"></i> {{ optional($user->carrera)->carrera }}</p>
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
                                    <h4><i class="ri-graduation-cap-line"></i> {{ optional($user->carrera)->carrera }}</h4>

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