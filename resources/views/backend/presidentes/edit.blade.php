@extends('backend.layouts.main')

@section('content')

    
    
<div class="container mt-4">
    <form action="{{ route('presidentes.update', $presidente->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Este if muestra un aviso de error en caso de que se repita el valor del campo "Materia" o en caso de que algun campo sea seleccionado-->
                    
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

        <!-- Muestra el campo de seleccion de los nombres-->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <select name="nombre_id" id="nombre" class="form-select">
                <option value="" disabled selected>-- Elija una nombre --</option>
                    @foreach($profesors as $profesor)
                        <option value="{{ $profesor->id }}" {{ $profesor->id == $presidente->nombre_id ? 'selected' : '' }}>
                            {{ $profesor->nombre }}
                        </option>
                    @endforeach
            </select>
        </div>

        <!-- Muestra el campo de seleccion de appellidos-->
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <select name="apellido_id" id="apellido" class="form-select">
                <option value="" disabled selected>-- Elija un apellido --</option>    
                    @foreach($profesors as $profesor)
                        <option value="{{ $profesor->id }}" {{ $profesor->id == $presidente->apellido_id ? 'selected' : '' }}>
                            {{ $profesor->apellido }}
                        </option>
                    @endforeach
            </select>
        </div>

        <!-- Muestra el campo de seleccion de carreras-->   
        <div>
            <label for="materia" class="form-label">Carrera</label>
            <select name="carrera_id" id="carrera" class="form-select" required>
                <option value="" disabled selected>-- Elija una carrera --</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->descripcion ?? 'sin Carrera' }}</option>
                    @endforeach
            </select>
        </div>

        <!-- Muestra el campo de seleccion de materias-->
        <div class="mb-3">
            <label for="materia" class="form-label">Materia</label>
            <select name="materia_id" id="materia" class="form-select">
                <option value="" disabled selected>-- Elija una materia --</option>
                    @foreach($materias as $materia)
                        <option value="{{ $materia->id }}" {{ $materia->id == $presidente->materia_id ? 'selected' : '' }}>
                            {{ $materia->descripcion }}
                        </option>
                    @endforeach
            </select>
        </div>

        
        <div class="mb-3">
            <label for="horario" class="form-label">Horario</label>
            <input type="time" id="horario" name="horario" class="form-control" value="{{ $presidente->horario }}">
        </div>

        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
</div>

<!-- Script para que al seleccionar el Nombre o Apellido del profesor se asocie al correspondente-->
<script>
    document.getElementById('nombre').addEventListener('change', function () {
        let valor = this.value;
        let apellido = document.getElementById('apellido');

        // Buscar y seleccionar la opción en el segundo select que coincida
        for (let option of apellido.options) {
            option.selected = option.value === valor;
        }
    });

    document.getElementById('apellido').addEventListener('change', function () {
            let valor = this.value;
            let nombre = document.getElementById('nombre');

            // Buscar y seleccionar la opción en el segundo select que coincida
            for (let option of nombre.options) {
                option.selected = option.value === valor;
            }
    });


        //Hace que al seleccionar una carrera muestre todas las materias
        const materias = @json($materias);

        document.getElementById('carrera').addEventListener('change', function () {
            const carreraId = this.value;
            const materiaSelect = document.getElementById('materia');

            const filtrados = materias.filter(p => p.carrera_id == carreraId);

            materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';

            filtrados.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.textContent = p.descripcion;
                materiaSelect.appendChild(option);
            });
        });
</script>
@endsection
