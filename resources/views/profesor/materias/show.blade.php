@extends('layouts.app2')

@section('content')
<div class="pf-page" id="notas-profesor" data-materia-id="{{ $materia->id }}">

    <div class="pf-page-header">
        <h1>{{ $materia->descripcion }}</h1>
        <a href="{{ route('bolsadetrabajo.profesor.materias.index') }}" class="btn btn-secondary">Volver a mis materias</a>
    </div>

    {{-- 1. Configuración de cantidad de notas por cuatrimestre --}}
    <div class="pf-card">
        @if(!$materia->notas_configuradas)
            <h3>Configurar cantidad de notas por cuatrimestre</h3>
            <p class="pf-muted">Elegí cuántas notas vas a cargar por cuatrimestre. Una vez guardado, no se puede cambiar.</p>
            <form method="POST" action="{{ route('bolsadetrabajo.profesor.materias.configurarNotas', $materia) }}" class="pf-form-inline">
                @csrf
                <input type="number" name="cantidad_notas_cuatrimestre" min="1" max="10" required
                       value="{{ old('cantidad_notas_cuatrimestre', 1) }}">
                <button type="submit" class="btn btn-primary">Confirmar cantidad</button>
            </form>
            @error('cantidad_notas_cuatrimestre')
                <div class="error-mensaje">{{ $message }}</div>
            @enderror
        @else
            <p class="mb-0"><strong>Notas por cuatrimestre:</strong> {{ $materia->cantidad_notas_cuatrimestre }} (definitivo)</p>
        @endif
    </div>

    {{-- 2. Agregar alumnos registrados --}}
    <div class="pf-card">
        <h3>Agregar alumno a la materia</h3>
        <form method="POST" action="{{ route('bolsadetrabajo.profesor.materias.agregarAlumno', $materia) }}" class="pf-form-inline" id="form-agregar-alumno">
            @csrf
            <select name="usuario_id" id="select-alumno">
                <option value="">-- Seleccioná un alumno registrado --</option>
                @foreach($alumnosDisponibles as $alumno)
                    <option value="{{ $alumno->id }}">{{ $alumno->email }} ({{ $alumno->nombre }} {{ $alumno->apellido }})</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary" id="btn-agregar-alumno" disabled>Agregar</button>
        </form>
    </div>

    {{-- 3. Listado de alumnos inscriptos + notas --}}
    <div class="pf-card">
        <h3>Alumnos y notas</h3>

        @if($alumnosData->isEmpty())
            <p class="pf-muted mb-0">Todavía no agregaste alumnos a esta materia.</p>
        @elseif(!$materia->notas_configuradas)
            <p class="pf-muted mb-0">Configurá primero la cantidad de notas por cuatrimestre para poder cargar notas.</p>
        @else
            <div class="pf-table-wrap">
                <table class="pf-table np-tabla-notas">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            @for($i = 1; $i <= $materia->cantidad_notas_cuatrimestre; $i++)
                                <th>1° Cuatr. N{{ $i }}</th>
                            @endfor
                            @for($i = 1; $i <= $materia->cantidad_notas_cuatrimestre; $i++)
                                <th>2° Cuatr. N{{ $i }}</th>
                            @endfor
                            <th>Nota extra</th>
                            <th>Condición</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumnosData as $fila)
                            @php
                                $alumno = $fila['usuario'];
                                $notas = $fila['notas'];
                                $condicion = $fila['condicion'];
                                $notaExtra = $fila['notaExtra'];
                            @endphp
                            <tr data-usuario-id="{{ $alumno->id }}"
                                data-nombre="{{ $alumno->nombre }}"
                                data-apellido="{{ $alumno->apellido }}">
                                <td>
                                    <a href="#" class="np-ver-alumno" data-usuario-id="{{ $alumno->id }}">
                                        {{ $alumno->apellido }}, {{ $alumno->nombre }}
                                    </a>
                                </td>

                                @for($c = 1; $c <= 2; $c++)
                                    @for($i = 1; $i <= $materia->cantidad_notas_cuatrimestre; $i++)
                                        @php
                                            $notaExistente = $notas->first(fn($n) => $n->cuatrimestre == $c && $n->numero_nota == $i);
                                        @endphp
                                        <td>
                                            <input type="number" class="np-input-nota" min="0" max="10" step="0.5"
                                                   data-usuario-id="{{ $alumno->id }}"
                                                   data-cuatrimestre="{{ $c }}"
                                                   data-numero-nota="{{ $i }}"
                                                   value="{{ $notaExistente?->nota }}">
                                        </td>
                                    @endfor
                                @endfor

                                <td>
                                    <input type="number" class="np-input-nota-extra" min="0" max="10" step="0.5"
                                           data-usuario-id="{{ $alumno->id }}"
                                           value="{{ $notaExtra?->nota }}"
                                           {{ $condicion === 'regular' && !$notaExtra ? 'disabled' : '' }}
                                           title="Solo aplica si el promedio de cuatrimestres da menos de 4">
                                </td>

                                <td>
                                    <span class="pf-badge np-badge-{{ $condicion }}" data-usuario-id="{{ $alumno->id }}">
                                        {{ $condicion === 'regular' ? 'Regular' : 'Libre' }}
                                    </span>
                                </td>

                                <td>
                                    <form method="POST" action="{{ route('bolsadetrabajo.profesor.materias.quitarAlumno', [$materia, $alumno]) }}"
                                          onsubmit="return confirm('¿Quitar a {{ $alumno->nombre }} {{ $alumno->apellido }} de esta materia? Se borran sus notas cargadas acá.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Quitar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- 4. Popup de detalle del alumno --}}
