{{-- Reemplaza, para el superadministrador, la tarjeta de bienvenida por un
     panel de 2 secciones: asignación de carrera/materias/vocal a
     profesores, y el listado de usuarios (lista de espera + activos +
     inactivos) que antes vivía en un popup flotante. Cada sección tiene su
     propio scroll si el contenido no entra. --}}
<div class="pa-wrap">

    {{-- ================= SECCIÓN 1: PROFESORES ================= --}}
    <div class="pa-seccion">
        <h3 class="pa-titulo">Profesores — asignar carrera, materias y vocal de mesa</h3>

        <form action="{{ route('bolsadetrabajo.panel') }}" method="GET" class="pa-buscador">
            <input type="text" name="buscar_profesor" value="{{ $buscarProfesor }}"
                   placeholder="Buscar profesor por nombre, apellido o email...">
            <button type="submit" class="btn btn-secondary btn-sm">Buscar</button>
            @if($buscarProfesor !== '')
                <a href="{{ route('bolsadetrabajo.panel') }}" class="pa-limpiar">Limpiar</a>
            @endif
        </form>

        <div class="pa-scroll">
            @if($profesores->isEmpty())
                <p class="pa-vacio">
                    @if($buscarProfesor !== '')
                        No se encontró ningún profesor para "{{ $buscarProfesor }}".
                    @else
                        No hay profesores aprobados todavía.
                    @endif
                </p>
            @else
                @foreach($profesores as $profesor)
                    @php
                        $carrerasDelProfesor = $profesor->carrerasHabilitadas;
                        $materiasDeSusCarreras = $carrerasDelProfesor->flatMap(function ($carrera) use ($materiasPorCarrera) {
                            return $materiasPorCarrera->get($carrera->id, collect());
                        });
                    @endphp
                    <div class="pa-profesor">
                        <details class="pa-acordeon">
                        <summary class="pa-profesor-nombre">
                            {{ $profesor->apellido }}, {{ $profesor->nombre }}
                            <span class="pa-profesor-email">{{ $profesor->email }}</span>
                        </summary>
                        <div class="pa-acordeon-contenido"><div class="pa-acordeon-inner">

                        <form action="{{ route('bolsadetrabajo.admin.usuarios.carreras', $profesor) }}" method="POST" class="pa-form-materias">
                            @csrf
                            <label>Carreras habilitadas</label>
                            <div class="pa-materias-lista">
                                @foreach($carreras as $carrera)
                                    <label class="pa-materia-fila">
                                        <span class="pa-materia-nombre">{{ $carrera->descripcion }}</span>
                                        <span class="pa-materia-check">
                                            <input type="checkbox" name="carreras[]" value="{{ $carrera->id }}"
                                                   {{ $carrerasDelProfesor->contains('id', $carrera->id) ? 'checked' : '' }}>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-secondary btn-sm">Guardar carreras</button>
                        </form>

                        {{-- Materias de todas las carreras habilitadas --}}
                        @if($carrerasDelProfesor->isNotEmpty())
                            <form action="{{ route('bolsadetrabajo.admin.profesores.materias', $profesor) }}" method="POST" class="pa-form-materias">
                                @csrf
                                <label>Materias de sus carreras</label>

                                @if($materiasDeSusCarreras->isEmpty())
                                    <p class="pa-vacio">Sus carreras todavía no tienen materias cargadas.</p>
                                @else
                                    <div class="pa-materias-lista">
                                        <div class="pa-materia-header">
                                            <span class="pa-materia-header-nombre"></span>
                                            <span class="pa-materia-header-check">Titular</span>
                                            <span class="pa-materia-header-check">Vocal</span>
                                        </div>
                                        @foreach($carrerasDelProfesor as $carrera)
                                            <div class="pa-materia-fila">
                                                <strong class="pa-materia-nombre">{{ $carrera->descripcion }}</strong>
                                                <span></span><span></span>
                                            </div>
                                            @foreach($materiasPorCarrera->get($carrera->id, collect()) as $materia)
                                                <div class="pa-materia-fila">
                                                    <span class="pa-materia-nombre">
                                                        {{ $materia->descripcion }}
                                                        @if($materia->profesor_usuario_id && $materia->profesor_usuario_id != $profesor->id)
                                                            <span class="pa-materia-ocupada">(titular: otro profesor)</span>
                                                        @endif
                                                        @if($materia->vocal_usuario_id && $materia->vocal_usuario_id != $profesor->id)
                                                            <span class="pa-materia-ocupada">(vocal: otro profesor)</span>
                                                        @endif
                                                    </span>
                                                    <span class="pa-materia-check">
                                                        <input type="checkbox" name="materias[]" value="{{ $materia->id }}"
                                                               {{ $materia->profesor_usuario_id == $profesor->id ? 'checked' : '' }}>
                                                    </span>
                                                    <span class="pa-materia-check">
                                                        <input type="checkbox" name="vocal_materias[]" value="{{ $materia->id }}"
                                                               {{ $materia->vocal_usuario_id == $profesor->id ? 'checked' : '' }}>
                                                    </span>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Guardar materias</button>
                                @endif
                            </form>
                        @else
                            <p class="pa-vacio">Asignale al menos una carrera para poder elegir materias.</p>
                        @endif
                        </div></div>
                        </details>
                    </div>
                @endforeach

                <div class="pa-paginacion">
                    {{ $profesores->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ================= SECCIÓN 2: PRECEPTORES ================= --}}
    <div class="pa-seccion">
        <h3 class="pa-titulo">Preceptores — asignar carreras</h3>

        <form action="{{ route('bolsadetrabajo.panel') }}" method="GET" class="pa-buscador">
            <input type="text" name="buscar_preceptor" value="{{ $buscarPreceptor }}"
                   placeholder="Buscar preceptor por nombre, apellido o email...">
            <button type="submit" class="btn btn-secondary btn-sm">Buscar</button>
            @if($buscarPreceptor !== '')
                <a href="{{ route('bolsadetrabajo.panel') }}" class="pa-limpiar">Limpiar</a>
            @endif
        </form>

        <div class="pa-scroll">
            @if($preceptores->isEmpty())
                <p class="pa-vacio">No hay preceptores aprobados para mostrar.</p>
            @else
                @foreach($preceptores as $preceptor)
                    <div class="pa-profesor">
                        <details class="pa-acordeon">
                        <summary class="pa-profesor-nombre">
                            {{ $preceptor->apellido }}, {{ $preceptor->nombre }}
                            <span class="pa-profesor-email">{{ $preceptor->email }}</span>
                        </summary>
                        <div class="pa-acordeon-contenido"><div class="pa-acordeon-inner">
                        <form action="{{ route('bolsadetrabajo.admin.profesores.preceptores.carreras', $preceptor) }}" method="POST" class="pa-form-materias">
                            @csrf
                            <label>Carreras asignadas</label>
                            <div class="pa-materias-lista">
                                @foreach($carreras as $carrera)
                                    <label class="pa-materia-fila">
                                        <span class="pa-materia-nombre">{{ $carrera->descripcion }}</span>
                                        <span class="pa-materia-check">
                                            <input type="checkbox" name="carreras[]" value="{{ $carrera->id }}"
                                                   {{ $preceptor->carrerasAsignadas->contains('id', $carrera->id) ? 'checked' : '' }}>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Guardar carreras</button>
                        </form>
                        </div></div>
                        </details>
                    </div>
                @endforeach

                <div class="pa-paginacion">
                    {{ $preceptores->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ================= SECCIÓN 2: USUARIOS ================= --}}
    <div class="pa-seccion">
        <h3 class="pa-titulo">
            Usuarios
        </h3>

        <div class="pa-scroll">
            <h4 class="pa-subtitulo">Lista de espera <span class="pa-contador">{{ $usuariosPendientes->count() }}</span></h4>

            @if($usuariosPendientes->isEmpty())
                <p class="pa-vacio">No hay usuarios pendientes.</p>
            @else
                @foreach($usuariosPendientes as $usuarioPendiente)
                    <div class="pa-item">
                        <details class="pa-acordeon">
                        <summary class="pa-item-datos">
                            <strong>{{ $usuarioPendiente->nombre }} {{ $usuarioPendiente->apellido }}</strong>
                            <span>{{ $usuarioPendiente->email }}</span>
                            <span class="pa-item-carrera">{{ $usuarioPendiente->carrera->descripcion ?? 'Sin carrera' }}</span>
                        </summary>
                        <div class="pa-acordeon-contenido"><div class="pa-acordeon-inner">
                        <div class="pa-item-acciones">
                            <form action="{{ route('admin.aprobacion.approve', $usuarioPendiente->id) }}" method="POST" class="pa-form-aprobar">
                                @csrf
                                <input type="hidden" name="volver" value="{{ url()->current() }}">
                                <button class="btn btn-primary btn-sm" type="submit" name="rol" value="usuario">Aprobar como Alumno</button>
                                <button class="btn btn-secondary btn-sm" type="submit" name="rol" value="profesor">Aprobar como Profesor</button>
                                <button class="btn btn-secondary btn-sm" type="submit" name="rol" value="preceptor">Aprobar como Preceptor</button>
                            </form>
                            <form action="{{ route('admin.aprobacion.reject', $usuarioPendiente->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="volver" value="{{ url()->current() }}">
                                <button class="btn btn-danger btn-sm" type="submit">Rechazar</button>
                            </form>
                        </div>
                        </div></div>
                        </details>
                    </div>
                @endforeach
            @endif

            <h4 class="pa-subtitulo" style="margin-top:18px;">Usuarios activos (alumnos) <span class="pa-contador">{{ $usuariosActivos->total() }}</span></h4>

            <form action="{{ route('bolsadetrabajo.panel') }}" method="GET" class="pa-buscador">
                <input type="text" name="buscar_alumno" value="{{ $buscarAlumno }}"
                       placeholder="Buscar alumno por nombre, apellido o email...">
                <button type="submit" class="btn btn-secondary btn-sm">Buscar</button>
                @if($buscarAlumno !== '')
                    <a href="{{ route('bolsadetrabajo.panel') }}" class="pa-limpiar">Limpiar</a>
                @endif
            </form>

            @if($usuariosActivos->isEmpty())
                <p class="pa-vacio">
                    @if($buscarAlumno !== '')
                        No se encontró ningún alumno para "{{ $buscarAlumno }}".
                    @else
                        No hay alumnos activos.
                    @endif
                </p>
            @else
                @foreach($usuariosActivos as $usuarioActivo)
                    <div class="pa-item">
                        <details class="pa-acordeon">
                        <summary class="pa-item-datos">
                            <strong>{{ $usuarioActivo->nombre }} {{ $usuarioActivo->apellido }}</strong>
                            <span>{{ $usuarioActivo->email }}</span>
                            <span class="pa-item-carrera">Alumno</span>
                        </summary>
                        <div class="pa-acordeon-contenido"><div class="pa-acordeon-inner">
                        <div class="pa-item-acciones">
                            <form action="{{ route('bolsadetrabajo.admin.usuarios.carreras', $usuarioActivo) }}" method="POST" class="pa-form-materias">
                                @csrf
                                <label>Carreras habilitadas</label>
                                <div class="pa-materias-lista">
                                    @foreach($carreras as $carrera)
                                        <label class="pa-materia-fila">
                                            <span class="pa-materia-nombre">{{ $carrera->descripcion }}</span>
                                            <span class="pa-materia-check">
                                                <input type="checkbox" name="carreras[]" value="{{ $carrera->id }}"
                                                       {{ $usuarioActivo->carrerasHabilitadas->contains('id', $carrera->id) ? 'checked' : '' }}>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                <button class="btn btn-secondary btn-sm" type="submit">Guardar carreras</button>
                            </form>
                            <form action="{{ route('bolsadetrabajo.admin.usuarios.dar-de-baja', $usuarioActivo->id) }}" method="POST"
                                  onsubmit="return confirm('¿Dar de baja a {{ $usuarioActivo->nombre }} {{ $usuarioActivo->apellido }}? No va a poder iniciar sesión, pero sus datos quedan guardados.');">
                                @csrf
                                <button class="btn btn-danger btn-sm" type="submit">Dar de baja</button>
                            </form>
                        </div>
                        </div></div>
                        </details>
                    </div>
                @endforeach

                <div class="pa-paginacion">
                    {{ $usuariosActivos->links() }}
                </div>
            @endif

            <h4 class="pa-subtitulo" style="margin-top:18px;">Usuarios dados de baja <span class="pa-contador">{{ $usuariosInactivos->count() }}</span></h4>

            @if($usuariosInactivos->isEmpty())
                <p class="pa-vacio">No hay usuarios dados de baja.</p>
            @else
                @foreach($usuariosInactivos as $usuarioInactivo)
                    <div class="pa-item pa-item-inactivo">
                        <div class="pa-item-datos">
                            <strong>{{ $usuarioInactivo->nombre }} {{ $usuarioInactivo->apellido }}</strong>
                            <span>{{ $usuarioInactivo->email }}</span>
                            <span class="pa-item-carrera">{{ ucfirst($usuarioInactivo->rol === 'usuario' ? 'alumno' : $usuarioInactivo->rol) }}</span>
                        </div>
                        <div class="pa-item-acciones">
                            <form action="{{ route('bolsadetrabajo.admin.usuarios.reactivar', $usuarioInactivo->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-primary btn-sm" type="submit">Reactivar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

