@extends('frontend.layout.main')

@section('title', 'Confirmar inscripción')

@section('content')
<div class="mesa-confirmar-wrap">
    <div class="mesa-confirmar-card">
        <h3 class="mesa-confirmar-title">Confirmar inscripción a mesa final</h3>

        @php
            $esRegular = $condicion === 'regular';
        @endphp

        <form method="POST" action="{{ route('frontend.mesas.inscribir.store', $mesa) }}">
            @csrf

            {{-- Elección de condición: primero, bien visible, arriba del todo --}}
            <div class="mesa-confirmar-seccion">
                <label class="mesa-confirmar-label">Condición para rendir:</label>

                <div class="mesa-confirmar-opciones">
                    <input type="radio" name="condicion" id="chkRegular" value="regular"
                           class="mesa-confirmar-radio-input"
                           {{ $esRegular ? '' : 'disabled' }}
                           {{ $esRegular ? 'checked' : '' }}>
                    <label for="chkRegular" class="mesa-confirmar-opcion mesa-confirmar-opcion--regular {{ $esRegular ? '' : 'is-disabled' }}">
                        <span class="mesa-confirmar-opcion-titulo">Regular</span>
                        @unless($esRegular)
                            <span class="mesa-confirmar-opcion-nota">No disponible: promedio insuficiente</span>
                        @endunless
                    </label>

                    <input type="radio" name="condicion" id="chkLibre" value="libre"
                           class="mesa-confirmar-radio-input"
                           {{ $esRegular ? '' : 'checked' }}>
                    <label for="chkLibre" class="mesa-confirmar-opcion mesa-confirmar-opcion--libre">
                        <span class="mesa-confirmar-opcion-titulo">Libre</span>
                    </label>
                </div>
            </div>

            {{-- Datos de la mesa --}}
            <div class="mesa-confirmar-datos">
                <div><strong>Materia:</strong> {{ $mesa->materia->descripcion ?? '-' }}</div>
                <div><strong>Fecha:</strong> {{ $mesa->fecha }}</div>
                <div><strong>Horario:</strong> {{ $mesa->horario ?? '-' }}</div>
                <div><strong>Carrera:</strong> {{ $mesa->carrera->descripcion ?? '-' }}</div>
            </div>

            <p class="mesa-confirmar-alerta"><strong>Atención:</strong> una vez confirmada, no podrás desinscribirte.</p>

            <div class="mesa-confirmar-acciones">
                <button type="submit" class="mesa-confirmar-btn mesa-confirmar-btn--confirmar">Confirmar inscripción</button>
                <a href="{{ route('frontend.mesas.index') }}" class="mesa-confirmar-btn mesa-confirmar-btn--volver">Volver</a>
            </div>
        </form>
    </div>
</div>

<style>
/* Estilos propios y autocontenidos para esta pantalla: no dependen de
   utilidades de una versión particular de Bootstrap (la plantilla carga dos
   versiones distintas de Bootstrap y eso rompía los toggles ".btn-check"). */
.mesa-confirmar-wrap {
    max-width: 720px;
    margin: 2.5rem auto;
    padding: 0 1rem;
    box-sizing: border-box;
}

.mesa-confirmar-card {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    padding: 1.75rem;
    box-sizing: border-box;
}

.mesa-confirmar-title {
    margin: 0 0 1.25rem 0;
    font-size: 1.4rem;
    font-weight: 700;
    color: #212529;
}

.mesa-confirmar-seccion {
    margin-bottom: 1.5rem;
}

.mesa-confirmar-label {
    display: block;
    font-weight: 700;
    margin-bottom: 0.6rem;
    color: #212529;
}

.mesa-confirmar-opciones {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.mesa-confirmar-radio-input {
    position: absolute;
    opacity: 0;
    width: 1px;
    height: 1px;
    pointer-events: none;
}

.mesa-confirmar-opcion {
    display: block;
    flex: 1 1 160px;
    min-width: 150px;
    max-width: 220px;
    padding: 0.85rem 1rem;
    border: 2px solid #ced4da;
    border-radius: 8px;
    cursor: pointer;
    background: #fff;
    transition: border-color 0.15s ease, background-color 0.15s ease;
    box-sizing: border-box;
}

.mesa-confirmar-opcion-titulo {
    display: block;
    font-weight: 700;
    color: #212529;
}

.mesa-confirmar-opcion-nota {
    display: block;
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 0.2rem;
}

.mesa-confirmar-radio-input:checked + .mesa-confirmar-opcion--regular {
    border-color: #198754;
    background-color: #e9f7ef;
}

.mesa-confirmar-radio-input:checked + .mesa-confirmar-opcion--libre {
    border-color: #0d6efd;
    background-color: #e8f0fe;
}

.mesa-confirmar-radio-input:focus-visible + .mesa-confirmar-opcion {
    outline: 2px solid #0d6efd;
    outline-offset: 2px;
}

.mesa-confirmar-opcion.is-disabled {
    cursor: not-allowed;
    opacity: 0.55;
}

.mesa-confirmar-datos {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.5rem 1.5rem;
    margin-bottom: 1.25rem;
    color: #343a40;
}

.mesa-confirmar-alerta {
    color: #dc3545;
    margin-bottom: 1.25rem;
}

.mesa-confirmar-acciones {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
}

.mesa-confirmar-btn {
    display: inline-block;
    padding: 0.55rem 1.2rem;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    text-align: center;
}

.mesa-confirmar-btn--confirmar {
    background-color: #198754;
    color: #fff;
}

.mesa-confirmar-btn--volver {
    background-color: #6c757d;
    color: #fff;
}

@media (max-width: 576px) {
    .mesa-confirmar-wrap {
        margin: 1.25rem auto;
    }

    .mesa-confirmar-card {
        padding: 1.1rem;
    }

    .mesa-confirmar-datos {
        grid-template-columns: 1fr;
    }

    .mesa-confirmar-opcion {
        flex: 1 1 100%;
        max-width: none;
    }

    .mesa-confirmar-acciones .mesa-confirmar-btn {
        flex: 1 1 auto;
    }
}
</style>
@endsection
