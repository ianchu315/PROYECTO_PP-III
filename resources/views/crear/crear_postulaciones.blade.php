<!-- // Vista para agregar una nueva postulación, con formulario que permite seleccionar oferta, estado y fechas, y botones para cancelar o guardar la postulación.
 -->


@extends('layouts.app2')

@section('content')
<div class="perfil-contenedor separador" style="margin-top: 100px;">

    <h2 class="titulo-principal">
        <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'postulaciones']) }}" class="link-icono">
            <i class="ri-arrow-left-line icon-bordo"></i>
        </a>

        Añadir Postulacion
    </h2>
    <br>

    <form action="{{ route('bolsadetrabajo.postulaciones.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="oferta_id">Oferta</label>
            <select class="form-control" name="oferta_id" required>
                <option value="">Seleccionar oferta</option>
                @foreach ($ofertas as $oferta)
                <option value="{{ $oferta->id }}">{{ $oferta->titulo }} - {{ $oferta->empresa }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="estado_postulacion">Estado</label>
            <select class="form-control" name="estado_postulacion" required>
                <option value="En proceso">En proceso</option>
                <option value="Aceptado">Aceptado</option>
                <option value="Rechazado">Rechazado</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="fecha_postulacion">Fecha de postulación</label>
            <input type="date" class="form-control" name="fecha_postulacion" required>
        </div>

        <div class="form-group mb-4">
            <label for="fecha_contratacion">Fecha de contratación (opcional)</label>
            <input type="date" class="form-control" name="fecha_contratacion">
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 25px;">
            <a href="{{ route('bolsadetrabajo.perfil', ['seccion' => 'postulaciones']) }}" class="boton-actualizar" style="text-decoration: none; background: #ccc; padding: 8px 16px; border-radius: 6px; color: #000;">
                Cancelar
            </a>
            <button type="submit" class="btn-agregar" style="background-color: #730000; color: #fff; padding: 8px 16px; border-radius: 6px;">
                <i class="ri-check-line"></i> Guardar postulacion
            </button>
        </div>
    </form>
</div>
@endsection