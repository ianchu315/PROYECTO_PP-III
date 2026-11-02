@extends('frontend.layout.main')

@section('title', 'Mesas disponibles')

@section('content')
    <style>
        body {
            background-color: #1e1e1e;
            color: #d1d1d1;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            margin-top: 2rem;
        }

        h5.text-primary {
            color: #00bcd4;
            margin-top: 3rem;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .titulo-pagina {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #137928ff;;
            letter-spacing: 2px;
            margin-bottom: 2rem;
            margin-top: 1rem;
            border-bottom: 2px solid #0d6520ff;
            padding-bottom: 0.5rem;
        }

        .fecha-mesa {
            color: #6ac77d;;
            font-weight: 700;
            font-size: 1.2rem;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .text-carrera {
            color: #e43d3d;
            font-size: 19px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .scroll-container {
            position: relative;
            height: 600px;
            overflow-y: scroll;
            padding: 0%;
        }

        .tabla-mesas {
            width: 100%;
            font-size: 0.95rem;
            border-collapse: collapse;
            background-color: #ffffff;
            color: #111111;
            box-shadow: 0 0 10px rgba(4, 8, 0, 0.4);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .tabla-mesas thead {
            background-color: #e0e0e0;
        }

        .tabla-mesas th, .tabla-mesas td {
            padding: 12px 10px;
            vertical-align: middle;
            text-align: left;
            border-bottom: 1px solid #ccc;
            color: #111111;
        }

        .tabla-mesas th {
            font-weight: 600;
            color: #000;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .tabla-mesas td small {
            font-size: 0.85em;
        }

        hr {
            border-top: 1px solid #555;
        }

        @media (max-width: 768px) {
            .tabla-mesas {
                font-size: 0.8rem;
            }
            .tabla-mesas th, .tabla-mesas td {
                padding: 6px;
            }
            .tabla-mesas th:nth-child(2),
            .tabla-mesas td:nth-child(2) {
                width: 100%;
                display: block;
            }
            .tabla-mesas tr {
                display: block;
                margin-bottom: 1rem;
                border-bottom: 1px solid #555;
            }
            .tabla-mesas td, .tabla-mesas th {
                display: block;
                width: 100% !important;
                text-align: left !important;
            }
            .tabla-mesas thead {
                display: none;
            }
        }

        .btn-toggle {
            background-color: #2a2a2a;
            color: #ffffff;
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            border-left: 5px solid #6ac77d;
            margin-top: 0.5rem;
            font-size: 1.1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-toggle:hover {
            background-color: #333;
        }

        .btn-toggle-carrera {
            background-color: #444;
            color: #fff;
            padding: 8px 20px;
            font-weight: bold;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            border-left: 5px solid #e43d3d;
            margin-top: 0.3rem;
            font-size: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-toggle-carrera:hover {
            background-color: #555;
        }

        .flecha {
            display: inline-block;
            transition: transform 0.5s ease;
        }

        .btn-toggle.abierto .flecha,
        .btn-toggle-carrera.abierto .flecha {
            transform: rotate(180deg);
        }

        .colapsable {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.9s ease, opacity 0.7s ease;
        }

        .colapsable.activa {
            max-height: 1000px;
            opacity: 1;
        }

        .contenido-fecha {
            padding-top: 0.7rem;
            padding-left: 0.5rem;
            border-left: 2px dashed #65AA75
        }

        .toggle-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .toggle-switch {
            width: 200px;
            height: 45px;
            background-color: #2a2a2a;
            border-radius: 30px;
            position: relative;
            display: block;
            overflow: hidden;
            text-decoration: none;
        }
        .toggle-switch:hover {
            width: 200px;
            height: 45px;
            background-color: #555;
            border-radius: 30px;
            position: relative;
            display: block;
            overflow: hidden;
            text-decoration: none;
        }

        .toggle-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 95px;
            height: 39px;
            background-color: #065417ff;
            border-radius: 25px;
            color: #fff;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s ease;
        }

        .toggle-slider:hover {
            background-color: #65e180ff;
        }

        .toggle-slider.right {
            left: 102px;
            background-color: #881010ff;
        }

        .toggle-slider.right:hover {
            left: 102px;
            background-color: #f26d6dff;
        }

        .toggle-option {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #fff; /* color por defecto (cuando NO está seleccionado) */
            z-index: 2;
            pointer-events: none; /* para que no interfiera con el click */
            transition: color 0.3s ease;
        }

        .toggle-option.izquierda { left: 0; }
        .toggle-option.derecha { right: 0; }

        .toggle-option.activo {
            color: #fff; /* cuando está seleccionado */
        }

    </style>

    <div class="container">
        <div class="titulo-pagina">
            MESAS FINALES
        </div>

        {{-- Botones de orden --}}
        <div class="text-center mb-4">

            <div class="toggle-wrapper">
                <a href="{{ route('frontend.mesas.index', ['orden' => $modo === 'fecha' ? 'carrera' : 'fecha']) }}" class="toggle-switch">
                    <span class="toggle-option izquierda {{ $modo === 'fecha' ? 'activo' : '' }}">FECHA</span>
                    <span class="toggle-option derecha {{ $modo === 'carrera' ? 'activo' : '' }}">CARRERA</span>
                    <div class="toggle-slider {{ $modo === 'carrera' ? 'right' : 'left' }}"></div>
                </a>
            </div>


        </div>

        {{-- Si está deshabilitado en la config --}}
        @if(!$mostrar)
            <div class="text-center mt-4">
                <h4>LAS MESAS AÚN NO ESTAN DISPONIBLES</h4>
            </div>
        @else
            {{-- Vista por FECHA --}}
            @if($modo === 'fecha')
                @foreach($mesas as $fecha => $mesasPorFecha)
                    @php
                        // Agrupar las mesas por carrera
                        $mesasPorCarrera = $mesasPorFecha->groupBy('carrera.descripcion');
                        $fechaID = 'fecha-' . \Illuminate\Support\Str::slug($fecha);
                    @endphp

                    <!-- Botón de FECHA -->
                    <button class="btn-toggle-carrera" style="border-left: 5px solid #51875D;" data-target="#{{ $fechaID }}">
                        <span>FECHA: {{ mb_strtoupper(\Carbon\Carbon::parse($fecha)->translatedFormat('l d/m')) }}</span>
                        <span class="flecha">&#9660;</span>
                    </button>

                    <!-- Contenido de la fecha -->
                    <div id="{{ $fechaID }}" class="colapsable contenido-carrera">
                        @foreach($mesasPorCarrera as $carrera => $mesasCarrera)
                            @php
                                // Agrupar las mesas de esa carrera por comisión
                                $mesasPorComision = $mesasCarrera->groupBy('comision');
                                $carreraID = $fechaID . '-carrera-' . \Illuminate\Support\Str::slug($carrera);
                            @endphp

                            <!-- Botón de CARRERA -->
                            <button class="btn-toggle" style="border-left: 5px solid #AC2323;" data-target="#{{ $carreraID }}">
                                <span>CARRERA: {{ strtoupper($carrera) }}</span>
                                <span class="flecha">&#9660;</span>
                            </button>

                            <!-- Contenido de la carrera -->
                            <div id="{{ $carreraID }}" class="colapsable contenido-fecha">
                                @foreach($mesasPorComision as $comision => $mesasComision)
                                    @php
                                        $comisionID = $carreraID . '-comision-' . \Illuminate\Support\Str::slug($comision ?? 'sin-comision');
                                    @endphp

                                    <!-- Botón de COMISIÓN -->
                                    <button class="btn-toggle" style="border-left: 5px solid #51875D;" data-target="#{{ $comisionID }}">
                                        <span>COMISIÓN: {{ strtoupper($comision) }}</span>
                                        <span class="flecha">&#9660;</span>
                                    </button>

                                    <!-- Contenido de la comisión -->
                                    <div id="{{ $comisionID }}" class="colapsable contenido-fecha">
                                        <table class="tabla-mesas">
                                            <thead>
                                                <tr>
                                                    <th>MATERIA<br>(Inscriptos)</th>
                                                    <th>PRESIDENTE</th>
                                                    <th>VOCAL</th>
                                                    <th>SALÓN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($mesasComision->sortBy('materia.curso') as $mesa)
                                                    <tr>
                                                        <td>
                                                            {{ $mesa->materia->descripcion }}
                                                            @if($mesa->inscriptos)
                                                                <br><small class="text-danger">({{ $mesa->inscriptos }})</small>
                                                            @endif
                                                            @if($mesa->resolucion)
                                                                <br><small class="text-success">{{ $mesa->resolucion->resolucion ?? '-'}}</small>
                                                            @endif
                                                        </td>
                                                        <td class="text-success">{{ $mesa->profesor->apellido ?? '-' }}, {{ $mesa->profesor->nombre ?? '-' }}</td>
                                                        <td class="text-success">{{ $mesa->vocal->apellido ?? '-' }}, {{ $mesa->vocal->nombre ?? '-' }}</td>
                                                        <td>
                                                            {{ $mesa->Salon->numero_salon ?? '-' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            


            {{-- Vista por CARRERA CON COMISIONES --}}
            @else
                @foreach($mesas as $carrera => $comisiones)
                    @php
                        $carreraID = 'carrera-' . \Illuminate\Support\Str::slug($carrera);
                    @endphp

                    <!-- Botón de carrera -->
                    <button class="btn-toggle-carrera" data-target="#{{ $carreraID }}">
                        <span>CARRERA: {{ strtoupper($carrera) }}</span>
                        <span class="flecha">&#9660;</span>
                    </button>

                    <!-- Contenido de carreras -->
                    <div id="{{ $carreraID }}" class="colapsable contenido-carrera">
                        @foreach($comisiones as $comision => $anios)
                            @php
                                $comisionID = $carreraID . '-comision-' . \Illuminate\Support\Str::slug($comision);
                            @endphp

                            <!-- Botón de comisión -->
                            <button class="btn-toggle" style="border-left: 5px solid #51875D;" data-target="#{{ $comisionID }}">
                                <span>COMISIÓN: {{ strtoupper($comision) }}</span>
                                <span class="flecha">&#9660;</span>
                            </button>

                            <!-- Contenido de comisiones -->
                            <div id="{{ $comisionID }}" class="colapsable contenido-fecha">
                                @foreach($anios as $anio => $mesasAnio)
                                    @php
                                        $anioID = $comisionID . '-anio-' . $anio;
                                    @endphp

                                    <!-- Botón de año -->
                                    <button class="btn-toggle" style="margin-left: 1rem;" data-target="#{{ $anioID }}">
                                        <span>AÑO: {{ is_numeric($anio) ? $anio . 'º' : $anio }}</span>
                                        <span class="flecha">&#9660;</span>
                                    </button>

                                    <div id="{{ $anioID }}" class="colapsable contenido-fecha">
                                        <div class="scroll-container" data-bs-spy="scroll" data-bs-target="#navbar-example" data-bs-smooth-scroll="true" tabindex="0">
                                            <table class="tabla-mesas">
                                                <thead>
                                                    <tr>
                                                        <th>FECHA</th>
                                                        <th>MATERIA</th>
                                                        <th>PRESIDENTE</th>
                                                        <th>VOCAL</th>
                                                        <th>SALÓN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($mesasAnio->sortBy('fecha') as $mesa)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($mesa->fecha)->format('d/m/Y') }}</td>
                                                            <td>
                                                                {{ $mesa->materia->descripcion }}
                                                                @if($mesa->inscriptos)
                                                                    <br><small class="text-danger">({{ $mesa->inscriptos }})</small>
                                                                @endif
                                                                @if($mesa->resolucion)
                                                                    <br><small class="text-success">{{ $mesa->resolucion->resolucion ?? '-'}}</small>
                                                                @endif
                                                            </td>
                                                            <td>{{ $mesa->profesor->apellido ?? '-' }}, {{ $mesa->profesor->nombre ?? '-' }}</td>
                                                            <td>{{ $mesa->vocal->apellido ?? '-' }}, {{ $mesa->vocal->nombre ?? '-' }}</td>
                                                            <td>
                                                                {{ $mesa->Salon->numero_salon ?? 'Sin salón' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                        
                                        
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif


            
        @endif

        <hr>

        <div class="text-center mb-4">
            <button class="btn btn-success px-4 py-2" data-bs-toggle="modal" data-bs-target="#mapaModal">
                🗺️ Ver mapa del piso
            </button>
        </div>

        {{-- Modal del mapa --}}
        <div class="modal fade" id="mapaModal" tabindex="-1" aria-labelledby="mapaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="mapaModalLabel">Mapa del Piso 2</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('img/plano_piso2.png') }}" alt="Mapa del Piso 2" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
        </div>
    </div>

    <script>
    function configurarAcordeon(selectorBoton, obtenerGrupo) {
        document.querySelectorAll(selectorBoton).forEach(btn => {
            btn.addEventListener('click', function () {
                const target = document.querySelector(this.dataset.target);
                const grupo = obtenerGrupo(this); // Obtiene el contenedor padre (el "grupo")
                
                if (!grupo) return;

                const isActive = target.classList.contains('activa');

                // 1. Cerrar TODOS los elementos del MISMO NIVEL dentro de ese GRUPO
                grupo.querySelectorAll(selectorBoton).forEach(b => {
                    // Importante: Nos aseguramos de que el botón b no sea un hijo de un nivel inferior.
                    // Usaremos b.parentElement para verificar que está directamente en el 'grupo'
                    // Esto es crucial para los niveles anidados.
                    
                    // Si el botón está *directamente* dentro del grupo...
                    if (b.parentElement === grupo) {
                        const t = document.querySelector(b.dataset.target);
                        if (t) {
                            t.classList.remove('activa');
                            b.classList.remove('abierto');
                        }
                    }
                });

                // 2. Abrir solo si estaba cerrado
                if (!isActive) {
                    target.classList.add('activa');
                    this.classList.add('abierto');
                }
            });
        });
    }

    // ----------------------------------------------------------------------
    // CONFIGURACIÓN MEJORADA
    // ----------------------------------------------------------------------

    // NIVEL 1: CARRERA (o Fecha en el modo 'fecha')
    // Selector: .btn-toggle-carrera
    // Grupo: .container (o el cuerpo completo, ya que son elementos de primer nivel)
    configurarAcordeon(
        '.btn-toggle-carrera',
        (btn) => btn.closest('.container')
    );

    // NIVEL 2: COMISIÓN (en modo 'carrera') o CARRERA (en modo 'fecha')
    // Selector: .btn-toggle (sin margen, borde verde)
    // Grupo: El contenido de la carrera/fecha colapsada que lo contiene (.colapsable.contenido-carrera)
    configurarAcordeon(
        '.btn-toggle:not([style*="margin-left: 1rem"])', // Selecciona solo los .btn-toggle que NO tienen el margen (i.e., las comisiones)
        (btn) => btn.closest('.colapsable') // El padre colapsable es el contenedor de la carrera/fecha
    );

    // NIVEL 3: AÑO
    // Selector: .btn-toggle (con margen de 1rem)
    // Grupo: El contenido de la comisión colapsada que lo contiene
    configurarAcordeon(
        '.btn-toggle[style*="margin-left: 1rem"]', // Selecciona solo los .btn-toggle que tienen el margen (i.e., los años)
        (btn) => btn.closest('.colapsable') // El padre colapsable es el contenedor de la comisión
    );
    </script>

    <script>
        // Mostrar/ocultar el botón del mapa según el switch
        document.addEventListener('DOMContentLoaded', function () {
            const switchMapa = document.getElementById('mostrarMapaSwitch');
            const btnMapa = document.getElementById('mapaBtnContainer');

            switchMapa.addEventListener('change', function () {
                btnMapa.style.display = this.checked ? 'block' : 'none';
            });
        });
    </script>



@endsection
