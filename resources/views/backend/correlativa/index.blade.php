@extends('backend.layouts.main')
@section('title', 'Correlativas')
@section('content')

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                background: '#e6fff2',
                color: '#155724',
            });
        });
    </script>
@endif

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

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Error',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'Aceptar',
                background: '#fff5f5',
                color: '#842029',
            });
        });
    </script>
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

<div class="container">

     <!-- Filtro -->
    <div class="mb-3">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Filtrar Correlativas</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('backend.correlativa.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="filtro-carrera" class="form-label">Carrera</label>
                            <select name="carrera_id" id="filtro-carrera" class="form-select">
                                <option value="">Todas las carreras</option>
                                @foreach ($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" {{ request('carrera_id') == $carrera->id ? 'selected' : '' }}>
                                        {{ $carrera->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="filtro-anio" class="form-label">Año</label>
                            <select name="anio_id" id="filtro-anio" class="form-select">
                                <option value="">Todos los años</option>
                                @foreach ($anios as $a)
                                    <option value="{{ $a->id }}" {{ request('anio_id') == $a->id ? 'selected' : '' }}>
                                        {{ $a->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="filtro-materia" class="form-label">Materia</label>
                            <select name="materia_id" id="filtro-materia" class="form-select">
                                <option value="">Todas las materias</option>
                                @foreach ($materias as $m)
                                    <option value="{{ $m->id }}" {{ request('materia_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel-fill me-1"></i> Filtrar
                        </button>
                        <a href="{{ route('backend.correlativa.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow border-0 rounded-3 mb-3">
        <div class="card-header text-bg-dark d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="mb-0">
                <i class="bi bi-diagram-3"></i> Correlativas
            </h4>
            <a href="{{ route('backend.correlativa.create') }}" class="btn btn-success d-flex align-items-center gap-2">
                <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Nueva"> Nueva Correlativa
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Carrera</th>
                            <th>Año</th>
                            <th>Materia</th>
                            <th>Correlativa</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($correlativas as $correlativa)
                            <tr class="text-center">
                                <td>{{ $correlativa->materia?->deCarrera->descripcion ?? 'Sin carrera' }}</td>
                                <td>{{ $correlativa->materia?->deAnio->descripcion ?? 'Sin año' }}</td>
                                <td>{{ $correlativa->materia?->descripcion ?? 'Sin materia' }}</td>
                                <td>{{ $correlativa->correlativa?->descripcion ?? 'Sin correlativa' }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('backend.correlativa.edit', ['correlativa' => $correlativa->id, 'carrera_id' => request('carrera_id'), 'anio_id' => request('anio_id')]) }}"
                                       class="btn btn-primary btn-sm" title="Editar">
                                        <img src="{{ asset('svg/edit.svg') }}" width="18" height="18" alt="Editar">
                                    </a>
                                    <form action="{{ route('backend.correlativa.destroy', $correlativa->id) }}" method="POST"
                                          onsubmit="return confirmarEliminacion(event, this)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <img src="{{ asset('svg/delete.svg') }}" width="18" height="18" alt="Eliminar">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay correlativas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        {{ $correlativas->appends(request()->query())->links() }}
    </div>

</div>

<script>
    function confirmarEliminacion(e, form) {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar correlativa?',
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

<script>
document.addEventListener("DOMContentLoaded", function() {
    let carreraSelect = document.getElementById("filtro-carrera");
    let anioSelect = document.getElementById("filtro-anio");
    let materiaSelect = document.getElementById("filtro-materia");

    async function cargarMaterias() {
        let carreraId = carreraSelect.value;
        let anio = anioSelect.value;

        materiaSelect.innerHTML = '<option value="">Cargando...</option>';
        const url = '{{ route("correlativas.materias") }}' + `?carrera_id=${encodeURIComponent(carreraId)}&anio_id=${encodeURIComponent(anio)}`;

        try {
            const res = await fetch(url);
            if (!res.ok) throw new Error("Error en la respuesta");
            const data = await res.json();

            materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';
            data.forEach(m => {
                materiaSelect.innerHTML += `<option value="${m.id}">${m.descripcion}</option>`;
            });
        } catch (err) {
            materiaSelect.innerHTML = '<option value="">Error al cargar materias</option>';
        }
    }

    carreraSelect.addEventListener("change", cargarMaterias);
    anioSelect.addEventListener("change", cargarMaterias);
});
</script>

@endsection