<style>
    .pf-page.pf-page-amplio {
        width: 100%;
        max-width: 1600px;
        box-sizing: border-box;
    }

    #panel-navbar.panel-navbar-amplio {
        width: 100%;
        max-width: 1600px;
        box-sizing: border-box;
    }

    .pa-wrap {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        align-items: stretch;
        gap: 14px;
    }

    .pa-seccion {
        background: #fff;
        border: 1px solid #eaeae9;
        border-radius: 15px;
        padding: 14px;
        display: flex;
        flex-direction: column;
        height: min(720px, calc(100vh - 170px));
        min-height: 420px;
        min-width: 0;
    }

    .pa-titulo {
        margin: 0 0 12px 0;
        font-size: 15px;
        color: #700101;
        border-bottom: 1px solid #eee;
        padding-bottom: 8px;
    }

    .pa-subtitulo {
        font-size: 13.5px;
        color: #700101;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pa-contador {
        background: #700101;
        color: #fff;
        font-size: 11px;
        border-radius: 10px;
        padding: 1px 8px;
    }

    .pa-buscador {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-bottom: 12px;
        flex-wrap: wrap;
        min-width: 0;
    }

    .pa-buscador input[type="text"] {
        flex: 1 1 140px;
        min-width: 0;
        width: 100%;
        box-sizing: border-box;
        padding: 7px 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-family: "Overpass", sans-serif;
        font-size: 12.5px;
    }

    .pa-limpiar {
        font-size: 12px;
        color: #700101;
        text-decoration: underline;
        white-space: nowrap;
    }

    .pa-scroll {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding-right: 6px;
    }

    .pa-vacio {
        color: #8a8a88;
        font-size: 13px;
        margin: 6px 0;
    }

    .pa-profesor {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 12px;
    }

    .pa-acordeon > summary {
        list-style: none;
        cursor: pointer;
        position: relative;
        padding-right: 28px;
    }

    .pa-acordeon > summary::-webkit-details-marker {
        display: none;
    }

    .pa-acordeon > summary::after {
        content: "";
        position: absolute;
        right: 5px;
        top: 5px;
        width: 8px;
        height: 8px;
        border-right: 2px solid #700101;
        border-bottom: 2px solid #700101;
        transform: rotate(45deg);
        transition: transform 320ms cubic-bezier(0.22, 1, 0.36, 1);
    }

    .pa-acordeon[open] > summary::after {
        transform: rotate(225deg);
    }

    .pa-acordeon-contenido {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 360ms cubic-bezier(0.22, 1, 0.36, 1);
    }

    .pa-acordeon[open] > .pa-acordeon-contenido {
        grid-template-rows: 1fr;
    }

    .pa-acordeon-inner {
        min-height: 0;
        overflow: hidden;
        padding-top: 8px;
        opacity: 0;
        transform: translateY(-9px);
        transition: opacity 220ms ease, transform 320ms cubic-bezier(0.22, 1, 0.36, 1);
    }

    .pa-acordeon[open] .pa-acordeon-inner {
        opacity: 1;
        transform: translateY(0);
        transition-delay: 45ms;
    }

    .pa-acordeon > summary:focus-visible {
        outline: 2px solid #700101;
        outline-offset: 3px;
        border-radius: 4px;
    }

    @media (prefers-reduced-motion: reduce) {
        .pa-acordeon-contenido,
        .pa-acordeon > summary::after,
        .pa-acordeon-inner {
            transition: none;
            transition-delay: 0ms;
        }
    }

    .pa-profesor-nombre {
        font-weight: 700;
        font-size: 13.5px;
        margin-bottom: 8px;
    }

    .pa-profesor-email {
        font-weight: 400;
        color: #8a8a88;
        font-size: 12px;
        display: block;
        margin: 3px 18px 0 0;
        overflow-wrap: anywhere;
    }

    .pa-form-carrera,
    .pa-form-materias {
        margin-bottom: 8px;
    }

    .pa-form-carrera {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pa-form-carrera label,
    .pa-form-materias > label {
        font-size: 12px;
        color: #55524f;
        font-weight: 600;
    }

    .pa-form-carrera select {
        padding: 5px 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-family: "Overpass", sans-serif;
        font-size: 12.5px;
        max-width: 220px;
    }

    .pa-materias-lista {
        display: flex;
        flex-direction: column;
        gap: 2px;
        margin: 6px 0 10px 0;
        max-height: 220px;
        overflow-y: auto;
        border: 1px solid #f0f0ef;
        border-radius: 8px;
        padding: 8px;
    }

    .pa-materia-header,
    .pa-materia-fila {
        display: grid;
        grid-template-columns: 1fr 55px 55px;
        align-items: center;
        gap: 6px;
    }

    .pa-materia-header {
        font-size: 10.5px;
        color: #8a8a88;
        font-weight: 700;
        text-transform: uppercase;
        padding-bottom: 4px;
        border-bottom: 1px solid #f0f0ef;
        margin-bottom: 3px;
    }

    .pa-materia-header-check,
    .pa-materia-check {
        text-align: center;
    }

    .pa-materia-nombre {
        font-size: 13.5px;
        overflow-wrap: anywhere;
    }

    .pa-materia-ocupada {
        color: #c0392b;
        font-size: 10.5px;
        display: block;
    }

    .pa-item {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 9px;
        margin-bottom: 9px;
    }

    .pa-item-inactivo {
        background: #f9f7f6;
        opacity: 0.85;
    }

    .pa-item-datos {
        display: flex;
        flex-direction: column;
        gap: 2px;
        margin-bottom: 8px;
    }

    .pa-item-datos strong {
        font-size: 13px;
    }

    .pa-item-datos span {
        font-size: 12px;
        color: #666;
    }

    .pa-item-carrera {
        color: #700101 !important;
    }

    .pa-item-acciones {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .pa-form-aprobar {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .pa-paginacion {
        margin-top: 10px;
    }

    .pa-paginacion nav {
        display: flex;
        justify-content: center;
    }

    .pa-paginacion ul {
        display: flex;
        list-style: none;
        gap: 4px;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
    }

    .pa-paginacion span,
    .pa-paginacion a {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 6px;
        font-size: 12px;
        text-decoration: none;
        color: #700101;
        border: 1px solid #eaeae9;
    }

    .pa-paginacion .active span {
        background: #700101;
        color: #fff;
        border-color: #700101;
    }

    @media (max-width: 1100px) {
        .pa-wrap {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .pa-seccion {
            height: 560px;
        }
    }

    @media (max-width: 700px) {
        .pa-wrap {
            grid-template-columns: minmax(0, 1fr);
        }

        .pa-seccion {
            height: 480px;
            min-height: 0;
        }
    }
</style>
