@extends('backend.layouts.main')
@section('title', 'Profesores')
@section('content')

<style>
    .Inicio {
        text-align: center;
        margin: 20px;
        font-family: 'Quicksand', sans-serif;
        font-weight: 800;
        position: relative;
    }
</style>
<div class="Inicio">
<div style="position:absolute;top:0;left:30px;cursor:pointer;">
        <a href="{{ route('profesor.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
            </svg>
        </a>
    </div>
  <h1>Editar Profesor</h1>
</div>

  <div>
    @if(Session::has('status'))
    <div class="alert alert-success">{{ Session('status')}}</div>
    @endif
  </div>
  <div class="col-lg-8 col-md-10 mx-auto p-4 border border-1 rounded shadow-sm">

    {{ Form::model($profesor, [ 'method' => 'put' , 'route' => ['profesor.update', $profesor->id],  'files' => true]) }}

    @csrf <!-- {{ csrf_field() }} -->
    {{ Form::hidden('page', request('page')) }}
    
      <div class="mb-3 @if($errors->has('titulo')) has-error has-feedback @endif">
        {{ Form::label("nombre", 'Nombre', ['class' => 'form-label fw-bold']) }}
        {{Form::text("nombre", null , ["class" => "form-control" ])}}
      </div>
      @error('nombre')<div class="alert alert-danger">{{ $message }}</div>@enderror
      <div class="mb-3 @if($errors->has('titulo')) has-error has-feedback @endif">
        {{ Form::label("descripcion", 'Apellido', ['class' => 'form-label fw-bold']) }}
        {{Form::text("apellido", null , ["class" => "form-control" ])}}
      </div>
      @error('apellido')<div class="alert alert-danger">{{ $message }}</div>@enderror
      <button type="submit" class="btn btn-success form-control">Guardar</button>
    {!!Form::close()!!}
  </div>
@endsection