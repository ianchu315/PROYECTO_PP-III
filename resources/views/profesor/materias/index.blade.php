@extends(Auth::guard('usuarios')->user()->rol === 'superadministrador' ? 'layouts.panel' : 'layouts.app2')

@section('titulo', Auth::guard('usuarios')->user()->rol === 'superadministrador' ? 'Materias' : 'Mis materias')

@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1>{{ Auth::guard('usuarios')->user()->rol === 'superadministrador' ? 'Materias' : 'Mis materias' }}</h1>
    </div>

    @if($materias->isEmpty())
        <div class="pf-card">
            <p class="pf-muted mb-0">
                @if(Auth::guard('usuarios')->user()->rol === 'superadministrador')
                    Todavía no hay materias cargadas.
                @else
                    Todavía no tenés materias asignadas. Pedile al superadministrador que te asigne tus carreras y materias desde el panel.
                @endif
            </p>
        </div>
    @else
        <div class="curso-catalogo">
            @foreach($materias->groupBy('carrera_id') as $materiasCarrera)
                @php $carrera = $materiasCarrera->first()->deCarrera; @endphp
                <section class="curso-grupo">
                    <header class="curso-grupo-header">
                        <div>
                            <span class="curso-eyebrow">CARRERA</span>
                            <h2>{{ $carrera->descripcion ?? 'Sin carrera' }}</h2>
                        </div>
                        <span class="curso-grupo-cantidad">{{ $materiasCarrera->count() }} {{ $materiasCarrera->count() === 1 ? 'curso' : 'cursos' }}</span>
                    </header>
                    <div class="curso-grid">
                        @foreach($materiasCarrera as $materia)
                            <article class="curso-tarjeta">
                                <div class="curso-tarjeta-banda"></div>
                                <div class="curso-tarjeta-contenido">
                                    <div class="curso-tarjeta-titulo">
                                        <div>
                                            <span class="curso-eyebrow">{{ $materia->deAnio->descripcion ?? 'Materia' }}</span>
                                            <h3>{{ $materia->descripcion }}</h3>
                                        </div>
                                    </div>
                                    @if(Auth::guard('usuarios')->user()->rol !== 'superadministrador')
                                        <p class="curso-docente">{{ $materia->origen }}</p>
                                    @else
                                        <p class="curso-docente">{{ $materia->profesorUsuario ? 'Docente: ' . $materia->profesorUsuario->nombre . ' ' . $materia->profesorUsuario->apellido : 'Docente sin asignar' }}</p>
                                    @endif
                                    <div class="curso-tarjeta-pie">
                                        <span><i class="ri-group-line"></i> {{ $materia->alumnos_inscriptos_count }} alumnos</span>
                                        <span><i class="ri-folder-3-line"></i> {{ $materia->unidades_count }} unidades</span>
                                    </div>
                                    <a href="{{ route('bolsadetrabajo.profesor.materias.show', $materia) }}" class="btn btn-primary btn-sm curso-abrir">
                                        Abrir materia
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    @endif
</div>

<style>
    .curso-catalogo {
        display: grid;
        gap: 24px;
    }

    .curso-grupo-header {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 12px;
        border-bottom: 1px solid #eaeae9;
        padding: 0 2px 10px;
        margin-bottom: 12px;
    }

    .curso-eyebrow {
        display: block;
        color: #8a8a88;
        font-size: 10px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .curso-grupo-header h2 {
        margin: 0;
        color: #700101;
        font-size: 19px;
    }

    .curso-grupo-cantidad {
        color: #777;
        font-size: 12px;
        white-space: nowrap;
    }

    .curso-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 290px), 1fr));
        gap: 14px;
    }

    .curso-tarjeta {
        min-width: 0;
        overflow: hidden;
        border: 1px solid #eaeae9;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .04);
    }

    .curso-tarjeta-banda {
        height: 8px;
        background: #700101;
    }

    .curso-tarjeta-contenido {
        padding: 16px;
    }

    .curso-tarjeta-titulo h3 {
        margin: 0;
        font-size: 17px;
        overflow-wrap: anywhere;
    }

    .curso-docente {
        color: #777;
        font-size: 13px;
        margin: 14px 0;
    }

    .curso-tarjeta-pie {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        border-top: 1px solid #f0f0ef;
        padding-top: 12px;
        color: #666;
        font-size: 12px;
    }

    .curso-abrir {
        margin-top: 14px;
    }
</style>
@endsection
