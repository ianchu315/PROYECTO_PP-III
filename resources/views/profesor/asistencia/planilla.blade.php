@extends(Auth::guard('usuarios')->user()->rol === 'superadministrador' ? 'layouts.panel' : 'layouts.app2')

@section('titulo', 'Asistencia - ' . $materia->descripcion)

@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1>{{ $materia->descripcion }}</h1>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('bolsadetrabajo.profesor.asistencia.qr', $materia) }}" class="btn btn-secondary btn-sm">Generar QR</a>
            <a href="{{ route('bolsadetrabajo.profesor.asistencia.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>
    </div>

    @if($errors->any())
        <div class="pf-card" style="border-color:#c0392b; background:#fdecea;">
            @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="GET" action="{{ route('bolsadetrabajo.profesor.asistencia.planilla', $materia) }}" class="pf-card" style="display:flex; gap:10px; align-items:center; margin-bottom:14px;">
        <label for="fecha" style="font-size:13px;">Fecha</label>
        <input type="date" id="fecha" name="fecha" value="{{ $fecha }}" max="{{ now()->toDateString() }}" onchange="this.form.submit()">
    </form>

    @if($alumnos->isEmpty())
        <div class="pf-card">
            <p class="pf-muted mb-0">Esta materia todavía no tiene alumnos inscriptos.</p>
        </div>
    @else
        <form method="POST" action="{{ route('bolsadetrabajo.profesor.asistencia.planilla.guardar', $materia) }}" class="pf-card">
            @csrf
            <input type="hidden" name="fecha" value="{{ $fecha }}">

            <p class="pf-muted" style="font-size:12px; margin-bottom:10px;">
                Ausente = 0 · Tardanza = 1 · Presente = 2. Vale siempre lo último que se cargó:
                si un alumno se marcó con un QR y acá lo cambiás, queda lo que guardes acá (y al revés).
            </p>

            <div style="display:flex; gap:8px; margin-bottom:12px; flex-wrap:wrap;">
                <button type="button" class="btn btn-secondary btn-sm" data-marcar-todos="2">Marcar todos presentes</button>
                <button type="button" class="btn btn-secondary btn-sm" data-marcar-todos="1">Marcar todos con tardanza</button>
                <button type="button" class="btn btn-secondary btn-sm" data-marcar-todos="0">Marcar todos ausentes</button>
            </div>

            @include('partials.filtro_rapido', ['target' => '#tabla-planilla', 'celdas' => 1, 'placeholder' => 'Buscar alumno por nombre o apellido...'])

            <div class="pf-table-wrap">
                <table class="pf-table" id="tabla-planilla">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Estado</th>
                            <th>Justificación (solo ausentes)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumnos as $alumno)
                            @php
                                $actual = $registros->get($alumno->id);
                                $valor = $actual ? $actual->estado : \App\Models\Asistencia::PRESENTE;
                            @endphp
                            <tr>
                                <td>
                                    {{ $alumno->apellido }}, {{ $alumno->nombre }}
                                    @if($actual && $actual->codigo_qr_id)
                                        <span class="pf-muted" style="font-size:11px;">(por QR)</span>
                                    @endif
                                </td>
                                <td>
                                    <input type="hidden" name="asistencia[{{ $alumno->id }}][previo]" value="{{ $valor }}">
                                    @foreach($etiquetas as $codigo => $texto)
                                        <label style="margin-right:10px; font-size:13px; white-space:nowrap;">
                                            <input type="radio" class="pf-asistencia-estado"
                                                   name="asistencia[{{ $alumno->id }}][estado]"
                                                   value="{{ $codigo }}" {{ $valor === $codigo ? 'checked' : '' }}>
                                            {{ $texto }}
                                        </label>
                                    @endforeach
                                </td>
                                <td>
                                    <input type="text" name="asistencia[{{ $alumno->id }}][motivo]"
                                           value="{{ $actual->motivo_justificacion ?? '' }}"
                                           placeholder="Motivo (opcional)" maxlength="100" style="width:100%;">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top:14px;">Guardar asistencia</button>
        </form>
    @endif
</div>

<script>
    document.querySelectorAll('[data-marcar-todos]').forEach(function (boton) {
        boton.addEventListener('click', function () {
            var valor = boton.getAttribute('data-marcar-todos');
            document.querySelectorAll('.pf-asistencia-estado').forEach(function (radio) {
                radio.checked = (radio.value === valor);
            });
        });
    });
</script>
@endsection
