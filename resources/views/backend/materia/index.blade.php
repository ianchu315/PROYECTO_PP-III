@extends('backend.layouts.main')
@section('title', 'Materias')
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
                position: 'center',
                customClass: { popup: 'swal2-popup-custom' }
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
                position: 'center',
                customClass: { popup: 'swal2-popup-custom' }
            });
        });
    </script>
@endif

@if ($errors->any())
    <div class="alert alert-danger shadow-sm">
        <strong>Se encontraron errores:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="mt-1">
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filtrar Materias</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('materia.index') }}">
                <div class="row g-2">
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
                    <div class="col-md-2">
                        <label for="filtro-anio" class="form-label">Año</label>
                        <select name="anio_id" id="filtro-anio" class="form-select">
                            <option value="">Todos los años</option>
                            @foreach ($anio as $a)
                                <option value="{{ $a->id }}" {{ request('anio_id') == $a->id ? 'selected' : '' }}>
                                    {{ $a->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filtro-materia" class="form-label">Materia</label>
                        <select name="id" id="filtro-materia" class="form-select">
                            <option value="">Todas las materias</option>
                            @foreach ($materia as $m)
                                <option value="{{ $m->id }}" data-carrera="{{ $m->carrera_id }}" data-anio="{{ $m->anio_id }}"
                                    {{ request('id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="filtro-categoria" class="form-label">Categoría</label>
                        <select name="categoria_id" id="filtro-categoria" class="form-select">
                            <option value="">Todas las categorías</option>
                            @foreach ($categoria as $c)
                                <option value="{{ $c->id }}" {{ request('categoria_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->categoria ?? 'Sin categoría' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel-fill"></i> Filtrar
                    </button>
                    <a href="{{ route('materia.index') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    @forelse($materias as $materia)
        @if ($loop->first)
            <div class="card shadow border-0 rounded-3 mb-3">
                <div class="card-header text-bg-dark d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-book-half"></i> Materias</h4>
                    <a class="btn btn-success" href="{{ route('materia.create') }}">
                        <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
                        Crear Materia
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0 text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Materia</th>
                                    <th>Categoría</th>
                                    <th>Carrera</th>
                                    <th>Año</th>
                                    <th>Orden</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
        @endif
        <tbody>
            <tr>
                <td>{{ $materia->descripcion }}</td>
                <td>{{ $materia->categoria->categoria ?? 'Sin categoría' }}</td>
                <td>{{ $materia->deCarrera->descripcion ?? 'Sin carrera' }}</td>
                <td>{{ $materia->deAnio->descripcion ?? 'Sin año' }}</td>
                <td>{{ $materia->orden }}</td>
                <td>
                    <div class="d-flex justify-content-center gap-2">
                        {{-- Editar --}}
                        <a href="{{ route('materia.edit', $materia->id) }}?{{ request()->getQueryString() }}"
                            class="btn btn-primary btn-sm w-100" title="Editar">
                            <img src="{{ asset('svg/edit.svg') }}" width="18" height="18" alt="Editar">
                        </a>

                        {{-- Eliminar --}}
                        <form action="{{ route('materia.destroy', $materia->id) }}" method="POST"
                              onsubmit="return confirmarEliminacion(event, this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100" title="Eliminar">
                                <img src="{{ asset('svg/delete.svg') }}" width="18" height="18" alt="Eliminar">
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        </tbody>
        @if ($loop->last)
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <div class="card shadow border-0 rounded-3 mb-3">
            <div class="card-header text-bg-dark d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-book-half"></i> Materias</h4>
                <a class="btn btn-success" href="{{ route('materia.create') }}">
                    <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
                    Crear Materia
                </a>
            </div>
            <div class="card-body text-center py-3 text-muted">
                No hay materias registradas.
            </div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center">
    {{ $materias->appends(request()->query())->links() }}
</div>

<script>
    function confirmarEliminacion(e, form) {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar materia?',
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

    document.addEventListener('DOMContentLoaded', function () {
        const carreraSelect = document.getElementById('filtro-carrera');
        const anioSelect    = document.getElementById('filtro-anio');
        const materiaSelect = document.getElementById('filtro-materia');
        if (!carreraSelect || !materiaSelect) return;

        const allOptions = Array.from(materiaSelect.querySelectorAll('option')).map(o => o.cloneNode(true));

        function filterMaterias() {
            const selectedCarrera = carreraSelect.value;
            const selectedAnio = anioSelect ? anioSelect.value : '';
            const previousValue = materiaSelect.value;
            materiaSelect.innerHTML = '';

            const empty = allOptions.find(o => o.value === '');
            if (empty) materiaSelect.appendChild(empty.cloneNode(true));

            allOptions.forEach(opt => {
                if (opt.value === '') return;
                const matchCarrera = !selectedCarrera || opt.dataset.carrera === selectedCarrera;
                const matchAnio = !selectedAnio || opt.dataset.anio === selectedAnio;
                if (matchCarrera && matchAnio) materiaSelect.appendChild(opt.cloneNode(true));
            });

            const restored = Array.from(materiaSelect.options).find(o => o.value === previousValue);
            materiaSelect.value = restored ? previousValue : '';
        }

        filterMaterias();
        carreraSelect.addEventListener('change', filterMaterias);
        if (anioSelect) anioSelect.addEventListener('change', filterMaterias);
    });
</script>

<style>
    .alert {
        border-radius: 8px;
        font-size: 15px;
        padding: 10px 15px;
    }

    .swal2-popup-custom {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
</style>

@endsection
