@extends('backend.layouts.main')
@section('title', 'Salones')
@section('content')

{{-- ALERTAS LINDAS (como en Materias) --}}
@if(session('success'))
    <div class="alert alert-success text-center shadow-sm fw-bold">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center shadow-sm fw-bold">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger text-center shadow-sm fw-bold">
        <ul class="mb-0 list-unstyled">
            @foreach($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 d-flex justify-content-center d-none d-lg-flex">
            <div class="position-relative">
                <img src="{{ asset('img/plano_piso2.png') }}" 
                     usemap="#mapaSalones" 
                     class="img-fluid border shadow plano-img">

                {{-- Overlay para resaltar --}}
                <div id="highlight" class="highlight"></div>
            </div>

            <map name="mapaSalones"> 
                {{-- Salones Normales --}} 
                <area shape="rect" coords="76,120,191,195" href="javascript:void(0)" data-salon="233" alt="Salón 233"> 
                <area shape="rect" coords="192,120,419,195" href="javascript:void(0)" data-salon="229" alt="Salón 229"> 
                <area shape="rect" coords="531,120,647,195" href="javascript:void(0)" data-salon="227" alt="Salón 227"> 
                <area shape="rect" coords="647,120,704,195" href="javascript:void(0)" data-salon="225" alt="Salón 225"> 
                <area shape="rect" coords="704,120,818,195" href="javascript:void(0)" data-salon="224" alt="Salón 224"> 
                <area shape="rect" coords="818,120,930,195" href="javascript:void(0)" data-salon="222" alt="Salón 222"> 
                <area shape="rect" coords="76,241,191,318" href="javascript:void(0)" data-salon="236" alt="Salón 236"> 
                <area shape="rect" coords="190,241,363,318" href="javascript:void(0)" data-salon="239" alt="Salón 239"> 
                <area shape="rect" coords="646,241,760,318" href="javascript:void(0)" data-salon="216" alt="Salón 216"> 
                <area shape="rect" coords="818,241,932,318" href="javascript:void(0)" data-salon="219" alt="Salón 219"> 
                <area shape="rect" coords="418,318,476,468" href="javascript:void(0)" data-salon="241" alt="Salón 241"> 
                <area shape="rect" coords="533,392,646,468" href="javascript:void(0)" data-salon="214" alt="Salón 214"> 
                <area shape="rect" coords="533,468,646,544" href="javascript:void(0)" data-salon="113" alt="Salón 113"> 
                <area shape="rect" coords="646,470,762,544" href="javascript:void(0)" data-salon="112" alt="Salón 112"> 
                <area shape="rect" coords="761,470,876,544" href="javascript:void(0)" data-salon="210" alt="Salón 210"> 
                <area shape="rect" coords="818,591,933,667" href="javascript:void(0)" data-salon="206" alt="Salón 206"> 
                <area shape="rect" coords="305,591,418,667" href="javascript:void(0)" data-salon="253" alt="Salón 253"> 
                
                {{-- Salones Laboratorios --}} 
                <area shape="rect" coords="246,467,362,545" href="javascript:void(0)" data-salon="LAB. SALA 1 (243)" data-laboratorio="1" alt="Laboratorio 1"> 
                <area shape="rect" coords="133,467,249,545" href="javascript:void(0)" data-salon="LAB. SALA 2 (245)" data-laboratorio="1" alt="Laboratorio 1"> 
                <area shape="rect" coords="874,468,932,592" href="javascript:void(0)" data-salon="LAB. SALA 3 ()" data-laboratorio="1" alt="Laboratorio 1"> 
                <area shape="rect" coords="418,591,476,668" href="javascript:void(0)" data-salon="LAB. SALA 4 (254)" data-laboratorio="1" alt="Laboratorio 1"> 
            </map>
        </div>
    </div>
</div>

<div class="card shadow border-0 rounded-3 mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between flex-wrap align-items-center">
        <h4 class="mb-0"><i class="bi bi-building"></i> Salones</h4>
        <div class="d-flex gap-2 mt-2 mt-md-0">
            <a href="{{ route('salones.create') }}" class="btn btn-success d-flex align-items-center gap-1">
                <img src="{{ asset('svg/new.svg') }}" width="18" height="18" alt="Crear" title="Crear">
                Crear Salón
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle shadow-sm">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Salón</th>
                        <th>Capacidad</th>
                        <th>Carrera</th>
                        <th>Año</th>
                        <th>Comisión</th>
                        <th>Laboratorio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salones as $salon)
                        <tr>
                            <td class="fw-bold text-primary text-center">
                                <a href="javascript:void(0)" 
                                   class="salon-link text-decoration-none" 
                                   data-salon="{{ $salon->numero_salon }}">
                                   {{ $salon->numero_salon }}
                                </a>
                            </td>
                            <td class="text-center">{{ $salon->capacidad }}</td>
                            <td class="text-center">{{ $salon->carrera->descripcion ?? 'Sin carrera' }}</td>
                            <td class="text-center">{{ $salon->anio->descripcion ?? 'Sin año' }}</td>
                            <td class="text-center">{{ $salon->comision->comision ?? 'Sin comisión' }}</td>
                            <td class="text-center">
                                <span class="badge {{ $salon->laboratorio ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $salon->laboratorio ? 'Sí' : 'No' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('salones.edit', $salon->id) }}" 
                                       class="btn btn-primary btn-sm" 
                                       title="Editar">
                                        <img src="{{ asset('svg/edit.svg') }}" width="16" height="16" alt="Editar">
                                    </a>
                                    <form action="{{ route('salones.destroy', $salon->id) }}" method="POST" class="d-inline form-eliminar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar" title="Eliminar">
                                            <img src="{{ asset('svg/delete.svg') }}" width="16" height="16" alt="Eliminar">
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay salones registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.highlight {
    position: absolute;
    border: 2px solid red;
    background: rgba(255, 0, 0, 0.3);
    display: none;
    pointer-events: none;
}
.highlight.laboratorio {
    border: 2px solid green;
    background: rgba(0, 255, 0, 0.3);
}
.plano-img {
    max-width: 1300px; 
    width: 90%;       
    height: auto;    
}
</style>

