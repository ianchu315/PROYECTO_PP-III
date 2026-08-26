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
</style>

<div class="Inicio">
    <div style="position:absolute;top:100px;left:30px;cursor:pointer;">
        <a href="/carrera">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
        </svg>
        </a>
    </div>
    <h1>Editar Carrera</h1>
</div>
<div>
    @if(Session::has('status'))
    <div class="alert alert-success">{{ Session('status')}}</div>
    @endif
</div>
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card border border-0 shadow rounded">
            <div class="card-body p-4">
                {{ Form::model($carreras, [ 'method' => 'put' , 'route' => ['carrera.update', $carreras->id],  'files' => true]) }}
                @csrf
                <!-- {{ csrf_field() }} -->
                <div class="mb-2 @if($errors->has('titulo')) has-error has-feedback @endif">
                    {{ Form::label("descripcion", 'Carrera', ['class' => 'form-label fw-bold']) }}
                    {{Form::text("descripcion", old("descripcion"), ["class" => "form-control" ])}}
                    @error('descripcion') <div class="alert alert-danger">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        {{ Form::label("anios", __('Años'), ['class' => 'form-label fw-bold']) }}
                        {{Form::text("anios", old("anios"), ["class" => "form-control" ])}}
                        @error('anios')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        {{ Form::label("resolucion", __('Resolución'), ['class' => 'form-label fw-bold']) }}
                        {{Form::text("resolucion", old("resolucion"), ["class" => "form-control" ])}}
                        @error('resolucion')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    {{ Form::label("texto", __('Descripción'), ['class' => 'form-label fw-bold']) }}
                    {{Form::textarea("texto", old("texto"), ["class" => "form-control", "rows" => "9" ])}}
                    @error('texto')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    {{ Form::label("nombre_carpeta", __('Carpeta'), ['class' => 'form-label fw-bold']) }}
                    {{Form::text("nombre_carpeta", old("nombre_carpeta"), ["class" => "form-control" ])}}
                    @error('nombre_carpeta')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-7 mb-2">
                        {{ Form::label("imagen", 'Imagen', ['class' => 'form-label fw-bold']) }}
                        {{ Form::file("imagen", ["class" => "form-control" ])}}
                        @error('imagen')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5 mb-2">
                        {{ Form::label("sedes_id", __('Sedes'), ['class' => 'form-label fw-bold']) }}
                        @foreach($sedes as $id => $nombre)
                            <div class="form-check mt-2">
                                @if( $carreras->sedes()->find($id))
                                {{ Form::checkbox('sede'.$id, $id, 'X', ['class' => 'form-check-input']) }}{{ Form::label($id, $nombre, ['class' => 'form-check-label']) }}
                                @else
                                {{ Form::checkbox('sede'.$id, $id, null, ['class' => 'form-check-input']) }}{{ Form::label($id, $nombre, ['class' => 'form-check-label']) }}
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-grid mt-2">
                    <button type="submit" class="btn btn-success">{{__('Guardar')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}
@endsection