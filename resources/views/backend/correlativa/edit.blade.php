@extends('backend.layouts.main')
@section('title', 'Editar Correlativa')
@section('content')

@php
    $selectedCarrera = old('carrera_id', optional($correlativa->materia)->carrera_id);
    $selectedAnio    = old('anio_id', optional($correlativa->materia)->anio_id);
    $selectedMateria = old('materia_id', $correlativa->materia_id);
    $selectedCorr    = old('correlativa_id', $correlativa->correlativa_id);
@endphp

<div class="container mt-1">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Editar Correlativa</h5>
        </div>
        <div class="card-body">
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

            <form action="{{ route('backend.correlativa.update', $correlativa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="carrera_id" class="form-label">Carreras</label>
                    <select name="carrera_id" id="carrera_id" class="form-select" required>
                        <option value="">Seleccione una carrera</option>
                        @foreach ($carreras as $carrera)
                            <option value="{{ $carrera->id }}" 
                                {{ (string) $selectedCarrera === (string) $carrera->id ? 'selected' : '' }}>
                                {{ $carrera->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="anio_id" class="form-label">Año</label>
                    <select name="anio_id" id="anio_id" class="form-select" required>
                        <option value="">Seleccione un año</option>
                        @foreach ($anios as $anio)
                            <option value="{{ $anio->id }}" 
                                {{ (string) $selectedAnio === (string) $anio->id ? 'selected' : '' }}>
                                {{ $anio->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                
                <div class="mb-3">
                    <label for="materia_id" class="form-label">Materia</label>
                    <select name="materia_id" id="materia_id" class="form-select" required>
                        <option value="">Seleccione una materia</option>
                        @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}" 
                                {{ $correlativa->materia_id == $materia->id ? 'selected' : '' }}>
                                {{ $materia->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="correlativa_id" class="form-label">Correlativa</label>
                    <select name="correlativa_id" id="correlativa_id" class="form-select" required>
                        <option value="">Seleccione una correlativa</option>
                        @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}" 
                                {{ $correlativa->correlativa_id == $materia->id ? 'selected' : '' }}>
                                {{ $materia->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('backend.correlativa.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carreraSelect = document.getElementById('carrera_id');
    const anioSelect = document.getElementById('anio_id');
    const materiaSelect = document.getElementById('materia_id');
    const correlativaSelect = document.getElementById('correlativa_id');
    // URLs generadas por Blade (asegúrate de tener las rutas nombradas en web.php)
    const materiasUrl = '{{ route('api.materias') }}';
    const correlativasUrl = '{{ route('api.correlativas') }}';
    // Helper: limpia un select y coloca opción por defecto
    function resetSelect(select, placeholder = 'Seleccione la materia'){
    select.innerHTML = '';
    const opt = document.createElement('option');
    opt.value = '';
    opt.textContent = placeholder;
    select.appendChild(opt);
    }
    // Rellena un select con una lista de objetos {id, nombre}
    function fillSelect(select, items, selectedId = null){
    resetSelect(select);
    items.forEach(item => {
    const opt = document.createElement('option');
    opt.value = item.id;
    opt.textContent = item.descripcion || item.title || (item.anio ? `${item.descripcion} (${item.anio}°)` : item.descripcion);
    if(String(item.id) === String(selectedId)) opt.selected = true;
    select.appendChild(opt);
    });
    }
    // Fetch materias según carrera y anio
    async function fetchMaterias(){
        const carreraId = carreraSelect.value;
        const anio = anioSelect.value;
        // Build query string
        const params = new URLSearchParams();
        if(carreraId) params.append('carrera_id', carreraId);
        if(anio) params.append('anio_id', anio);

        try{
            const res = await fetch(`${materiasUrl}?${params.toString()}`);
            if(!res.ok) throw new Error('Error al obtener materias');
            const data = await res.json();
            // Mantener la materia seleccionada si existe (para edit)
            const currentMateria = '{{ old('materia_id', $correlativa->materia_id ?? '') }}';
            fillSelect(materiaSelect, data, currentMateria);
            // Si al cargar se tenía ya una materia seleccionada, disparar carga correlativas
            if(materiaSelect.value) await fetchCorrelativas();
        }catch(err){
            console.error(err);
            resetSelect(materiaSelect, '-- Error al cargar materias --');
        }
    }
    // Fetch correlativas según materia seleccionada
    async function fetchCorrelativas(){
    const materiaId = materiaSelect.value;
    if(!materiaId){ resetSelect(correlativaSelect); return; }

    try{
        const res = await fetch(`${correlativasUrl}?materia_id=${encodeURIComponent(materiaId)}`);
        if(!res.ok) throw new Error('Error al obtener correlativas');
        const data = await res.json();
        const currentCorrelativa = '{{ old('correlativa_id', $correlativa->correlativa_id ?? '') }}';
        fillSelect(correlativaSelect, data, currentCorrelativa);
    }catch(err){
        console.error(err);
        resetSelect(correlativaSelect, '-- Error al cargar correlativas --');
    }
    }
    // Eventos
    carreraSelect.addEventListener('change', async function(){
        await fetchMaterias();
    });
    anioSelect.addEventListener('change', async function(){
        await fetchMaterias();
    });
    materiaSelect.addEventListener('change', async function(){
        await fetchCorrelativas();
    });
    // Inicializar al cargar la página (si hay una carrera seleccionada por edit)
    (async function init(){
    // Si en el servidor ya se enviaron materias pre-cargadas (opcional), no sobreescribirlas.
    // De todas formas, hacemos fetch para garantizar actualización al cambiar filtro.
    await fetchMaterias();
    })();
});
</script>
@endsection
