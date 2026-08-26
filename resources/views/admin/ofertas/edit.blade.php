<!-- // Vista de edición de oferta que permite modificar todos los campos de la oferta, agregar/eliminar dinámicamente requisitos, beneficios, palabras clave y preguntas, seleccionar idiomas y habilidades blandas, y actualizar la imagen, con validaciones y eliminación vía AJAX. -->



@extends('layouts.dashboard_layout')

@section('content')
<div class="editar_oferta_container">

    <div class="editar_oferta_boton_container">
        <button onclick="window.location.href='/bolsadetrabajo/ofertas'"><i class="ri-arrow-left-line"></i>Volver a
            ofertas</button>

    </div>

    

    <form action="{{ route('bolsadetrabajo.ofertas.update', $oferta->id) }}" method="POST"
        enctype="multipart/form-data">
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
                <input type="file" name="nueva_imagen" id="nueva_imagen" accept="image/*" class="@error('nueva_imagen') input-error @enderror">
                @error('nueva_imagen')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>


            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" value="{{ $oferta->titulo }}" class="@error('titulo') input-error @enderror">
                    @error('titulo')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror
                </div>

                <div class="editar_oferta_item">
                    <label for="empresa">Empresa</label>
                    <input type="text" name="empresa" id="empresa" value="{{ $oferta->empresa }}" class="@error('empresa') input-error @enderror">
                    @error('empresa')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="ubicacion">Ubicación</label>
                    <input type="text" name="ubicacion" id="ubicacion" value="{{ $oferta->ubicacion }}" class="@error('ubicacion') input-error @enderror">
                    @error('ubicacion')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror
                </div>

                <div class="editar_oferta_item">
                    <label for="carerra">Carrera</label>
                    <select name="carrera_id"  class="@error('carrera_id') input-error @enderror">
                        @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ $oferta->carrera_id == $carrera->id ? 'selected' : '' }}>
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
                <textarea name="descripcion" id="descripcion"  class="@error('descripcion') input-error @enderror">{{ $oferta->descripcion }}</textarea>
                @error('descripcion')
                <div class="error-mensaje">{{ $message }}</div>
                @enderror
            </div>

            <div class="editar_oferta_grupo">
                <div class="editar_oferta_item">
                    <label for="salario">Salario</label>
                    <input type="text" name="salario" id="salario"
                        value="{{ number_format($oferta->salario, 0, '', '.') }}" 
                        oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                        placeholder="Salario en pesos" class="@error('salario') input-error @enderror">
                    @error('salario')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror
                </div>

                <div class="editar_oferta_item">
                    <label for="horarios">Horarios</label>
                    <select name="horario_id" class="@error('horario_id') input-error @enderror">
                        @foreach($horarios as $horario)
                        <option value="{{ $horario->id }}" {{ $oferta->horario->id == $horario->id ? 'selected' : '' }}>
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
                        <option value="{{ $modalidad->id }}" {{ $oferta->modalidad->id == $modalidad->id ? 'selected' : '' }}>
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
                    <input type="text" name="años_experiencia" value="{{ $oferta->años_experiencia }}" 
                        placeholder="Años de experiencia" min="0" step="1" class="@error('años_experiencia') input-error @enderror">
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
                        <option value="{{ $estado->id }}" {{ $oferta->estado_id === $estado->id ? 'selected' : '' }}>
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
                    <input type="date" name="fecha_expiracion" id="fecha_expiracion"
                        value="{{ $oferta->fecha_expiracion ? \Carbon\Carbon::parse($oferta->fecha_expiracion)->format('Y-m-d') : '' }}"
                         min="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}"
                         class="@error('fecha_expiracion') input-error @enderror">
                    @error('fecha_expiracion')
                    <div class="error-mensaje">{{ $message }}</div>
                    @enderror


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
                <label for="palabras">Habilidades técnicas</label>
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
                    <i class="ri-add-line"></i> Agregar habilidad técnica
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
                        <input type="checkbox" name="idiomas[]" id="idioma_{{ $idioma->id }}" value="{{ $idioma->id }}"
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
                        <input type="checkbox" name="habilidades_blandas[]" id="habilidad_{{ $habilidad->id }}"
                            value="{{ $habilidad->id }}" {{ in_array($habilidad->id, $habilidadesSeleccionadas) ? 'checked' : '' }}>
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
        // helper para eliminar un item por id y endpoint base
        async function eliminarItem(id, endpoint, itemElement) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const res = await fetch(`${endpoint}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                // intenta parsear JSON (si el server devuelve JSON)
                const data = await res.json().catch(() => null);

                if (res.ok && data && data.success) {
                    itemElement.remove();
                } else {
                    // mostrar mensaje útil según status
                    if (res.status === 419) {
                        alert("Error CSRF: recarga la página e intenta otra vez.");
                    } else if (res.status === 401 || res.status === 302) {
                        alert("No autorizado: inicia sesión o revisa permisos.");
                    } else {
                        alert("Error al eliminar. Revisa la consola / network para más detalles.");
                    }
                    console.error("Respuesta:", res.status, data);
                }
            } catch (err) {
                console.error(err);
                alert("Error al conectar con el servidor.");
            }
        }

        // delegación de eventos para los 4 contenedores
        const mapas = [{
                containerId: 'requisitos-list',
                selector: '.eliminar-requisito',
                endpoint: '/bolsadetrabajo/requisito'
            },
            {
                containerId: 'beneficios-list',
                selector: '.eliminar-beneficio',
                endpoint: '/bolsadetrabajo/beneficio'
            },
            {
                containerId: 'palabras-list',
                selector: '.eliminar-palabra',
                endpoint: '/bolsadetrabajo/palabra'
            },
            {
                containerId: 'preguntas-list',
                selector: '.eliminar-pregunta',
                endpoint: '/bolsadetrabajo/pregunta'
            }
        ];

        mapas.forEach(m => {
            const container = document.getElementById(m.containerId);
            if (!container) return;

            container.addEventListener('click', function(e) {
                // sube hasta el botón en caso de que el click sea en un icono o hijo
                const button = e.target.closest(m.selector);
                if (!button) return;

                const item = button.closest('.global_item') || button.closest('.pregunta-item');
                const id = button.dataset.id;

                if (!item) return;

                if (id) {
                    eliminarItem(id, m.endpoint, item);
                } else {
                    // item creado en el DOM, sin id: solo remover
                    item.remove();
                }
            });
        });

        // --- Mantén tus handlers de "agregar" (solo creamos inputs nuevos) ---
        // Requisitos
        const btnAgregar = document.getElementById("agregar-requisito");
        if (btnAgregar) btnAgregar.addEventListener("click", function() {
            const container = document.getElementById("requisitos-list");
            const div = document.createElement("div");
            div.classList.add("global_item", "requisito-item");
            div.innerHTML = `
            <input type="text" name="requisitos_nuevos[]" placeholder="Nuevo requisito">
            <button type="button" class="editar_eliminar eliminar-requisito">x</button>
        `;
            container.appendChild(div);
        });

        // Beneficios
        const btnAgregarBeneficio = document.getElementById("agregar-beneficio");
        if (btnAgregarBeneficio) btnAgregarBeneficio.addEventListener("click", function() {
            const container = document.getElementById("beneficios-list");
            const div = document.createElement("div");
            div.classList.add("global_item", "beneficio-item");
            div.innerHTML = `
            <input type="text" name="beneficios_nuevos[]" placeholder="Nuevo beneficio">
            <button type="button" class="editar_eliminar eliminar-beneficio">x</button>
        `;
            container.appendChild(div);
        });

        // Palabras
        const btnAgregarPalabra = document.getElementById("agregar-palabra");
        if (btnAgregarPalabra) btnAgregarPalabra.addEventListener("click", function() {
            const container = document.getElementById("palabras-list");
            const div = document.createElement("div");
            div.classList.add("global_item", "palabra-item");
            div.innerHTML = `
            <input type="text" name="palabras_nuevas[]" placeholder="Nueva palabra clave">
            <button type="button" class="editar_eliminar eliminar-palabra">x</button>
        `;
            container.appendChild(div);
        });

        // Preguntas
        const btnAgregarPregunta = document.getElementById("agregar-pregunta");
        if (btnAgregarPregunta) btnAgregarPregunta.addEventListener("click", function() {
            const container = document.getElementById("preguntas-list");
            const div = document.createElement("div");
            div.classList.add("global_item", "pregunta-item");
            div.innerHTML = `
            <input type="text" name="preguntas_nuevas[]" placeholder="Nueva pregunta">
            <button type="button" class="editar_eliminar eliminar-pregunta">x</button>
        `;
            container.appendChild(div);
        });

    });
</script>

@endsection