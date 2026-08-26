@extends('backend.layouts.main')
@section('title', 'Etiquetas')
@section('content')
<div class="Inicio">
  <div style="position:absolute;top:100px;left:30px;cursor:pointer;">
    <a href="{{ route('users.index') }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
      </svg>
    </a>
  </div>
  <h1 class="TextoInicio">Usuario</h1>
</div>
<div>
  @if(Session::has('status'))
  <div class="alert alert-success">{{ Session('status')}}</div>
  @endif
</div>
<div class="col-lg-8 col-md-10 mx-auto border rounded p-3 shadow-sm">
  {{ Form::model($user, [ 'method' => 'get' , 'route' => ['users.show', $user->id]]) }}
  <div class="mb-3">
    {{ Form::label("name", 'Nombre', ['class' => 'form-label fw-bold']) }}
    {{Form::text("name", old("name"), ["class" => "form-control", "placeholder" => "Ingrese el nombre", "readonly" , ])}}
    @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3">
    {{ Form::label("email", 'Email', ['class' => 'form-label fw-bold']) }}
    {{Form::text("email", old("email"), ["class" => "form-control", "placeholder" => "Ingrese el email", "readonly" , ])}}
    @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    {{ Form::checkbox("is_admin", null, null, ['class' => 'form-check-input', "readonly", 'type' => 'checkbox']) }}
    {{ Form::label("is_admin", 'Admin?', ['class' => 'form-check-label']) }}
    @error('is_admin')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  {!!Form::close()!!}
  @endsection