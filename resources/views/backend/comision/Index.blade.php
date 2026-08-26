@extends('backend.layouts.main')
@section('title', 'Comisiones')
@section('content')

<style>
* {
  font-family: 'Quicksand', sans-serif;
}

button {
  margin-left: 10px;
}

.botonera {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  width: 250px;
  gap: 8px;
}

/* Efectos de hover */
.btn-primary, .btn-danger, .btn-success {
  transition: all 0.3s ease-in-out;
}

.btn-primary:hover, .btn-danger:hover, .btn-success:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
</style>

@if(session('success'))
  <div class="alert alert-success text-center shadow-sm fw-bold">
      {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger text-center shadow-sm fw-bold">
      {{ session('error') }}
  </div>
@endif

<div class="container mt-4">
  <div class="card shadow border-0 rounded-3">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="bi bi-people-fill"></i> Comisiones</h4>
        <a href="{{ route('comision.create') }}" class="btn btn-success">
          <img src="{{ asset('svg/new.svg') }}" height="20" width="20" alt="Crear" title="Crear"> Crear Comisión
        </a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered mb-0">
          <thead class="text-center">
            <tr>
              <th>Comisión</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody class="text-center align-middle">
            @forelse($comisiones as $comision)
              <tr>
                <td>{{ $comision->comision }}</td>
                <td>
                  {{ Form::model($comision, ['method' => 'delete', 'route' => ['comision.destroy', $comision->id]]) }}
                  @csrf
                  <div class="botonera justify-content-center">
                    <a href="{{ route('comision.edit', ['comision' => $comision->id]) }}" class="btn btn-primary">
                      <img src="{{ asset('svg/edit.svg') }}" width="20" height="20" alt="Editar" title="Editar">
                    </a>
                    <button 
                      type="submit" 
                      class="btn btn-danger" 
                      onclick="return confirm('⚠️ ¿Está seguro de eliminar esta comisión? Esta acción no se puede deshacer.')">
                      <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar" title="Borrar">
                    </button>
                  </div>
                  {!! Form::close() !!}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-center text-muted">No hay comisiones registradas.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
