@extends(Auth::guard('usuarios')->user()->rol === 'superadministrador' ? 'layouts.panel' : 'layouts.app2')

@section('titulo', Auth::guard('usuarios')->user()->rol === 'superadministrador' ? 'Materias' : 'Notas de materia')

@section('content')
<div class="pf-page" id="notas-profesor" data-materia-id="{{ $materia->id }}">

    <div class="pf-page-header">
        <h1>{{ $materia->descripcion }}</h1>
        <a href="{{ route('bolsadetrabajo.profesor.materias.index') }}" class="btn btn-secondary">Volver a mis materias</a>
    </div>

    @if(session('success'))
        <div class="pf-card" style="border-color:#2e7d32; background:#eaf6ec;">
            <p class="mb-0">{{ session('success') }}</p>
        </div>
    @endif

    <section class="pf-card curso-contenido-docente">
        <div class="curso-contenido-cabecera">
            <div>
                <h3>Unidades y materiales</h3>
                <p class="pf-muted mb-0">Publicá el contenido del curso y archivos para tus alumnos.</p>
            </div>
            <span class="curso-unidades-total">{{ $unidades->count() }} unidades</span>
        </div>

        <form method="POST" action="{{ route('bolsadetrabajo.profesor.materias.unidades.crear', $materia) }}" enctype="multipart/form-data" class="curso-unidad-form">
            @csrf
            <div class="curso-unidad-campos">
                <label>
                    <span>Nombre de la unidad</span>
                    <input type="text" name="titulo" maxlength="160" required placeholder="Ej.: Unidad 1 · Introducción">
                </label>
                <label>
                    <span>Descripción (opcional)</span>
                    <textarea name="descripcion" rows="2" maxlength="2000" placeholder="Temas y objetivos de la unidad"></textarea>
                </label>
                <label>
                    <span>Archivos (hasta 10, 20 MB cada uno)</span>
                    <input type="file" name="archivos[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.rtf,.odt,.ods,.odp,.zip,.jpg,.jpeg,.png">
                </label>
            </div>
            <button type="submit" class="btn btn-primary"><i class="ri-add-line" aria-hidden="true"></i> Publicar unidad</button>
            @error('titulo') <p class="curso-error">{{ $message }}</p> @enderror
            @error('archivos.*') <p class="curso-error">{{ $message }}</p> @enderror
        </form>

        @if($unidades->isEmpty())
            <p class="pf-muted mb-0">Todavía no publicaste unidades.</p>
        @else
            <div class="curso-unidades-docente">
                @foreach($unidades as $unidad)
                    <details class="curso-unidad-docente">
                        <summary>
                            <span class="curso-unidad-orden">{{ str_pad($unidad->orden, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="curso-unidad-nombre">
                                <strong>{{ $unidad->titulo }}</strong>
                                <small>{{ $unidad->recursos->count() }} {{ $unidad->recursos->count() === 1 ? 'archivo' : 'archivos' }}</small>
                            </span>
                            <i class="ri-arrow-down-s-line" aria-hidden="true"></i>
                        </summary>
                        <div class="curso-unidad-detalle">
                            @if($unidad->descripcion)
                                <p class="curso-unidad-descripcion">{{ $unidad->descripcion }}</p>
                            @endif
                            @if($unidad->recursos->isEmpty())
                                <p class="pf-muted">Esta unidad todavía no tiene archivos.</p>
                            @else
                                <ul class="curso-archivos-docente">
                                    @foreach($unidad->recursos as $recurso)
                                        <li>
                                            <a href="{{ route('bolsadetrabajo.materias.recursos.descargar', [$materia, $recurso]) }}">
                                                <i class="ri-file-text-line" aria-hidden="true"></i>
                                                {{ $recurso->nombre_original }}
                                            </a>
                                            <form method="POST" action="{{ route('bolsadetrabajo.profesor.materias.recursos.eliminar', [$materia, $unidad, $recurso]) }}" onsubmit="return confirm('¿Eliminar este archivo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="curso-boton-icono" aria-label="Eliminar archivo" title="Eliminar archivo"><i class="ri-delete-bin-line" aria-hidden="true"></i></button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <form method="POST" action="{{ route('bolsadetrabajo.profesor.materias.unidades.recursos.agregar', [$materia, $unidad]) }}" enctype="multipart/form-data" class="curso-agregar-archivos">
                                @csrf
                                <label for="archivos-unidad-{{ $unidad->id }}">Agregar archivos</label>
                                <input id="archivos-unidad-{{ $unidad->id }}" type="file" name="archivos[]" multiple required accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.rtf,.odt,.ods,.odp,.zip,.jpg,.jpeg,.png">
                                <button type="submit" class="btn btn-secondary btn-sm">Subir archivos</button>
                            </form>
                            <form method="POST" action="{{ route('bolsadetrabajo.profesor.materias.unidades.eliminar', [$materia, $unidad]) }}" onsubmit="return confirm('¿Eliminar esta unidad y todos sus archivos?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar unidad</button>
                            </form>
                        </div>
                    </details>
                @endforeach
            </div>
        @endif
    </section>

    {{-- 1. Agregar alumnos registrados --}}
    <div class="pf-card">
        <h3>Agregar alumno a la materia</h3>
        <form method="POST" action="{{ route('bolsadetrabajo.profesor.materias.agregarAlumno', $materia) }}" class="pf-form-inline" id="form-agregar-alumno">
            @csrf
            @include('partials.filtro_rapido', ['target' => '#select-alumno', 'placeholder' => 'Escribí para filtrar la lista de alumnos...'])
            <select name="usuario_id" id="select-alumno">
                <option value="">-- Seleccioná un alumno registrado --</option>
                @foreach($alumnosDisponibles as $alumno)
                    <option value="{{ $alumno->id }}">{{ $alumno->email }} ({{ $alumno->nombre }} {{ $alumno->apellido }})</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary" id="btn-agregar-alumno" disabled>Agregar</button>
        </form>
    </div>

    {{-- 2. Listado de alumnos inscriptos + notas --}}
    <div class="pf-card">
        <h3>Alumnos y notas</h3>

        @if($alumnosData->isEmpty())
            <p class="pf-muted mb-0">Todavía no agregaste alumnos a esta materia.</p>
        @else
            @php
                // Solo el profesor a cargo carga notas; admin/superadmin las ven en modo lectura.
                $puedeCargarNotas = Auth::guard('usuarios')->user()->rol === 'profesor';
                $soloLectura = $puedeCargarNotas ? '' : 'readonly';
            @endphp
            <div class="pf-table-wrap">
                @include('partials.filtro_rapido', ['target' => '#tabla-notas', 'celdas' => 1, 'placeholder' => 'Buscar alumno en esta materia...'])
                <table class="pf-table np-tabla-notas" id="tabla-notas">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Primer Cuatrimestre</th>
                            <th>Segundo Cuatrimestre</th>
                            <th>Promediada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumnosData as $fila)
                            @php
                                $alumno = $fila['usuario'];
                                $notas = $fila['notas'];
                                $notaPromediada = $fila['notaPromediada'];
                                $notaPrimerCuatrimestre = $notas->first(fn($n) => $n->cuatrimestre == 1 && $n->numero_nota == 1);
                                $notaSegundoCuatrimestre = $notas->first(fn($n) => $n->cuatrimestre == 2 && $n->numero_nota == 1);
                                $promediadaCalculada = $notaPrimerCuatrimestre?->nota !== null && $notaSegundoCuatrimestre?->nota !== null
                                    ? round(($notaPrimerCuatrimestre->nota + $notaSegundoCuatrimestre->nota) / 2, 2)
                                    : null;
                            @endphp
                            <tr data-usuario-id="{{ $alumno->id }}"
                                data-nombre="{{ $alumno->nombre }}"
                                data-apellido="{{ $alumno->apellido }}">
                                <td>
                                    <a href="#" class="np-ver-alumno" data-usuario-id="{{ $alumno->id }}">
                                        {{ $alumno->apellido }}, {{ $alumno->nombre }}
                                    </a>
                                </td>

                                <td>
                                    <input type="number" class="np-input-nota" min="0" max="10" step="0.5" {{ $soloLectura }}
                                           data-usuario-id="{{ $alumno->id }}"
                                           data-cuatrimestre="1"
                                           data-numero-nota="1"
                                           value="{{ $notaPrimerCuatrimestre?->nota }}">
                                </td>
                                <td>
                                    <input type="number" class="np-input-nota" min="0" max="10" step="0.5" {{ $soloLectura }}
                                           data-usuario-id="{{ $alumno->id }}"
                                           data-cuatrimestre="2"
                                           data-numero-nota="1"
                                           value="{{ $notaSegundoCuatrimestre?->nota }}">
                                </td>
                                <td>
                                    <input type="number" class="np-input-promediada" min="0" max="10" step="0.5" {{ $soloLectura }}
                                           data-usuario-id="{{ $alumno->id }}"
                                           value="{{ $notaPromediada?->nota ?? $promediadaCalculada }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($puedeCargarNotas)
                <div class="np-guardar-notas">
                    <button type="button" class="btn btn-primary" id="np-guardar-notas">Guardar notas</button>
                    <span class="pf-muted" id="np-guardar-estado" role="status"></span>
                </div>
            @else
                <p class="pf-muted" style="margin-top:12px;">Las notas las carga únicamente el profesor a cargo de la materia.</p>
            @endif
        @endif
    </div>
</div>

{{-- 3. Popup de detalle del alumno --}}
<div id="np-modal-overlay" class="np-modal-overlay" style="display:none;">
    <div class="np-modal">
        <button type="button" class="np-modal-close" id="np-modal-close" aria-label="Cerrar">&times;</button>
        <h3 id="np-modal-nombre"></h3>
        <p><strong>Materia:</strong> {{ $materia->descripcion }}</p>
        <div id="np-modal-notas"></div>
    </div>
</div>

{{-- 4. Pop up amistoso al guardar las notas --}}
<div id="np-popup-overlay" class="np-popup-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="np-popup-titulo">
    <div class="np-popup">
        <div class="np-popup-icono" id="np-popup-icono">🎉</div>
        <h3 id="np-popup-titulo"></h3>
        <p id="np-popup-mensaje"></p>
        <button type="button" class="btn btn-primary" id="np-popup-aceptar">¡Genial!</button>
    </div>
</div>

<style>
    .curso-contenido-cabecera,
    .curso-unidad-docente > summary,
    .curso-archivos-docente li {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .curso-contenido-cabecera {
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .curso-contenido-cabecera h3 {
        margin-bottom: 3px;
    }

    .curso-unidades-total {
        color: #700101;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .curso-unidad-campos {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 12px;
    }

    .curso-unidad-campos label {
        display: grid;
        gap: 5px;
        color: #555;
        font-size: 13px;
        font-weight: 600;
    }

    .curso-unidad-campos label:first-child,
    .curso-unidad-campos label:last-child {
        grid-column: 1 / -1;
    }

    .curso-unidad-campos input,
    .curso-unidad-campos textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font: inherit;
        font-weight: 400;
    }

    .curso-unidades-docente {
        display: grid;
        gap: 8px;
        margin-top: 18px;
    }

    .curso-unidad-docente {
        border: 1px solid #eaeae9;
        border-radius: 8px;
        overflow: hidden;
    }

    .curso-unidad-docente > summary {
        padding: 10px 12px;
        cursor: pointer;
        list-style: none;
    }

    .curso-unidad-docente > summary::-webkit-details-marker {
        display: none;
    }

    .curso-unidad-orden {
        display: grid;
        place-items: center;
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        color: #700101;
        background: #f5f3f2;
        border-radius: 7px;
        font-weight: 700;
    }

    .curso-unidad-nombre {
        display: grid;
        gap: 3px;
        min-width: 0;
        flex: 1;
    }

    .curso-unidad-nombre small {
        color: #777;
    }

    .curso-unidad-docente summary > i {
        color: #700101;
        font-size: 19px;
    }

    .curso-unidad-detalle {
        padding: 0 14px 14px 58px;
    }

    .curso-unidad-descripcion {
        color: #555;
        white-space: pre-line;
    }

    .curso-archivos-docente {
        list-style: none;
        padding: 0;
        margin: 8px 0 14px;
    }

    .curso-archivos-docente li {
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0ef;
    }

    .curso-archivos-docente a {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
        color: #700101;
        overflow-wrap: anywhere;
    }

    .curso-agregar-archivos {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin: 12px 0;
        color: #555;
        font-size: 12px;
    }

    .curso-agregar-archivos input {
        max-width: 100%;
        font-size: 12px;
    }

    .curso-boton-icono {
        border: 0;
        background: transparent;
        color: #a52a2a;
        padding: 6px;
        cursor: pointer;
    }

    .curso-error {
        color: #c0392b;
        margin: 8px 0 0;
        font-size: 13px;
    }

    @media (max-width: 650px) {
        .curso-unidad-campos {
            grid-template-columns: minmax(0, 1fr);
        }

        .curso-unidad-campos label {
            grid-column: 1 / -1;
        }

        .curso-unidad-detalle {
            padding-left: 14px;
        }
    }

    .np-card { background:#fff; border:1px solid #e2e2e2; border-radius:8px; padding:20px; margin-bottom:20px; }
    .np-inline-form { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
    .np-inline-form select, .np-inline-form input[type="number"] { padding:6px 10px; border:1px solid #ccc; border-radius:4px; }
    .np-tabla-notas input.np-input-nota, .np-tabla-notas input.np-input-promediada { width:60px; padding:4px; }
    .np-guardar-notas { display:flex; align-items:center; gap:12px; margin-top:16px; }
    .np-badge { padding:4px 10px; border-radius:12px; font-size:13px; font-weight:600; color:#fff; }
    .np-badge-regular { background:#2e7d32; }
    .np-badge-libre { background:#c0392b; }
    .np-ver-alumno { text-decoration:none; color:#700101; font-weight:600; cursor:pointer; }

    .np-modal-overlay {
        position:fixed; inset:0; background:rgba(0,0,0,.5);
        display:flex; align-items:center; justify-content:center; z-index:1050;
    }
    .np-modal {
        background:#fff; border-radius:8px; padding:24px; width:90%; max-width:480px;
        max-height:80vh; overflow-y:auto; position:relative;
    }
    .np-modal-close {
        position:absolute; top:10px; right:14px; background:none; border:none;
        font-size:26px; line-height:1; cursor:pointer; color:#555;
    }
    .np-modal-notas-lista { list-style:none; padding:0; margin:10px 0 0; }
    .np-modal-notas-lista li { padding:4px 0; border-bottom:1px solid #f0f0f0; }

    /* Pop up amistoso de "notas cargadas" */
    .np-popup-overlay {
        position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:1100;
        align-items:center; justify-content:center;
    }
    .np-popup {
        background:#fff; border-radius:16px; padding:28px 30px; width:92%; max-width:380px;
        text-align:center; box-shadow:0 10px 30px rgba(0,0,0,.25);
        animation:np-popup-in .22s ease-out;
    }
    .np-popup-icono { font-size:46px; line-height:1; margin-bottom:8px; }
    .np-popup h3 { margin:0 0 8px; }
    .np-popup p { margin:0 0 18px; color:#555; }
    @keyframes np-popup-in { from { transform:scale(.9); opacity:0; } to { transform:scale(1); opacity:1; } }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const materiaId = document.getElementById('notas-profesor').dataset.materiaId;

    // --- Habilitar botón "Agregar" solo cuando hay un alumno seleccionado ---
    const selectAlumno = document.getElementById('select-alumno');
    const btnAgregar = document.getElementById('btn-agregar-alumno');
    if (selectAlumno) {
        selectAlumno.addEventListener('change', function () {
            btnAgregar.disabled = !this.value;
        });
    }

    // --- Pop up amistoso (éxito / error al guardar) ---
    const popupOverlay = document.getElementById('np-popup-overlay');
    function mostrarPopup(icono, titulo, mensaje) {
        document.getElementById('np-popup-icono').textContent = icono;
        document.getElementById('np-popup-titulo').textContent = titulo;
        document.getElementById('np-popup-mensaje').textContent = mensaje;
        popupOverlay.style.display = 'flex';
        document.getElementById('np-popup-aceptar').focus();
    }
    function cerrarPopup() { popupOverlay.style.display = 'none'; }
    document.getElementById('np-popup-aceptar').addEventListener('click', cerrarPopup);
    popupOverlay.addEventListener('click', function (e) { if (e.target === popupOverlay) cerrarPopup(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') cerrarPopup(); });

    const guardarNotasButton = document.getElementById('np-guardar-notas');
    const guardarEstado = document.getElementById('np-guardar-estado');

    guardarNotasButton?.addEventListener('click', function () {
        const notas = Array.from(document.querySelectorAll('.np-tabla-notas tbody tr[data-usuario-id]')).map(function (fila) {
            const inputsCuatrimestre = fila.querySelectorAll('.np-input-nota');
            const inputPromediada = fila.querySelector('.np-input-promediada');

            return {
                usuario_id: fila.dataset.usuarioId,
                primer_cuatrimestre: inputsCuatrimestre[0].value === '' ? null : inputsCuatrimestre[0].value,
                segundo_cuatrimestre: inputsCuatrimestre[1].value === '' ? null : inputsCuatrimestre[1].value,
                promediada: inputPromediada.value === '' ? null : inputPromediada.value,
            };
        });

        this.disabled = true;
        guardarEstado.textContent = 'Guardando...';

        fetch(`/bolsadetrabajo/profesor/materias/${materiaId}/notas/guardar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ notas }),
        })
        .then(response => {
            if (!response.ok) throw new Error('No se pudo guardar');
            return response.json();
        })
        .then(() => {
            guardarEstado.textContent = '';
            mostrarPopup('🎉', '¡Listo!', 'Las notas fueron cargadas correctamente. ¡Gracias por tu trabajo! 😊');
        })
        .catch(() => {
            guardarEstado.textContent = '';
            mostrarPopup('😕', 'Ups, algo salió mal', 'No pudimos guardar las notas. Revisá que los valores estén entre 0 y 10 e intentá de nuevo.');
        })
        .finally(() => {
            this.disabled = false;
        });
    });

    // --- Popup de detalle del alumno ---
    const overlay = document.getElementById('np-modal-overlay');
    document.querySelectorAll('.np-ver-alumno').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const fila = this.closest('tr');
            const nombre = fila.dataset.nombre + ' ' + fila.dataset.apellido;

            document.getElementById('np-modal-nombre').textContent = nombre;

            const notasHtml = ['<ul class="np-modal-notas-lista">'];
            fila.querySelectorAll('.np-input-nota').forEach(function (input) {
                const nombreCuatrimestre = input.dataset.cuatrimestre === '1' ? 'Primer cuatrimestre' : 'Segundo cuatrimestre';
                notasHtml.push(`<li>${nombreCuatrimestre}: ${input.value || '-'}</li>`);
            });
            notasHtml.push(`<li>Promediada: ${fila.querySelector('.np-input-promediada').value || '-'}</li>`);
            notasHtml.push('</ul>');
            document.getElementById('np-modal-notas').innerHTML = notasHtml.join('');

            overlay.style.display = 'flex';
        });
    });

    document.getElementById('np-modal-close').addEventListener('click', () => overlay.style.display = 'none');
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) overlay.style.display = 'none';
    });
});
</script>
@endsection
