<!-- // Vista para crear una nueva oferta de trabajo que permite completar todos los campos, agregar/eliminar dinámicamente requisitos, beneficios, palabras clave y preguntas, seleccionar idiomas y habilidades blandas, subir una imagen, y manejar eliminaciones vía AJAX. -->


@extends('layouts.dashboard_layout')

@section('content')
<div class="editar_oferta_container">
    <div class="editar_oferta_boton_container">
        <button onclick="window.location.href='/bolsadetrabajo/ofertas'"><i class="ri-arrow-left-line"></i>Volver a ofertas</button>

    </div>

    

    <form action="{{ route('bolsadetrabajo.admin.ofertas.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf


        <div class="editar_oferta_titulo">
            <h3>Crear oferta</h3>
            <p>Completa la información de la nueva oferta de trabajo.</p>
        </div>

        <div class="editar_oferta_formulario">

            <div class="editar_oferta_item">
                <label for="imagen">Imagen:</label><br>
                <input type="file" name="imagen" id="imagen" accept="image/png, image/jpeg" class="@error('imagen') input-error @enderror">
                @error('imagen')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror

            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" class="@error('titulo') input-error @enderror">
                    @error('titulo')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror
                </div>
                

                <div class="editar_oferta_item">
                    <label for="empresa">Empresa</label>
                    <input type="text" name="empresa" id="empresa" value="{{ old('empresa') }}" class="@error('empresa') input-error @enderror">
                    @error('empresa')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="ubicacion">Ubicación</label>
                    <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion') }}"  class="@error('ubicacion') input-error @enderror">
                    @error('ubicacion')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror
                </div>

                <div class="editar_oferta_item">
                    <label for="carrera_id">Carrera</label>
                    <select id="carrera_id" name="carrera_id" class="@error('carrera_id') input-error @enderror">
                        @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ old('carrera_id') == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->descripcion }}
                        </option>
                        @endforeach
                    </select>
                @error('carrera_id')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
                </div>
            </div>

            <div class="editar_oferta_item">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="@error('descripcion') input-error @enderror">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="salario">Salario</label>
                    <input
                        type="text"
                        name="salario"
                        id="salario"
                        value="{{ old('salario') }}"
                        class="@error('salario') input-error @enderror"
                        oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
                    @error('salario')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror
                </div>

                <div class="editar_oferta_item">
                    <label for="horarios">Horarios</label>
                    <select name="horario_id" class="@error('horario_id') input-error @enderror">
                        @foreach($horarios as $horario)
                        <option value="{{ $horario->id }}" {{ old('horario_id') == $horario->id ? 'selected' : '' }}>
                            {{ $horario->tipo }}
                        </option>
                        @endforeach
                    </select>
                    @error('horario_id')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="modalidad">Modalidad</label>
                    <select name="modalidad_id" class="@error('modalidad_id') input-error @enderror">
                        @foreach($modalidades as $modalidad)
                        <option value="{{ $modalidad->id }}" {{ old('modalidad_id') == $modalidad->id ? 'selected' : '' }}>
                            {{ $modalidad->tipo }}
                        </option>
                        @endforeach
                    </select>
                @error('modalidad_id')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
                </div>

                <div class="editar_oferta_item">
                    <label for="experiencia">Experiencia</label>
                    <input type="number" name="años_experiencia" value="{{ old('años_experiencia') }}"  placeholder="Años de experiencia" min="0" step="1" class="@error('años_experiencia') input-error @enderror">
                    @error('años_experiencia')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="estado">Estado</label>
                    <select name="estado_id" class="@error('estado_id') input-error @enderror">
                        @foreach($estados as $estado)
                        <option value="{{ $estado->id }}"
                            {{ old('estado_id') == $estado->id ? 'selected' : '' }}>
                            {{ $estado->tipo }}
                        </option>
                        @endforeach
                    </select>
                @error('estado_id')
                <div class="error-mensaje">{{ $message }}</div> 
                @enderror
                </div>

                <div class="editar_oferta_item">
                    <label for="fecha_expiracion">Fecha de Expiración</label>
                    <input
                        type="date"
                        name="fecha_expiracion"
                        id="fecha_expiracion"
                        min="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}"
                        value="{{ old('fecha_expiracion') ? \Carbon\Carbon::parse(old('fecha_expiracion'))->format('Y-m-d') : '' }}"
                        class="@error('fecha_expiracion') input-error @enderror"
                        >
                    @error('fecha_expiracion')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror


                </div>
            </div>

            <div id="requisitos_container" class="editar_oferta_item">
                <label for="requisitos">Requisitos</label>
                <div id="requisitos-list" class="edit-list">
                    @if(old('requisitos'))
                    @foreach (old('requisitos') as $key => $requisito)
                    <div class="global_item requisito-item" data-id="{{ $key }}">
                        <input type="text" name="requisitos[]" value="{{ $requisito }}">
                        <button type="button" class="editar_eliminar eliminar-requisito">
                            x
                        </button>
                    </div>
                    @endforeach
                    @else
                    <div class="global_item requisito-item">
                        <input type="text" name="requisitos[]" value="">
                        <button type="button" class="editar_eliminar eliminar-requisito">
                            x
                        </button>
                    </div>
                    @endif
                </div>
                <button class="editar_agregar" type="button" id="agregar-requisito">
                    <i class="ri-add-line"></i> Agregar requisito
                </button>
            </div>

            <div id="beneficios_container" class="editar_oferta_item">
                <label for="beneficios">Beneficios</label>
                <div id="beneficios-list" class="edit-list">
                    @if(old('beneficios'))
                    @foreach (old('beneficios') as $key => $beneficio)
                    <div class="global_item beneficio-item" data-id="{{ $key }}">
                        <input type="text" name="beneficios[]" value="{{ $beneficio }}">
                        <button type="button" class="editar_eliminar eliminar-beneficio">
                            x
                        </button>
                    </div>
                    @endforeach
                    @else
                    <div class="global_item beneficio-item">
                        <input type="text" name="beneficios[]" value="">
                        <button type="button" class="editar_eliminar eliminar-beneficio">
                            x
                        </button>
                    </div>
                    @endif
                </div>
                <button class="editar_agregar" type="button" id="agregar-beneficio">
                    <i class="ri-add-line"></i> Agregar beneficio
                </button>
            </div>

            <div id="palabras_container" class="editar_oferta_item">
                <label for="palabras">Habilidades técnicas</label>
                <div id="palabras-list" class="edit-list">
                    @if(old('palabras'))
                    @foreach (old('palabras') as $key => $palabra)
                    <div class="global_item palabra-item" data-id="{{ $key }}">
                        <input type="text" name="palabras[]" value="{{ $palabra }}">
                        <button type="button" class="editar_eliminar eliminar-palabra">
                            x
                        </button>
                    </div>
                    @endforeach
                    @else
                    <div class="global_item palabra-item">
                        <input type="text" name="palabras[]" value="">
                        <button type="button" class="editar_eliminar eliminar-palabra">
                            x
                        </button>
                    </div>
                    @endif
                </div>
                <button class="editar_agregar" type="button" id="agregar-palabra">
                    <i class="ri-add-line"></i> Agregar habilidad técnica
                </button>
            </div>

            <div id="preguntas_container" class="editar_oferta_item">
                <label for="preguntas">Preguntas</label>
                <div id="preguntas-list" class="edit-list">
                    @if(old('preguntas'))
                    @foreach (old('preguntas') as $key => $pregunta)
                    <div class="global_item pregunta-item" data-id="{{ $key }}">
                        <input type="text" name="preguntas[]" value="{{ $pregunta }}">
                        <button type="button" class="editar_eliminar eliminar-pregunta">
                            x
                        </button>
                    </div>
                    @endforeach
                    @else
                    <div class="global_item pregunta-item">
                        <input type="text" name="preguntas[]" value="">
                        <button type="button" class="editar_eliminar eliminar-pregunta">
                            x
                        </button>
                    </div>
                    @endif
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
            <input type="text" name="preguntas[]" placeholder="Nueva pregunta">
            <button type="button" class="editar_eliminar eliminar-pregunta">
                x
            </button>
        `;
            preguntasContainer.appendChild(div);
        });

        // Eliminar pregunta (existente o nueva)
        preguntasContainer.addEventListener("click", function(e) {
            if (e.target.classList.contains("eliminar-pregunta")) {
                const button = e.target;
                const item = button.closest(".pregunta-item");
                const id = button.dataset.id; // Para preguntas existentes con ID

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