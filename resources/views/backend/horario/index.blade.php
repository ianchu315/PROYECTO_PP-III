@extends('backend.layouts.main')
@section('title', 'Horarios por Carreras')
@section('content')

<div class="Inicio">
  <h1>Cargar horarios</h1>
</div>
<div>
    @if(Session::has('status'))
    <div class="alert alert-success">{{ Session('status')}}</div>
    @endif
</div>
<div class="row justify-content-center">
  <div class="col-lg-8 col-md-10">
    <div class="card border border-0 shadow rounded">
      <div class="card-body p-4">
        {{ Form::open(['route' => 'horario.search']) }}
        <div class="mb-2">
          {{ Form::label("sede_id",'Sede', ['class' => 'form-label fw-bold']) }}
          {{Form::select("sede_id", $sedes, null, ["class" => "form-control", "placeholder" => "Seleccione la sede" ]) }}
          @error('sede_id')
          <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-2">
          {{ Form::label("carrera",'Carrera', ['class' => 'form-label fw-bold']) }}
          {{Form::select("carrera_id", $carreras, null, ["class" => "form-control", "placeholder" => "Seleccione una carrera" ]) }}
          @error('carrera_id')
          <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="row">
          <div class="col-md-6 mb-2">
            {{ Form::label("resolucion_id",'Resolución', ['class' => 'form-label fw-bold']) }}
            {{ Form::select("resolucion_id", [], old('resolucion_id'), ["class" => "form-control", "placeholder" => "Seleccione la resolución"]) }}
            @error('resolucion_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6 mb-2">
            {{ Form::label("año", 'Año', ['class' => 'form-label fw-bold']) }}
            {{Form::select("anio_id", $anios, null, ["class" => "form-control", "placeholder" => "Seleccione el año" ]) }}
            @error('anio_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-2">
            {{ Form::label("comision",'Comisión', ['class' => 'form-label fw-bold']) }}
            {{Form::select("comision_id", $comisions, null, ["class" => "form-control", "placeholder" => "Seleccione la comisión" ]) }}
            @error('comision_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6 mb-2">
            {{ Form::label("cuatrimestre_id",'Modalidad', ['class' => 'form-label fw-bold']) }}
            {{ Form::select("cuatrimestre_id", [
              '0' => 'ANUAL',
              '1' => '1° CUATRIMESTRE',
              '2' => '2° CUATRIMESTRE'
            ], $cuatrimestre_id ?? null, ["class" => "form-control", "placeholder" => "Seleccione la modalidad"]) }}
            @error('cuatrimestre_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="d-grid mt-3">
          <button type="submit" class="btn btn-success">Consultar</button>
        </div>
        {!!Form::close()!!}
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
      let carreraSelect = document.querySelector('[name="carrera_id"]');
      let resolucionSelect = document.querySelector('[name="resolucion_id"]');

      let oldResolucion = "{{ old('resolucion_id') }}";
      let oldCarrera    = "{{ old('carrera_id') }}";

      // Si había carrera seleccionada antes, recargo resoluciones automáticamente
      if (oldCarrera) {
          fetch(`/horarios/resoluciones/${oldCarrera}`)
              .then(response => response.json())
              .then(data => {
                  resolucionSelect.innerHTML = '<option value="">Seleccione la resolución</option>';
                  Object.entries(data).forEach(([id, nombre]) => {
                      let selected = (id == oldResolucion) ? "selected" : "";
                      resolucionSelect.innerHTML += `<option value="${id}" ${selected}>${nombre}</option>`;
                  });
              });
      }

      // Cuando cambia carrera manualmente
      carreraSelect.addEventListener("change", function() {
          let carreraId = this.value;
          resolucionSelect.innerHTML = '<option value="">Cargando...</option>';

          if (carreraId) {
              fetch(`/horarios/resoluciones/${carreraId}`)
                  .then(response => response.json())
                  .then(data => {
                      resolucionSelect.innerHTML = '<option value="">Seleccione la resolución</option>';
                      Object.entries(data).forEach(([id, nombre]) => {
                          resolucionSelect.innerHTML += `<option value="${id}">${nombre}</option>`;
                      });
                  })
                  .catch(() => {
                      resolucionSelect.innerHTML = '<option value="">Error al cargar</option>';
                  });
          } else {
              resolucionSelect.innerHTML = '<option value="">Seleccione la resolución</option>';
          }
      });
  });
</script>

@endsection