@extends('layouts.panel')

@section('titulo', 'Mis materias')

@section('content')
<div class="pf-page-header">
    <h1>Mis materias</h1>
</div>

@if($materias->isEmpty())
    <div class="pf-card">
        <p class="pf-muted mb-0">Todavía no estás inscripto en ninguna materia.</p>
    </div>
@else
    <div class="curso-catalogo">
        @foreach($materias->groupBy(fn($item) => $item['materia']->carrera_id ?? 0) as $materiasCarrera)
            @php $carrera = $materiasCarrera->first()['materia']->deCarrera; @endphp
            <section class="curso-grupo">
                <header class="curso-grupo-header">
                    <div>
                        <span class="curso-eyebrow">CARRERA</span>
                        <h2>{{ $carrera->descripcion ?? 'Sin carrera' }}</h2>
                    </div>
                    <span class="curso-grupo-cantidad">{{ $materiasCarrera->count() }} {{ $materiasCarrera->count() === 1 ? 'curso' : 'cursos' }}</span>
                </header>
                <div class="curso-grid">
                    @foreach($materiasCarrera as $item)
                        @php $materia = $item['materia']; @endphp
                        <article class="curso-tarjeta">
                            <div class="curso-tarjeta-banda"></div>
                            <div class="curso-tarjeta-contenido">
                                <div class="curso-tarjeta-titulo">
                                    <div>
                                        <span class="curso-eyebrow">{{ $materia->deAnio->descripcion ?? 'Materia' }}</span>
                                        <h3>{{ $materia->descripcion }}</h3>
                                    </div>
                                    <span class="pf-badge pf-badge-{{ $item['condicion'] }}">{{ ucfirst($item['condicion']) }}</span>
                                </div>
                                <p class="curso-docente">
                                    {{ $materia->profesorUsuario ? 'Docente: ' . $materia->profesorUsuario->nombre . ' ' . $materia->profesorUsuario->apellido : 'Docente sin asignar' }}
                                </p>
                                <div class="curso-tarjeta-pie">
                                    <span><i class="ri-folder-3-line"></i> {{ $materia->unidades_count }} {{ $materia->unidades_count === 1 ? 'unidad' : 'unidades' }}</span>
                                    <a href="{{ route('bolsadetrabajo.alumno.materias.show', $materia) }}" class="btn btn-primary btn-sm">Abrir curso</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
@endif

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

    .curso-tarjeta-titulo {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
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
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        border-top: 1px solid #f0f0ef;
        padding-top: 12px;
    }

    .curso-tarjeta-pie > span {
        color: #666;
        font-size: 12px;
    }
</style>
@endsection
