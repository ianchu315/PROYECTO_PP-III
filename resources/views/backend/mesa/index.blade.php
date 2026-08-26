@extends('backend.layouts.main')
@section('content')


@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Se encontraron errores:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ALERTA DE ELIMINACIÓN EXITOSA --}}
@if(session('deleted'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Eliminado',
                text: "{{ session('deleted') }}",
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                background: '#ffe6e6',
                color: '#721c24',
            });
        });
    </script>
@endif

<!--Filtros-->
<div class="mb-3">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filtrar Mesas</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('mesas.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="filtro-carrera" class="form-label">Carrera</label>
                        <select name="carrera_id" id="filtro-carrera" class="form-select" aria-label="carrera">
                            <option value="">Todas las carreras</option>
                            @foreach ($carreras as $carrera)
                                <option value="{{ $carrera->id }}" {{ request('carrera_id') == $carrera->id ? 'selected' : '' }}>
                                    {{ $carrera->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filtro-resolucion" class="form-label">Resolución</label>
                        <select name="resolucion_id" id="filtro-resolucion" class="form-select" aria-label="resolucion">
                            <option value="">Todas las resoluciones</option>
                            @foreach ($resoluciones as $resolucion)
                                <option value="{{ $resolucion->id }}" {{ request('resolucion_id') == $resolucion->id ? 'selected' : '' }}>
                                    {{ $resolucion->resolucion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filtro-año" class="form-label">Año</label>
                        <select name="anio_id" id="filtro-año" class="form-select">
                            <option value="">Todos los años</option>
                            <option value="1" {{ request('anio_id') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ request('anio_id') == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ request('anio_id') == '3' ? 'selected' : '' }}>3</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filtro-materia" class="form-label">Materia</label>
                        <select name="materia_id" id="filtro-materia" class="form-select">
                            <option value="">Todas las materias</option>
                            @foreach ($materias as $materia)
                                <option value="{{ $materia->id }}" data-carrera="{{ $materia->carrera_id }}"
                                    {{ request('materia_id') == $materia->id ? 'selected' : '' }}>
                                    {{ $materia->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Profesor</label>
                        <select name="profesor_id" id="mi-select" class="form-select mselect">
                            <option value="">Todos los profesores</option>
                            @foreach ($profesors as $profesor)
                                <option value="{{ $profesor->id }}" {{ request('profesor_id') == $profesor->id ? 'selected' : '' }}>
                                    {{ $profesor->apellido }}, {{ $profesor->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="vocal" class="form-label">Vocal</label>
                        <select name="vocal_id" id="vocal" class="form-select mselect">
                            <option value="">Todos los vocales</option>
                            @foreach ($profesors as $profesor)
                                <option value="{{ $profesor->id }}" {{ request('vocal_id') == $profesor->id ? 'selected' : '' }}>
                                    {{ $profesor->apellido }}, {{ $profesor->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_inicio" class="form-label" aria-label="fecha">Fecha desde</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}" aria-label="fecha_inicio">
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_fin" class="form-label">Fecha hasta</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}" aria-label="fecha_fin">
                    </div>
                    <div class="col-md-4">
                        <label for="comision" class="form-label">Comisión</label>
                        <select name="comision" id="comision" class="form-select">
                            <option value="">Todas las comisiones</option>
                            <option value="A" {{ request('comision') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ request('comision') == 'B' ? 'selected' : '' }}>B</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel-fill me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('mesas.index') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Tabla-->
<div class="card shadow border-0 rounded-3 mb-3">
    <div class="card-header text-bg-dark d-flex justify-content-between flex-wrap">
        <h4 class="mb-0"><i class="bi bi-file-earmark-text"></i> Mesas</h4>
        <div class="d-flex gap-2 mt-2 mt-md-0">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalFechas">
                <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
                Crear Mesas
            </button>
            <form action="{{ route('mesas.eliminarTodas') }}" method="POST" onsubmit="return confirmarEliminacion(event, this)">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Eliminar Mesas" title="Eliminar Mesas">
                    Eliminar Mesas
                </button>
            </form>
            <form action="{{ route('mesas.asignarSalones') }}" method="POST">
                @csrf
                <input type="hidden" name="carrera_id" value="{{ $carrera->id }}">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-building"></i>
                    Asignar Salones
                </button>
            </form>
            <form action="{{ route('mesas.toggleVisibilidad') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning">
                    @if(\App\Models\Configuracion::where('clave', 'mostrar_mesas')->value('valor'))
                        <i class="bi bi-eye-slash"></i> Ocultar Mesas
                    @else
                        <i class="bi bi-eye"></i> Mostrar Mesas
                    @endif
                </button>
            </form>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th>Materia</th>
                        <th>Carrera</th>
                        <th>Año</th>
                        <th>Presidente</th>
                        <th>Vocal</th>
                        <th>Fecha</th>
                        <th>Mes</th>
                        <th>Horario</th>
                        <th>Comision</th>
                        <th>Resolucion</th>
                        <th>Inscriptos</th>
                        <th>Salón</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach($mesas as $mesa)
                        <tr class="text-center">
                            <td>{{ $mesa->materia->descripcion ?? 'sin Materia' }}</td>
                            <td>{{ $mesa->carrera->descripcion ?? 'sin carrera' }}</td>
                            <td>{{ $mesa->anio_id }}</td>
                            <td>{{ $mesa->profesor->nombre ?? '' }} {{ $mesa->profesor->apellido ?? 'sin profesor' }}</td>    
                            <td>{{ $mesa->vocal->nombre ?? '' }} {{ $mesa->vocal->apellido ?? 'sin vocal' }}</td>
                            <td>{{ $mesa->fecha }}</td>
                            <td>{{ mb_strtoupper(\Carbon\Carbon::parse($mesa->fecha)->translatedFormat('F')) }}</td>
                            <td>{{ $mesa->horario }}</td>
                            <td>{{ $mesa->comision }}</td>
                            <td>{{ $mesa->resolucion->resolucion ?? 'Sin resolución' }}</td>
                            <td>{{ $mesa->inscriptos ?? '-'}}</td>
                            <td>{{ $mesa->Salon->numero_salon ?? 'sin salon' }}</td>
                            <td>
                                <a href="{{ route('mesas.edit', ['mesa' => $mesa->id, 'page' => request('page')]) }}" class="btn btn-primary w-100 mb-1">
                                    <img src="{{ asset('svg/edit.svg') }}" width="18" height="18" alt="Editar" title="Editar">
                                </a>
                                <form action="{{ route('mesas.destroy', $mesa->id) }}" method="POST" onsubmit="return confirmarEliminacion(event, this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <img src="{{ asset('svg/delete.svg') }}" width="18" height="18" alt="Eliminar" title="Eliminar">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $mesas->links() }}
</div>
<div class="modal fade" id="modalFechas" tabindex="-1" aria-labelledby="modalFechasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('mesas.generarConRango') }}" method="POST" class="modal-content">
            @csrf   
            <div class="modal-header">
                <h5 class="modal-title" id="modalFechasLabel">Generar mesas por rango de fechas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Generar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const materias = @json($materias);
        const carreraSelect = document.getElementById('filtro-carrera');
        const materiaSelect = document.getElementById('filtro-materia');
        const selectedMateriaId = "{{ request('materia_id') }}";

        function actualizarMaterias(carreraId) {
            materiaSelect.innerHTML = '<option value="">Todas las materias</option>';
            materias
                .filter(m => carreraId === "" || m.carrera_id == carreraId)
                .forEach(m => {
                    const option = document.createElement('option');
                    option.value = m.id;
                    option.textContent = m.descripcion;
                    if (m.id == selectedMateriaId) {
                        option.selected = true;
                    }
                    materiaSelect.appendChild(option);
                });
        }

        if (carreraSelect.value) {
            actualizarMaterias(carreraSelect.value);
        }

        carreraSelect.addEventListener('change', function () {
            actualizarMaterias(this.value);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#mi-select').select2({ placeholder: "Seleccione un profesor", theme: 'default', allowClear: true });
        $('#vocal').select2({ placeholder: "Seleccione un vocal", theme: 'default', allowClear: true });
    });
</script>
@if(session('deleted'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('deleted') }}",
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                backdrop: true,
                position: 'center',
                background: '#e6fff2',
                color: '#155724',
                customClass: { popup: 'swal2-popup-custom' }
            });
        });
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const inicio = document.querySelector('#fecha_inicio');
    const fin = document.querySelector('#fecha_fin');

    if (!inicio || !fin) return;

    // parsea 'YYYY-MM-DD' a objeto Date (sin problema de zona horaria)
    function parseDateYMD(ymd) {
        if (!ymd) return null;
        const parts = ymd.split('-').map(Number);
        if (parts.length !== 3) return null;
        // new Date(year, monthIndex, day)
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }

    // formatea Date a 'YYYY-MM-DD'
    function formatDateYMD(d) {
        const yyyy = d.getFullYear();
        const mm = String(d.getMonth() + 1).padStart(2, '0');
        const dd = String(d.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    function addDays(date, days) {
        const r = new Date(date.valueOf());
        r.setDate(r.getDate() + days);
        return r;
    }

    function actualizarMinYValorFin() {
        const valorInicio = inicio.value;
        if (!valorInicio) {
        // quitar restricción
        fin.removeAttribute('min');
        return;
        }
        const dInicio = parseDateYMD(valorInicio);
        if (!dInicio) return;

        // definimos que la fecha final debe ser STRICTLY greater,
        // por eso usamos +1 día como mínimo.
        const minFinDate = addDays(dInicio, 0);
        const minFinYMD = formatDateYMD(minFinDate);

        fin.setAttribute('min', minFinYMD);

        // si el fin no existe o es menor o igual al mínimo, lo ponemos en el mínimo
        const valorFin = fin.value;
        const dFin = parseDateYMD(valorFin);
        if (!valorFin || !dFin || dFin.valueOf() <= minFinDate.valueOf()) {
        fin.value = minFinYMD;
        }
    }

    // ejecutar en cambio de fecha inicio
    inicio.addEventListener('change', actualizarMinYValorFin);

    // ejecutar al cargar la página por si hay valores desde request(...)
    actualizarMinYValorFin();
    });
</script>
<script>
    function confirmarEliminacion(e, form) {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar registro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
<style>
    .mselect + .select2 .select2-selection {
        background-color: #ffffff !important;
        border: 1px solid lightgray !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: black !important;
    }
    .select2-container--default .select2-selection--single {
        display: flex;
        align-items: center;
        height: 38px !important;
        padding: 3px !important;
        background-color: #f0f0f0 !important;
        border-radius: 6px !important;
        border: 1px solid #ccc !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: black !important;
        font-weight: 500 !important;
    }
    .select2-container--default .select2-results > .select2-results__options {
        background-color: #ffffff !important;
        font-size: 16px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        display: flex;
        align-items: center;
        right: 10px;
    }
</style>

@endsection