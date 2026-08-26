@extends('backend.layouts.main')
@section('title', 'Carreras')
@section('content')

<style>
* {
    font-family: 'Quicksand', sans-serif;
}
button {
  margin-left: 10px;
}
.subcontainer {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  flex-direction: row;
}
.horario {
  color: black;
  border: 1px solid black;
  border-radius: 25px;
  padding: 10px;
}
.botonera {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  width: 300px;
}

/* Animaciones */
.btn-info, .btn-primary, .btn-danger, .btn-warning, .hover-scale {
  transition: all 0.3s ease-in-out;
}
.btn-info:hover,
.btn-primary:hover,
.btn-danger:hover,
.btn-warning:hover,
.hover-scale:hover {
  transform: scale(1.05);
}
.btn-warning:hover, .hover-scale:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Personalización del popup */
.swal2-popup-custom {
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.25);
}
</style>

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

@if($errors->any())
<div class="alert alert-danger shadow-sm">
  <strong>Se encontraron errores:</strong>
  <ul class="mb-0">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

@forelse($carreras as $carrera)
  @if($loop->first)
  <div class="container">
    <div class="card shadow border-0 rounded-3">
      <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
          <h4 class="mb-0"><i class="bi bi-mortarboard-fill"></i> Carreras</h4>
          <a href="{{ route('carrera.create') }}" class="btn btn-success">
            <i class="bi bi-pencil-square"></i> Crear Carrera
          </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
              <tr>
                  <th>Carrera</th>
                  <th>Resolución</th>            
                  <th>Años</th>
                  <th>Acciones</th>
              </tr>     
            </thead>
  @endif
            <tbody>
              <tr>
                <td>{{ $carrera->descripcion }}</td>
                <td>{{ $carrera->resolucion }}</td>              
                <td>{{ $carrera->anios }}</td>        
                <td>
                  <form action="{{ route('carrera.destroy', $carrera->id) }}" method="POST" onsubmit="return confirmarEliminacion(event, this)">
                    @csrf  
                    @method('DELETE')
                    <div class="botonera">
                        <a href="{{ route('carrera.show', ['carrera' => $carrera->id ]) }}" class="btn btn-info svg">
                            <img src="{{ asset('svg/show.svg') }}" width="20" height="20" alt="Show" title="Show">
                        </a>
                        <a href="{{ route('carrera.edit', ['carrera' => $carrera->id ]) }}" class="btn btn-primary svg ms-2">
                            <img src="{{ asset('svg/edit.svg') }}" width="20" height="20" alt="Editar" title="Editar">
                        </a>
                        {{-- Eliminar con confirmación SweetAlert --}}
                        <button type="submit" class="btn btn-danger svg" title="Eliminar">
                            <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar" title="Borrar">
                        </button>

                        <!-- Materias y PDF -->
                        <div class="d-flex mt-3">
                            <a href="{{ route('carrera.materias', ['carrera_id' => $carrera->id ]) }}" class="btn btn-warning svg me-2">
                                <img src="{{ asset('svg/historia.svg') }}" width="20" height="20" alt="Materias" title="Materias"> Materias
                            </a>
                            <a href="{{ route('carrera.mesas.pdf', $carrera->id) }}" 
                              class="btn btn-danger d-flex align-items-center gap-2 shadow-sm px-2 py-2 hover-scale" aria-label="Descargar PDF de {{ $carrera->descripcion }}">
                              <i data-lucide="download" class="w-5 h-5" aria-hidden="true"></i>
                              <span class="visually-hidden">Descargar PDF</span>
                            </a>
                        </div>
                    </div>
                  </form>
                </td>
              </tr>
            </tbody>
  @if($loop->last)
          </table>
        </div>
      </div>
    </div>
  </div>  
  @endif
@empty
  <p class="text-capitalize text-center mt-3">No hay carreras.</p>
@endforelse   

<script>
function confirmarEliminacion(e, form) {
    e.preventDefault();
    Swal.fire({
        title: '¿Eliminar carrera?',
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
lucide.createIcons();
</script>

@endsection
