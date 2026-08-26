@extends('backend.layouts.main')
@section('title', 'Horarios por Carreras')
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
        <a href="javascript:history.back()">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
            </svg>
        </a>
    </div>
    <h1>Crear</h1>
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
                {{ Form::open(['route' => 'horario.store']) }}
                @csrf
                <div class="mb-2">
                    {{ Form::label("sede_id",'Sede', ['class' => 'form-label fw-bold']) }}
                    {{Form::text("sede_id", $sede->descripcion , ["class" => "form-control", "readonly" ])}}
                    {{Form::text("sede_id", $sede->id , ["class" => "form-control", "hidden" ])}}
                </div>
                <div class="mb-2">
                    {{ Form::label("carrera_id",'Carrera', ['class' => 'form-label fw-bold']) }}
                    {{Form::text("carrera_id", $carrera->descripcion , ["class" => "form-control", "readonly" ])}}
                    {{Form::text("carrera_id", $carrera->id , ["class" => "form-control", "hidden" ])}}
                </div>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        {{ Form::label("anio_id",'Año', ['class' => 'form-label fw-bold']) }}
                        {{Form::text("anio_id", $anio->descripcion , ["class" => "form-control", "readonly" ])}}
                        {{Form::text("anio_id", $anio->id , ["class" => "form-control", "hidden" ])}}
                    </div>
                    <div class="col-md-4 mb-2">
                        {{ Form::label("comision_id",'Comisión', ['class' => 'form-label fw-bold']) }}
                        {{Form::text("comision_id", $comision->comision , ["class" => "form-control", "readonly" ])}}
                        {{Form::text("comision_id", $comision->id , ["class" => "form-control", "hidden" ])}}
                    </div>
                    <div class="col-md-4 mb-2">
                        {{ Form::label("dia",'Día', ['class' => 'form-label fw-bold']) }} 
                        @if(empty($dia))
                        {{Form::select("dia", $dias, null, ["class" => "form-control", "placeholder" => "Seleccione un día"]) }}
                        @else
                        {{Form::text("dia_nombre", $dias[$dia] , ["class" => "form-control", "readonly" ])}}
                        {{Form::text("dia", $dia , ["class" => "form-control", "hidden" ])}}
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        {{ Form::label("modulohorario_id",'Módulo', ['class' => 'form-label fw-bold']) }}
                        @if(empty($modulo))
                        {{Form::select("modulohorario_id", $modulosHorario, null, ["class" => "form-control", "placeholder" => "Seleccione un horario"]) }}
                        @else
                        {{Form::text("modulohorario_id", $modulo->horainicio . ' - ' . $modulo->horafin , ["class" => "form-control", "readonly" ])}}
                        {{Form::text("modulohorario_id", $modulo->id , ["class" => "form-control", "hidden" ])}}
                        @endif
                    </div>
                    <div class="col-md-6 mb-2">
                        {{ Form::label("cuatrimestre_id",'Modalidad', ['class' => 'form-label fw-bold']) }}
                        {{ Form::select("cuatrimestre_id", [
                            '0' => 'Anual',
                            '1' => '1er Cuatrimestre',
                            '2' => '2do Cuatrimestre'
                        ], null, ["class" => "form-control", "placeholder" => "Seleccione la modalidad"]) }}
                        @error('cuatrimestre_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    {{ Form::label("materia_id",'Materia', ['class' => 'form-label fw-bold']) }}
                    {{Form::select("materia_id", $materias, null, ["class" => "form-control", "placeholder" => "Seleccione una materia"]) }}
                    @error('materia_id')<div class="alert alert-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-2">
                    {{ Form::label("profesor_id",'Profesor', ['class' => 'form-label fw-bold']) }}
                    {{Form::select("profesor_id", $profesores, null, ["class" => "form-control", "placeholder" => "Seleccione un profesor"]) }}
                    @error('profesor_id')<div class="alert alert-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    {{ Form::label("comentario",'Comentario', ['class' => 'form-label fw-bold']) }}
                    {{Form::text("comentario", null , ["class" => "form-control" ])}}
                </div>
                <button type="submit" class="btn btn-success form-control">Agregar</button>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>
@endsection