{{-- Scripts para el mapa interactivo --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    const highlight = document.getElementById("highlight");
    const areas = document.querySelectorAll("area");
    const links = document.querySelectorAll(".salon-link");

    areas.forEach(area => {
        area.addEventListener("mouseenter", () => showHighlight(area));
        area.addEventListener("mouseleave", hideHighlight);
    });

    links.forEach(link => {
        link.addEventListener("click", () => {
            const salonId = link.dataset.salon;
            const area = document.querySelector(`area[data-salon='${salonId}']`);
            if (area) {
                showHighlight(area);
                document.querySelector("img[usemap='#mapaSalones']").scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }
        });
    });

    function showHighlight(area) {
        const [x1, y1, x2, y2] = area.coords.split(",").map(Number);
        Object.assign(highlight.style, {
            left: `${x1}px`,
            top: `${y1}px`,
            width: `${x2 - x1}px`,
            height: `${y2 - y1}px`,
            display: "block"
        });
        area.dataset.laboratorio === "1"
            ? highlight.classList.add("laboratorio")
            : highlight.classList.remove("laboratorio");
    }

    function hideHighlight() {
        highlight.style.display = "none";
    }

    // Confirmación de eliminación con SweetAlert
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const form = btn.closest('form');
            Swal.fire({
                title: '¿Eliminar salón?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                background: '#fff',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

{{-- ALERTA DE ELIMINACIÓN EXITOSA --}}
@if(session('deleted'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        title: '¡Eliminado!',
        text: "{{ session('deleted') }}",
        icon: 'success',
        showConfirmButton: false,
        timer: 2000,
        background: '#e6fff2',
        color: '#155724',
    });
});
</script>
@endif

@endsection
