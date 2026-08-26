<!-- // Permite enviar correos a usuarios filtrados por carrera, con selección dinámica de destinatarios usando Select2 y muestra alertas de éxito temporales al enviar.
 -->


@extends('layouts.dashboard_layout')

@section('content')

<section class="comunicaciones_container">

    @if (session('success'))
    <div class="alerta-exito" id="alerta-exito">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            let alerta = document.getElementById('alerta-exito');
            if (alerta) {
                alerta.style.transition = "opacity 0.5s ease";
                alerta.style.opacity = "0";
                setTimeout(() => alerta.remove(), 500);
            }
        }, 3000); // 3 segundos
    </script>
    @endif

    <div class="comunicaciones_titulo">
        <h1>Comunicaciones</h1>
    </div>


    <form class="comunicaciones_contenido" action="{{ route('bolsadetrabajo.comunicaciones.enviar') }}" method="POST">



        @csrf
        <div class="comunicaciones_form_titulo">
            <h2>Nuevo email</h2>
            <p>Envía un email a los usuarios de la plataforma.</p>
        </div>


        <div class="comunicaciones_form_contenido">

            <div class="editar_oferta_item">
                <label for="carrera_id">Carrera</label>
                <select name="carrera_id" id="carrera_id">
                    <option selected value="">Selecciona una carrera</option>
                    @foreach(\App\Models\Carrera::all() as $carrera)
                    <option value="{{ $carrera->id }}">{{ $carrera->descripcion }}</option>
                    @endforeach
                </select>
            </div>

            <div class="editar_oferta_item">
                <label for="destinatarios">Destinatarios</label>
                <select name="destinatarios[]" id="destinatarios" multiple required></select>
            </div>


            <div class="editar_oferta_item">
                <label for="asunto">Asunto</label>
                <input type="text" name="asunto" required>
            </div>

            <div class="editar_oferta_item">
                <label for="mensaje">Mensaje</label>
                <textarea name="mensaje" rows="4" required></textarea>
            </div>

            <div class="comunicaciones_form_botones">
                <button class="editar_usuario_boton" type="submit">
                    <i class="ri-mail-send-line"></i>Enviar
                </button>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $('#destinatarios').select2({
                placeholder: 'Busca por nombre, apellido o email...',
                ajax: {
                    url: "{{ route('bolsadetrabajo.comunicaciones.buscar') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                language: {
                    inputTooShort: () => "Por favor ingresa 2 o más caracteres",
                    searching: () => "Buscando...",
                    noResults: () => "No se encontraron resultados"
                }
            });

            // Cuando cambia la carrera
            $('#carrera_id').on('change', function() {
                let carreraId = $(this).val();

                if (carreraId) {
                    $.get("{{ route('bolsadetrabajo.comunicaciones.alumnosPorCarrera', '') }}/" + carreraId, function(data) {
                        // Limpiar selección previa
                        $('#destinatarios').empty();

                        // Agregar los alumnos de la carrera
                        data.forEach(function(alumno) {
                            let option = new Option(alumno.text, alumno.id, false, true);
                            $('#destinatarios').append(option);
                        });

                        // Notificar a Select2 del cambio
                        $('#destinatarios').trigger('change');
                    });
                } else {
                    $('#destinatarios').val(null).trigger('change');
                }
            });
        </script>



    </form>











</section>

@endsection