<div id="np-modal-overlay" class="np-modal-overlay" style="display:none;">
    <div class="np-modal">
        <button type="button" class="np-modal-close" id="np-modal-close" aria-label="Cerrar">&times;</button>
        <h3 id="np-modal-nombre"></h3>
        <p><strong>Materia:</strong> {{ $materia->descripcion }}</p>
        <p><strong>Condición:</strong> <span id="np-modal-condicion"></span></p>
        <div id="np-modal-notas"></div>
    </div>
</div>

<style>
    .np-card { background:#fff; border:1px solid #e2e2e2; border-radius:8px; padding:20px; margin-bottom:20px; }
    .np-inline-form { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
    .np-inline-form select, .np-inline-form input[type="number"] { padding:6px 10px; border:1px solid #ccc; border-radius:4px; }
    .np-tabla-notas input.np-input-nota, .np-tabla-notas input.np-input-nota-extra { width:60px; padding:4px; }
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

    function actualizarCondicion(usuarioId, condicion) {
        const badge = document.querySelector('.np-badge[data-usuario-id="' + usuarioId + '"]');
        if (badge) {
            badge.textContent = condicion === 'regular' ? 'Regular' : 'Libre';
            badge.classList.remove('np-badge-regular', 'np-badge-libre');
            badge.classList.add('np-badge-' + condicion);
        }
        const extraInput = document.querySelector('.np-input-nota-extra[data-usuario-id="' + usuarioId + '"]');
        if (extraInput) {
            // La nota extra solo tiene sentido si no está regular por cuatrimestres,
            // o si ya tiene una cargada (para poder corregirla).
            extraInput.disabled = (condicion === 'regular' && !extraInput.value);
        }
    }

    // --- Guardar nota de cuatrimestre al perder foco ---
    document.querySelectorAll('.np-input-nota').forEach(function (input) {
        input.addEventListener('change', function () {
            fetch(`/bolsadetrabajo/profesor/materias/${materiaId}/notas`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    usuario_id: this.dataset.usuarioId,
                    cuatrimestre: this.dataset.cuatrimestre,
                    numero_nota: this.dataset.numeroNota,
                    nota: this.value === '' ? null : this.value,
                }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.condicion) actualizarCondicion(this.dataset.usuarioId, data.condicion);
            })
            .catch(() => alert('No se pudo guardar la nota. Intentá de nuevo.'));
        });
    });

    // --- Guardar nota extra ---
    document.querySelectorAll('.np-input-nota-extra').forEach(function (input) {
        input.addEventListener('change', function () {
            fetch(`/bolsadetrabajo/profesor/materias/${materiaId}/notas/extra`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    usuario_id: this.dataset.usuarioId,
                    nota: this.value === '' ? null : this.value,
                }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.condicion) actualizarCondicion(this.dataset.usuarioId, data.condicion);
            })
            .catch(() => alert('No se pudo guardar la nota extra. Intentá de nuevo.'));
        });
    });

    // --- Popup de detalle del alumno ---
    const overlay = document.getElementById('np-modal-overlay');
    document.querySelectorAll('.np-ver-alumno').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const fila = this.closest('tr');
            const nombre = fila.dataset.nombre + ' ' + fila.dataset.apellido;
            const condicion = fila.querySelector('.np-badge').textContent.trim();

            document.getElementById('np-modal-nombre').textContent = nombre;
            document.getElementById('np-modal-condicion').textContent = condicion;

            const notasHtml = ['<ul class="np-modal-notas-lista">'];
            fila.querySelectorAll('.np-input-nota').forEach(function (input) {
                notasHtml.push(`<li>Cuatrimestre ${input.dataset.cuatrimestre} - Nota ${input.dataset.numeroNota}: ${input.value || '-'}</li>`);
            });
            const extra = fila.querySelector('.np-input-nota-extra');
            if (extra) {
                notasHtml.push(`<li>Nota extra (recuperatorio): ${extra.value || '-'}</li>`);
            }
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
