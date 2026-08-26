@extends('backend.layouts.main')

@section('title', 'Crear Correlativa')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Nueva Correlativa</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.correlativa.store') }}" method="POST">
                @csrf

                {{-- Seleccionar Carrera --}}
                <div class="mb-3">
                    <label for="carrera_id" class="form-label">Carrera</label>
                    <select name="carrera_id" id="carrera_id" class="form-select" required>
                        <option value="">Seleccione una carrera</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera->id }}"
                                {{ old('carrera_id') == $carrera->id ? 'selected' : '' }}>
                                {{ $carrera->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Seleccionar Año --}}
                <div class="mb-3">
                    <label for="anio_id" class="form-label">Año</label>
                    <select name="anio_id" id="anio_id" class="form-select" required>
                        <option value="">Seleccione un año</option>
                        @foreach($anios as $anio)
                            <option value="{{ $anio->id }}"
                                {{ old('anio_id') == $anio->id ? 'selected' : '' }}>
                                {{ $anio->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Seleccionar Materia --}}
                <div class="mb-3">
                    <label for="materia_id">Materia</label>
                    <select id="materia_id" name="materia_id" class="form-control"></select>
                </div>

                {{-- Seleccionar Correlativa --}}
                <div class="mb-3">
                    <label for="correlativa_id">Correlativa</label>
                    <select id="correlativa_id" name="correlativa_id" class="form-control"></select>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('backend.correlativa.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
<script>
$(function(){
    function cargarMaterias() {
        $.get("{{ route('correlativas.materias') }}", {
            carrera_id: $('#carrera_id').val(),
            anio_id: $('#anio_id').val()
        }, function(data){
            let $materia = $('#materia_id').empty().append('<option value="">Seleccione una materia</option>');
            data.forEach(m => $materia.append(`<option value="${m.id}">${m.descripcion}</option>`));
            
        });
    }

    $('#carrera_id, #anio_id').on('change', cargarMaterias);

    $('#materia_id').on('change', function(){
        $.get("{{ route('correlativas.correlativas') }}", {
            materia_id: $(this).val()
        }, function(data){
            let $corr = $('#correlativa_id').empty().append('<option value="">Seleccione</option>');
            if (data.length) {
                data.forEach(m => $corr.append(`<option value="${m.id}">${m.descripcion}</option>`));
                $corr.prop('disabled', false);
            } else {
                $corr.prop('disabled', true);
            }
        });
    });
});
</script>
@endsection