<!-- // Vista de edición de oferta que permite modificar todos los campos de la oferta, agregar/eliminar dinámicamente requisitos, beneficios, palabras clave y preguntas, seleccionar idiomas y habilidades blandas, y actualizar la imagen, con validaciones y eliminación vía AJAX. -->



@extends('layouts.dashboard_layout')

@section('content')
<div class="editar_oferta_container">

    <div class="editar_oferta_boton_container">
        <button onclick="window.location.href='/ofertas'"><i class="ri-arrow-left-line"></i>Volver a ofertas</button>

    </div>

    @if ($errors->any())
    <div class="alert alert-danger error-editar-user">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('ofertas.update', $oferta->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="editar_oferta_titulo">
            <h3>Editar información de la Oferta</h3>
            <p>Actualiza la información de la oferta de trabajo.</p>
        </div>

        <div class="editar_oferta_formulario">

            <div class="editar_oferta_item">
                <label for="imagen">Imagen actual:</label><br>
                @if ($oferta->imagen)
                <img src="{{ asset('storage/ofertas/' . $oferta->imagen) }}" alt="Imagen actual" width="150">
                @else
                <p>No hay imagen cargada.</p>
                @endif

                <br><label for="nueva_imagen">Cambiar imagen:</label>
                <input type="file" name="nueva_imagen" id="nueva_imagen" accept="image/*">
            </div>


            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" value="{{ $oferta->titulo }}" required>
                </div>

                <div class="editar_oferta_item">
                    <label for="empresa">Empresa</label>
                    <input type="text" name="empresa" id="empresa" value="{{ $oferta->empresa }}" required>
                </div>
            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="ubicacion">Ubicación</label>
                    <input type="text" name="ubicacion" id="ubicacion" value="{{ $oferta->ubicacion }}" required>
                </div>

                <div class="editar_oferta_item">
                    <label for="carerra">Carerra</label>
                    <select name="carrera_id" required>
                        @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ $oferta->carrera_id == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->carrera }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="editar_oferta_item">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" required>{{ $oferta->descripcion }}</textarea>
            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="salario">Salario</label>
                    <input
                        type="text"
                        name="salario"
                        id="salario"
                        value="{{ number_format($oferta->salario, 0, '', '.') }}"
                        required
                        oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
                </div>

                <div class="editar_oferta_item">
                    <label for="horarios">Horarios</label>
                    <select name="horario_id">
                        @foreach($horarios as $horario)
                        <option value="{{ $horario->id }}" {{ $oferta->horario->id == $horario->id ? 'selected' : '' }}>
                            {{ $horario->tipo }}
                        </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="modalidad">Modalidad</label>
                    <select name="modalidad_id">
                        @foreach($modalidades as $modalidad)
                        <option value="{{ $modalidad->id }}" {{ $oferta->modalidad->id == $modalidad->id ? 'selected' : '' }}>
                            {{ $modalidad->tipo }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="editar_oferta_item">
                    <label for="experiencia">Experiencia</label>
                    <input type="text" name="años_experiencia" value="{{ $oferta->años_experiencia }}" required placeholder="Años de experiencia" min="0" step="1">
                </div>
            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="estado">Estado</label>
                    <select name="estado_id">
                        @foreach($estados as $estado)
                        <option value="{{ $estado->id }}"
                            {{ $oferta->estado_id === $estado->id ? 'selected' : '' }}>
                            {{ $estado->tipo }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="editar_oferta_item">
                    <label for="fecha_expiracion">Fecha de Expiración</label>
                    <input
                        type="date"
                        name="fecha_expiracion"
                        id="fecha_expiracion"
                        value="{{ $oferta->fecha_expiracion ? \Carbon\Carbon::parse($oferta->fecha_expiracion)->format('Y-m-d') : '' }}"
                        required
                        min="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">


                </div>
            </div>


            <div id="requisitos_container" class="editar_oferta_item">
                <label for="requisitos">Requisitos</label>
                <div id="requisitos-list" class="edit-list">
                    @foreach ($oferta->requisitos as $requisito)
                    <div class="global_item requisito-item" data-id="{{ $requisito->id }}">
                        <input type="text" name="requisitos[{{ $requisito->id }}]" value="{{ $requisito->requisito }}">
                        <button type="button" class="editar_eliminar eliminar-requisito" data-id="{{ $requisito->id }}">
                            x
                        </button>
                    </div>
                    @endforeach
                </div>
                <button class="editar_agregar" type="button" id="agregar-requisito">
                    <i class="ri-add-line"></i> Agregar requisito
                </button>
            </div>






            <div id="beneficios_container" class="editar_oferta_item">
                <label for="beneficios">Beneficios</label>
                <div id="beneficios-list" class="edit-list">
                    @foreach ($oferta->beneficios as $beneficio)
                    <div class="global_item beneficio-item" data-id="{{ $beneficio->id }}">
                        <input type="text" name="beneficios[{{ $beneficio->id }}]" value="{{ $beneficio->beneficio }}">
                        <button type="button" class="editar_eliminar eliminar-beneficio" data-id="{{ $beneficio->id }}">
                            x
                        </button>
                    </div>
                    @endforeach
                </div>
                <button class="editar_agregar" type="button" id="agregar-beneficio">
                    <i class="ri-add-line"></i> Agregar beneficio
                </button>
            </div>




            <div id="palabras_container" class="editar_oferta_item">
                <label for="palabras">Palabras Clave</label>
                <div id="palabras-list" class="edit-list">
                    @foreach ($oferta->palabrasClave as $palabra)
                    <div class="global_item palabra-item" data-id="{{ $palabra->id }}">
                        <input type="text" name="palabras[{{ $palabra->id }}]" value="{{ $palabra->palabra }}">
                        <button type="button" class="editar_eliminar eliminar-palabra" data-id="{{ $palabra->id }}">
                            x
                        </button>
                    </div>
                    @endforeach
                </div>
                <button class="editar_agregar" type="button" id="agregar-palabra">
                    <i class="ri-add-line"></i> Agregar palabra clave
                </button>
            </div>


            <div id="preguntas_container" class="editar_oferta_item">
                <label for="preguntas">Preguntas</label>
                <div id="preguntas-list" class="edit-list">
                    @foreach ($oferta->preguntas as $pregunta)
                    <div class="global_item pregunta-item" data-id="{{ $pregunta->id }}">
                        <input type="text" name="preguntas[{{ $pregunta->id }}]" value="{{ $pregunta->pregunta }}">
                        <button type="button" class="editar_eliminar eliminar-pregunta" data-id="{{ $pregunta->id }}">
                            x
                        </button>
                    </div>
                    @endforeach
                </div>
                <button class="editar_agregar" type="button" id="agregar-pregunta">
                    <i class="ri-add-line"></i> Agregar pregunta
                </button>
            </div>




            <div class="editar_oferta_item">
                <label for="idiomas">Idiomas</label>
                <div class="editar_oferta_item_checkboxes">
                    @foreach ($idiomasDisponibles as $idioma)
                    <div class="editar_oferta_item_checkbox">
                        <input
                            type="checkbox"
                            name="idiomas[]"
                            id="idioma_{{ $idioma->id }}"
                            value="{{ $idioma->id }}"
                            {{ in_array($idioma->id, $idiomasSeleccionados) ? 'checked' : '' }}>
                        <label for="idioma_{{ $idioma->id }}">{{ $idioma->nombre_idioma }}</label>
                    </div>
                    @endforeach
                </div>
            </div>



            <div class="editar_oferta_item">
                <label for="habilidades_blandas">Habilidades Blandas</label>
                <div class="editar_oferta_item_checkboxes">
                    @foreach ($habilidadesBlandas as $habilidad)
                    <div class="editar_oferta_item_checkbox">
                        <input
                            type="checkbox"
                            name="habilidades_blandas[]"
                            id="habilidad_{{ $habilidad->id }}"
                            value="{{ $habilidad->id }}"
                            {{ in_array($habilidad->id, $habilidadesSeleccionadas) ? 'checked' : '' }}>
                        <label for="habilidad_{{ $habilidad->id }}">{{ $habilidad->descripcion }}</label>
                    </div>
                    @endforeach
                </div>
            </div>










            <div class="editar_oferta_boton_container boton_derecha">
                <button type="submit">Guardar Cambios</button>
            </div>




        </div>



    </form>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const requisitosContainer = document.getElementById("requisitos-list");
        const btnAgregar = document.getElementById("agregar-requisito");

        // Agregar nuevo input dinámico
        btnAgregar.addEventListener("click", function() {
            const div = document.createElement("div");
            div.classList.add("global_item");
            div.innerHTML = `
                        <input type="text" name="requisitos_nuevos[]" placeholder="Nuevo requisito">
                        <button type="button" class="editar_eliminar eliminar-requisito">
                            x
                        </button>
                    `;
            requisitosContainer.appendChild(div);
        });

        // Eliminar requisito (existente o nuevo)
        requisitosContainer.addEventListener("click", function(e) {
            if (e.target.classList.contains("eliminar-requisito")) {
                const button = e.target;
                const item = button.closest(".global_item");
                const id = button.dataset.id;

                if (id) {
                    // Si tiene id, eliminar en backend
                    fetch(`/requisito/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                item.remove();
                            } else {
                                alert("Error al eliminar");
                            }
                        });
                } else {
                    // Si no tiene id, solo eliminar del DOM
                    item.remove();
                }
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const beneficiosContainer = document.getElementById("beneficios-list");
        const btnAgregarBeneficio = document.getElementById("agregar-beneficio");

        btnAgregarBeneficio.addEventListener("click", function() {
            const div = document.createElement("div");
            div.classList.add("global_item");
            div.innerHTML = `
                        <input type="text" name="beneficios_nuevos[]" placeholder="Nuevo beneficio">
                        <button type="button" class="editar_eliminar eliminar-beneficio">
                            x
                        </button>
                    `;
            beneficiosContainer.appendChild(div);
        });

        beneficiosContainer.addEventListener("click", function(e) {
            if (e.target.classList.contains("eliminar-beneficio")) {
                const button = e.target;
                const item = button.closest(".global_item");
                const id = button.dataset.id;

                if (id) {
                    // Si tiene id, eliminar en backend
                    fetch(`/admin/beneficio/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(res => res.json()).then(data => {
                        if (data.success) {
                            item.remove();
                        } else {
                            alert("Error al eliminar");
                        }
                    });
                } else {
                    // Si no tiene id, solo eliminar del DOM
                    item.remove();
                }
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const palabrasContainer = document.getElementById("palabras-list");
        const btnAgregarPalabra = document.getElementById("agregar-palabra");

        btnAgregarPalabra.addEventListener("click", function() {
            const div = document.createElement("div");
            div.classList.add("global_item");
            div.innerHTML = `
                        <input type="text" name="palabras_nuevas[]" placeholder="Nueva palabra clave">
                        <button type="button" class="editar_eliminar eliminar-palabra">
                            x
                        </button>
                    `;
            palabrasContainer.appendChild(div);
        });

        palabrasContainer.addEventListener("click", function(e) {
            if (e.target.classList.contains("eliminar-palabra")) {
                const button = e.target;
                const item = button.closest(".global_item");
                const id = button.dataset.id;

                if (id) {
                    // Si tiene id, eliminar en backend
                    fetch(`/admin/palabra/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(res => res.json()).then(data => {
                        if (data.success) {
                            item.remove();
                        } else {
                            alert("Error al eliminar");
                        }
                    });
                } else {
                    // Si no tiene id, solo eliminar del DOM
                    item.remove();
                }
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const preguntasContainer = document.getElementById("preguntas-list");
        const btnAgregarPregunta = document.getElementById("agregar-pregunta");

        // Agregar nueva pregunta
        btnAgregarPregunta.addEventListener("click", function() {
            const div = document.createElement("div");
            div.classList.add("global_item", "pregunta-item");
            div.innerHTML = `
                            <input type="text" name="preguntas_nuevas[]" placeholder="Nueva pregunta">
                            <button type="button" class="editar_eliminar eliminar-pregunta">
                                x
                            </button>
                        `;
            preguntasContainer.appendChild(div);
        });

        // Eliminar pregunta (ya existente o nueva)
        preguntasContainer.addEventListener("click", function(e) {
            if (e.target.classList.contains("eliminar-pregunta")) {
                const button = e.target;
                const item = button.closest(".pregunta-item");
                const id = button.dataset.id; // Si es pregunta existente

                if (id) {
                    // Si tiene id, eliminar en backend
                    fetch(`/admin/pregunta/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                item.remove();
                            } else {
                                alert("Error al eliminar la pregunta");
                            }
                        })
                        .catch(() => alert("Error al conectar con el servidor"));
                } else {
                    // Si no tiene id, solo eliminar del DOM
                    item.remove();
                }
            }
        });
    });
</script>
@endsection