@extends('backend.layouts.main')
@section('title', 'Editar Mesas')
@section('content')

    <h2 class="text-center mb-4">Editar Mesa</h2>
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
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border border-0 shadow-sm rounded">
                <div class="card-body p-4">
                    <form action="{{ route('mesas.update', ['mesa' => $mesa->id] + request()->query()) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="page" value="{{ request('page') }}">
                        <div class="mb-3">
                            <label for="carrera" class="form-label fw-bold">Carrera</label>
                            <select name="carrera_id" id="carrera" class="form-select" >
                                @foreach($carreras as $carrera)
                                    @if($mesa->carrera_id == $carrera->id)
                                        <option value="{{ $carrera->id }}" selected>
                                            {{ $carrera->descripcion }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="anio_id" class="form-label fw-bold">Año</label>
                            <select name="anio_id" id="anio_id" class="form-control" >
                                @for ($i = 1; $i <= 3; $i++)
                                    @if($mesa->anio_id == $i)
                                        <option value="{{ $i }}" selected>{{ $i }}</option>
                                    @endif      
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="materia" class="form-label fw-bold">Materia</label>
                            <select name="materia_id" id="materia" class="form-select" >
                                {{-- Las opciones se llenan por JS --}}
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 mb-3">
                                <label for="profesor_id" class="form-label fw-bold">Presidente</label>
                                <select name="profesor_id" id="mi-select" class="form-select mselect">
                                    @foreach($profesors as $prof)
                                        <option value="{{ $prof->id }}" {{ $mesa->profesor_id == $prof->id ? 'selected' : '' }}>
                                            {{ $prof->nombre }} {{ $prof->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="vocal_id" class="form-label fw-bold">Vocal</label>
                                <select name="vocal_id" id="vocal" class="form-select mselect">
                                    @foreach($profesors as $prof)
                                        <option value="{{ $prof->id }}" {{ $mesa->vocal_id == $prof->id ? 'selected' : '' }}>
                                            {{ $prof->nombre }} {{ $prof->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label fw-bold">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $mesa->fecha }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="horario" class="form-label fw-bold">Horario</label>
                                <input type="time" name="horario" id="horario" class="form-control" value="{{ $mesa->horario }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comision" class="form-label fw-bold">Comisión</label>
                            <input type="text" 
                                name="comision"
                                id="comision"
                                class="form-control"
                                value="{{ $mesa->comision }}"
                                readonly>
                        </div>
                        <!--Inscriptos-->
                        <div class="mb-3">
                            <label for="inscriptos" class="form-label fw-bold">Cantidad de Inscriptos</label>
                            <input type="number" name="inscriptos" id="inscriptos" class="form-control" value="{{ $mesa->inscriptos }}">
                        </div>
                        <!--Resolucion-->
                        <div class="mb-3">
                            <label for="resolucion_id" class="form-label fw-bold">Resolución</label>
                            <select name="resolucion_id" id="resolucion_id" class="form-select">
                                <option value="">Sin resolución</option>
                                @foreach($resoluciones as $resolucion)
                                    <option value="{{ $resolucion->id }}" {{ $mesa->resolucion_id == $resolucion->id ? 'selected' : '' }}>
                                        {{ $resolucion->resolucion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="salon_id" class="form-label fw-bold">Salón</label>
                            <select name="salon_id" id="salon_id" class="form-select mselect">
                                <option value="">Seleccione un salón</option>
                                @foreach($salones as $salon)
                                    <option value="{{ $salon->id }}" {{ $mesa->salon_id == $salon->id ? 'selected' : '' }}>
                                        {{ $salon->numero_salon }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @foreach(['carrera_id','anio_id','materia_id','profesor_id','vocal_id','fecha','comision', 'Salon_id'] as $filtro)
                            <input type="hidden" name="filtro_{{ $filtro }}" value="{{ request($filtro) }}">
                        @endforeach 
                        <a href="{{ route('mesas.index', request()->query()) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-primary float-end">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    const materias = @json($materias);
    const mesa = @json($mesa->materia_id);

    const carreraSelect = document.getElementById('carrera');
    const anioSelect = document.getElementById('anio_id');
    const materiaSelect = document.getElementById('materia');

    function filtrarMaterias() {
        const carreraId = carreraSelect.value;
        const anioId = anioSelect.value;

        const filtradas = materias.filter(m =>
            m.carrera_id == carreraId && m.anio_id == anioId
        );

        materiaSelect.innerHTML = ''; // Limpiar

        filtradas.forEach(m => {
            if(m.id == mesa ){
                const option = document.createElement('option');
                option.value = m.id;
                option.textContent = m.descripcion;
                materiaSelect.appendChild(option);
            }
        });
    }

    // Ejecutar cuando cambian carrera o año
    carreraSelect.addEventListener('change', filtrarMaterias);
    anioSelect.addEventListener('change', filtrarMaterias);

    // Al cargar la página (para que respete valores preseleccionados)
    window.addEventListener('DOMContentLoaded', filtrarMaterias);
</script>
<script>
    $(document).ready(function() {
        $('#mi-select').select2({
        placeholder: "Seleccione un profesor",
        theme: 'default',
        allowClear: true,
        width: '100%'
        });
    });
    $(document).ready(function() {
        $('#vocal').select2({
        placeholder: "Seleccione un vocal",
        theme: 'default',
        allowClear: true,
        width: '100%'
        });
    });
</script>
<!--estilos para los select2-->
<style>
    .mselect + .select2 .select2-selection {
        background-color: #ffffff !important;
        border: 1px solid #dee2e6 !important;
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
    /* Cambiar color del dropdown */
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
    .select2-selection--single .select2-selection__arrow b {
        border-color: #212529 transparent transparent transparent !important;
        border-style: solid !important;
    }
</style>
@endsection