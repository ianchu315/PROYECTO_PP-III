<!-- // Permite administrar la configuración del sistema agregando, editando y eliminando dinámicamente carreras, idiomas, habilidades blandas, modalidades y horarios, con soporte para guardar cambios y eliminar elementos existentes mediante AJAX.
 -->


@extends('layouts.dashboard_layout')

@section('content')
<section class="configuracion_container">

    <div class="configuracion_titulo">
        <h1>Configuración del sistema</h1>
    </div>


    <form action="{{ route('bolsadetrabajo.configuracion.store') }}" method="POST">
        @csrf





        <div id="idiomas_container" class="editar_oferta_item">
            <label for="idiomas">Idiomas</label>
            <div id="idiomas-list" class="edit-list">
                @if(old('idiomas'))
                @foreach(old('idiomas') as $id => $idioma)
                <div class="global_item idioma-item" data-id="{{ $id }}">
                    <input type="text" name="idiomas[{{ $id }}]" value="{{ $idioma }}">
                    <button type="button" class="editar_eliminar eliminar-idioma">x</button>
                </div>
                @endforeach
                @elseif(isset($idiomas))
                @foreach($idiomas as $idioma)
                <div class="global_item idioma-item" data-id="{{ $idioma->id }}">
                    <input type="text" name="idiomas[{{ $idioma->id }}]" value="{{ $idioma->nombre_idioma }}">
                    <button type="button" class="editar_eliminar eliminar-idioma" data-id="{{ $idioma->id }}">x</button>
                </div>
                @endforeach
                @endif
            </div>
            <button type="button" class="editar_agregar" data-target="idiomas-list">Agregar idioma</button>
        </div>




        <div id="habilidades_container" class="editar_oferta_item">
            <label for="habilidades">Habilidades blandas</label>
            <div id="habilidades-list" class="edit-list">
                @if(old('habilidades'))
                @foreach(old('habilidades') as $id => $habilidad)
                <div class="global_item habilidad-item" data-id="{{ $id }}">
                    <input type="text" name="habilidades[{{ $id }}]" value="{{ $habilidad }}">
                    <button type="button" class="editar_eliminar eliminar-habilidad">x</button>
                </div>
                @endforeach
                @elseif(isset($habilidades))
                @foreach($habilidades as $habilidad)
                <div class="global_item habilidad-item" data-id="{{ $habilidad->id }}">
                    <input type="text" name="habilidades[{{ $habilidad->id }}]" value="{{ $habilidad->descripcion }}">
                    <button type="button" class="editar_eliminar eliminar-habilidad" data-id="{{ $habilidad->id }}">x</button>
                </div>
                @endforeach
                @endif
            </div>
            <button type="button" class="editar_agregar" data-target="habilidades-list">Agregar habilidad</button>
        </div>



        <div id="modalidades_container" class="editar_oferta_item">
            <label for="modalidades">Modalidades</label>
            <div id="modalidades-list" class="edit-list">
                @if(old('modalidades'))
                @foreach(old('modalidades') as $id => $modalidad)
                <div class="global_item modalidad-item" data-id="{{ $id }}">
                    <input type="text" name="modalidades[{{ $id }}]" value="{{ $modalidad }}">
                    <button type="button" class="editar_eliminar eliminar-modalidad">x</button>
                </div>
                @endforeach
                @elseif(isset($modalidades))
                @foreach($modalidades as $modalidad)
                <div class="global_item modalidad-item" data-id="{{ $modalidad->id }}">
                    <input type="text" name="modalidades[{{ $modalidad->id }}]" value="{{ $modalidad->tipo }}">
                    <button type="button" class="editar_eliminar eliminar-modalidad" data-id="{{ $modalidad->id }}">x</button>
                </div>
                @endforeach
                @endif
            </div>
            <button type="button" class="editar_agregar" data-target="modalidades-list">Agregar modalidad</button>
        </div>



        <div id="horarios_container" class="editar_oferta_item">
            <label for="horarios">Horarios</label>
            <div id="horarios-list" class="edit-list">
                @if(old('horarios'))
                @foreach(old('horarios') as $id => $horario)
                <div class="global_item horario-item" data-id="{{ $id }}">
                    <input type="text" name="horarios[{{ $id }}]" value="{{ $horario }}">
                    <button type="button" class="editar_eliminar eliminar-horario">x</button>
                </div>
                @endforeach
                @elseif(isset($horarios))
                @foreach($horarios as $horario)
                <div class="global_item horario-item" data-id="{{ $horario->id }}">
                    <input type="text" name="horarios[{{ $horario->id }}]" value="{{ $horario->tipo }}">
                    <button type="button" class="editar_eliminar eliminar-horario" data-id="{{ $horario->id }}">x</button>
                </div>
                @endforeach
                @endif
            </div>
            <button type="button" class="editar_agregar" data-target="horarios-list">Agregar horario</button>
        </div>



        <button class="configuracion_guardar" type="submit">Actualizar configuración</button>
    </form>





    <script>
        document.addEventListener("DOMContentLoaded", function() {


            document.querySelectorAll('.editar_agregar').forEach(btn => {
                btn.addEventListener('click', function() {
                    const targetId = btn.dataset.target;
                    const container = document.getElementById(targetId);

                    const div = document.createElement("div");
                    div.classList.add("global_item");

                    if (targetId === "carreras-list") {
                        div.classList.add("carrera-item");
                        div.dataset.id = "";
                        div.innerHTML = `
                    <input type="text" name="carreras_nuevos[]" placeholder="Nueva carrera">
                    <button type="button" class="editar_eliminar eliminar-carrera">x</button>
                `;
                    } else if (targetId === "idiomas-list") {
                        div.classList.add("idioma-item");
                        div.dataset.id = "";
                        div.innerHTML = `
                    <input type="text" name="idiomas_nuevos[]" placeholder="Nuevo idioma">
                    <button type="button" class="editar_eliminar eliminar-idioma">x</button>
                `;
                    } else if (targetId === "habilidades-list") {
                        div.classList.add("habilidad-item");
                        div.dataset.id = "";
                        div.innerHTML = `
                    <input type="text" name="habilidades_nuevos[]" placeholder="Nueva habilidad">
                    <button type="button" class="editar_eliminar eliminar-habilidad">x</button>
                `;
                    } else if (targetId === "modalidades-list") {
                        div.classList.add("modalidad-item");
                        div.dataset.id = "";
                        div.innerHTML = `
                    <input type="text" name="modalidades_nuevos[]" placeholder="Nueva modalidad">
                    <button type="button" class="editar_eliminar eliminar-modalidad">x</button>
                `;
                    } else if (targetId === "horarios-list") {
                        div.classList.add("horario-item");
                        div.dataset.id = "";
                        div.innerHTML = `
                    <input type="text" name="horarios_nuevos[]" placeholder="Nuevo horario">
                    <button type="button" class="editar_eliminar eliminar-horario">x</button>
                `;
                    }



                    container.appendChild(div);
                });
            });


            document.addEventListener('click', function(e) {
                if (
                    e.target.classList.contains('eliminar-carrera') ||
                    e.target.classList.contains('eliminar-idioma') ||
                    e.target.classList.contains('eliminar-habilidad') ||
                    e.target.classList.contains('eliminar-modalidad') ||
                    e.target.classList.contains('eliminar-horario')
                ) {
                    const item = e.target.closest('.global_item');
                    const id = item.dataset.id;
                    let tipo = e.target.classList.contains('eliminar-carrera') ? 'carrera' :
                        e.target.classList.contains('eliminar-idioma') ? 'idioma' :
                        e.target.classList.contains('eliminar-habilidad') ? 'habilidad' :
                        e.target.classList.contains('eliminar-modalidad') ? 'modalidad' :
                        'horario';


                    if (!confirm(`¿Estás seguro de eliminar esta ${tipo}?`)) {
                        return;
                    }

                    if (id) {
                        fetch(`/bolsadetrabajo/configuracion/${tipo}/${id}`, {
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
                                    alert(data.message || "Error al eliminar " + tipo);
                                }
                            })

                            .catch(err => alert("Error de conexión"));
                    } else {
                        item.remove();
                    }
                }


            });

        });
    </script>

</section>
@endsection