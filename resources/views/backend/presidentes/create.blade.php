@extends('backend.layouts.main')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col sm col-1">
                <div class="mt-2">
                    <a href="{{ route('presidentes.index') }}" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#8a2be2" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                            <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="col col-11">
                <div class="d-flex justify-content-center mt-3">  
                    <form action="{{ route('presidentes.store') }}" method="POST" class="form">

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
                        
                        @csrf
                        @method('POST')
                            <label for="nombre">Nombre</label>
                            <select name="nombre_id" id="nombre" class="form-select" required>
                                <option value="" disabled selected>-- Elija un nombre --</option>
                                @foreach($profesors as $profesor)
                                    <option value="{{ $profesor->id }}">{{ $profesor->nombre }}</option>
                                @endforeach
                            </select>

                        <br><br>

                        <!-- Muestra el campo de seleccion de appellidos-->
                            <label for="apellido">Apellido</label>
                            <select name="apellido_id" id="apellido" class="form-select" required>
                                <option value="" disabled selected>-- Elija un apellido --</option>
                                @foreach($profesors as $profesor)
                                    <option value="{{ $profesor->id }}">{{ $profesor->apellido }}</option>
                                @endforeach
                            </select>
                        
                        <br><br>
                        
                        <!-- Muestra el campo de seleccion de carreras-->                     
                            <label for="carrera">Carrera</label>
                            <select name="carrera_id" id="carrera" class="form-select" required>
                                <option value="" disabled selected>-- Elija una carrera --</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}">{{ $carrera->descripcion ?? 'sin Carrera' }}</option>
                                @endforeach
                            </select>

                        <br><br>

                        <!-- Muestra el campo de seleccion de materias-->
                            <label for="materia">Materia</label>
                            <select name="materia_id" id="materia" class="form-select" required>
                                <option value="" disabled selected>-- Elija una materia --</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}">{{ $materia->descripcion }}</option>
                                @endforeach
                            </select>

                        <br><br>

                        <label for="horario">Horario</label>
                        <input type="time" id="horario" name="horario" required>
                        
                        <br><br>

                        <input type="submit" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
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