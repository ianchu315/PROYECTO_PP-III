@extends('backend.layouts.main')
@section('title', 'Carreras')
@section('content')

<style>
    .Inicio {
        text-align: center;
        margin: 20px;
        font-family: 'Quicksand', sans-serif;
        font-weight: 800;
    }

    /* Mejor contraste para el ícono */
    .back-icon {
        fill: #1a1a1a;
    }

    
</style>

<div>
    @if(Session::has('status'))
        <div class="alert alert-success">{{ Session('status') }}</div>
    @endif
</div>

<div class="Inicio">
    <div style="position:absolute;top:100px;left:30px;cursor:pointer;">
        <a href="/carrera" aria-label="Volver a la lista de carreras">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" class="bi bi-arrow-left-circle-fill back-icon" role="img" viewBox="0 0 16 16" aria-hidden="true">
                <title>Volver</title>
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
            </svg>
        </a>
    </div>
    <h1>Carrera</h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card border border-0 shadow rounded">
            <div class="card-body p-4">

                {{ Form::model($carrera, ['method' => 'get', 'route' => ['carrera.show', $carrera->id]]) }}

                {{-- Carrera --}}
                <div class="mb-2">
                    {{ Form::label('descripcion', 'Carrera', ['class' => 'form-label fw-bold']) }}
                    {{ Form::text('descripcion', null, ['class' => 'form-control', 'id' => 'descripcion', 'readonly']) }}
                </div>

                {{-- Años y Resolución --}}
                <div class="row">
                    <div class="col-md-6 mb-2">
                        {{ Form::label('anios', 'Años', ['class' => 'form-label fw-bold']) }}
                        {{ Form::text('anios', null, ['class' => 'form-control', 'id' => 'anios', 'readonly']) }}
                    </div>
                    <div class="col-md-6 mb-2">
                        {{ Form::label('resolucion', 'Resolución', ['class' => 'form-label fw-bold']) }}
                        {{ Form::text('resolucion', $carrera->resolucion, ['class' => 'form-control', 'id' => 'resolucion', 'readonly']) }}
                    </div>
                </div>

                {{-- Descripción --}}
                <div class="mb-2">
                    {{ Form::label('texto', 'Descripción', ['class' => 'form-label fw-bold']) }}
                    {{ Form::textarea('texto', $carrera->texto, ['class' => 'form-control', 'id' => 'texto', 'readonly', 'rows' => 9]) }}
                </div>

                {{-- Imagen y Sedes --}}
                <div class="row">
                    <div class="col-md-6 mb-2">
                        {{ Form::label('imagen', 'Imagen', ['class' => 'form-label fw-bold']) }}
                        <br>
                        @if($carrera->imagen)
                            @if(Str::startsWith($carrera->imagen, 'http'))
                                <img src="{{ $carrera->imagen }}" class="img-fluid rounded shadow-sm" alt="Imagen de la carrera {{ $carrera->descripcion }}">
                            @else
                                <img src="{{ asset('storage/'.$carrera->imagen) }}" class="img-fluid rounded shadow-sm" alt="Imagen de la carrera {{ $carrera->descripcion }}">
                            @endif
                        @else
                            <p class="text-center text-muted">No hay imagen disponible</p>
                        @endif
                    </div>

                    <div class="col-md-6 mb-2">
                        {{ Form::label('sedes_id', 'Sedes', ['class' => 'form-label fw-bold']) }}
                        @foreach($sedes as $id => $nombre)
                            <div class="form-check">
                                {{ Form::checkbox('sede'.$id, $id, true, ['class' => 'form-check-input', 'id' => 'sede'.$id, 'disabled']) }}
                                {{ Form::label('sede'.$id, $nombre, ['class' => 'form-check-label']) }}
                            </div>
                        @endforeach
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
