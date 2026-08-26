@extends('backend.layouts.main')
@section('title', 'Categorías')
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
                backdrop: true,
                position: 'center',
                background: '#e6fff2',
                color: '#155724',
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
                backdrop: true,
                position: 'center',
                background: '#ffe6e6',
                color: '#721c24',
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

{{-- ================= TABLA ================= --}}
<div class="container mt-4">
    <div class="card shadow border-0 rounded-3">
        <div class="card-header text-bg-dark d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="mb-0">
                <i class="bi bi-tags"></i> Categorías
            </h4>
            <a href="{{ route('categoria.create') }}" class="btn btn-success mt-2 mt-md-0">
                <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
                Nueva Categoría
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->categoria }}</td>
                                <td>{{ $categoria->descripcion }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Editar --}}
                                        <a href="{{ route('categoria.edit', $categoria) }}" class="btn btn-primary btn-sm w-100" title="Editar">
                                            <img src="{{ asset('svg/edit.svg') }}" width="18" height="18" alt="Editar">
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('categoria.destroy', $categoria) }}" method="POST" onsubmit="return confirmarEliminacion(event, this)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100" title="Eliminar">
                                                <img src="{{ asset('svg/delete.svg') }}" width="18" height="18" alt="Eliminar">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">No hay categorías registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($categorias->hasPages())
            <div class="card-footer bg-light text-center">
                {{ $categorias->links() }}
            </div>
        @endif
    </div>
</div>


<script>
    // Confirmación elegante con SweetAlert
    function confirmarEliminacion(e, form) {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar categoría?',
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
    .alert {
        border-radius: 8px;
        font-size: 15px;
        padding: 10px 15px;
    }

    .table {
        margin-bottom: 0;
        border-color: #dee2e6;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .card-header.text-bg-dark {
        background-color: #212529 !important;
        color: #fff !important;
    }

    .btn-success img,
    .btn-primary img,
    .btn-danger img {
        vertical-align: middle;
        margin-right: 4px;
    }

    .swal2-popup-custom {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
    }
</style>

@endsection
