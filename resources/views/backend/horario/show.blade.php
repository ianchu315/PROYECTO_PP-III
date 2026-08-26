@extends('backend.layouts.main')
@section('title', 'Horarios')
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
        <a href="{{ route('horario.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
        </svg>
        </a>
    </div>
    <h1>Crear horarios</h1>
    </div>
    @if(Session::has('status'))
    <div class="alert alert-success alert-dismissible fade show">{{ Session('status')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="card mb-3">
        <div class="card-header text-bg-dark">Consulta de horarios</div>
        <div class="card-body">
            {{ Form::open(['route' => 'horario.createHorario']) }}
            <div class="row mb-2">
                <div class="col-md-4 mb-2 mb-md-0">
                    <div class="input-group">
                        {{Form::label("sede_id", 'Sede', ['class' => 'input-group-text bg-dark text-light'])}}
                        {{Form::text("sede_id", $sede->descripcion , ["class" => "form-control", "readonly" ])}}
                        {{Form::text("sede_id", $sede->id , ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
                <div class="col-md-5 mb-2 mb-md-0">
                    <div class="input-group">
                        {{Form::label("carrera_id", 'Carrera', ['class' => 'input-group-text bg-dark text-light'])}}
                        {{Form::text("carrera_id", $carrera->descripcion , ["class" => "form-control", "readonly" ])}}
                        {{Form::text("carrera_id", $carrera->id , ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        {{Form::label("resolucion_id", 'Resolución', ['class' => 'input-group-text bg-dark text-light'])}}
                        {{Form::text("resolucion_id", $resolucion->resolucion ?? ' ' , ["class" => "form-control", "readonly" ])}}
                        {{Form::text("resolucion_id", $resolucion->id ?? '', ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-md-4 mb-2 mb-md-0">
                    <div class="input-group">
                        {{Form::label("anio_id", 'Año', ['class' => 'input-group-text bg-dark text-light'])}}
                        {{Form::text("anio_id", $anio->descripcion , ["class" => "form-control", "readonly" ])}}
                        {{Form::text("anio_id", $anio->id , ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <div class="input-group">
                        {{Form::label("comision_id", 'Comisión', ['class' => 'input-group-text bg-dark text-light'])}}
                        {{Form::text("comision_id", $comision->comision , ["class" => "form-control", "readonly" ])}}
                        {{Form::text("comision_id", $comision->id , ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        {{Form::label("cuatrimestre_id", 'Modalidad', ['class' => 'input-group-text bg-dark text-light'])}}
                        @php
                            $modalidadTexto = '';
                            switch ($cuatrimestre_id) {
                                case '0':
                                    $modalidadTexto = 'Anual';
                                    break;
                                case '1':
                                    $modalidadTexto = '1° CUATRIMESTRE';
                                    break;
                                case '2':
                                    $modalidadTexto = '2° CUATRIMESTRE';
                                    break;
                            }
                        @endphp
                        {{Form::text("cuatrimestre_id", $modalidadTexto, ["class" => "form-control", "readonly" ])}}
                        {{Form::text("cuatrimestre_id", $cuatrimestre_id, ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <tr class="text-light text-center" style="background-color: #3A70FF;">
                <th>HORARIO</th>
                @foreach($dias as $dia)
                <th>{{$dia}}</th>
                @endforeach
            </tr>
            @foreach($modulosHorarios as $modulosHorario)
            <tr>
                <td class="bg-dark text-light text-center align-middle" style="">{{$modulosHorario->horainicio}} a {{$modulosHorario->horafin}}
                    @foreach($dias as $index=>$dia)
                <td style="background: #F5F5F5;" class="text-center align-middle">
                    @php ($a = 0)
                    @foreach($horarios as $horario)

                    @if($horario->dia == $index && $horario->moduloHorario->id == $modulosHorario->id )
                    @php ($a++)
                    <div class="text-center align-middle p-1">
                        <div class="align-middle">
                            <strong class="h6 mb-1">{{$horario->materia->descripcion}}</strong>
                            <p class="mb-3">{{$horario->profesor->apellido}}, {{$horario->profesor->nombre}} </p>
                            <p class="mb-3">{{$horario->comentario}}</p>

                                {{ Form::model($horario, [
                                    'method' => 'delete',
                                    'route' => ['horario.destroy', $horario->id] + request()->query()
                                ]) }}
                            @csrf
                            <a href="{{ route('horario.edit', ['horario' =>  $horario->id] ) }}" class="btn bg-primary">
                                <img src="{{ asset('svg/edit.svg') }}" width="20" height="20" alt="Editar" title="Editar  horario">
                            </a>
                            <button type="submit" class="btn btn-danger" onclick="if (!confirm('¿Esta seguro de borrar el horario?')) return false;">
                                <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar" title="Borrar horario">
                            </button>
                            {!!Form::close()!!}
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @if($a == 0)
                    @php ($a++)
                    <div class="text-center px-5 py-4 m-auto">
                        <p class="align-middle px-auto">{{ Form::open(['route' => 'horario.createHorario']) }}</p>
                        {{ Form::hidden("sede_id", $sede->id, ["hidden"])}}
                        {{ Form::hidden("carrera_id", $carrera->id, ["hidden"])}}
                        {{ Form::hidden("anio_id", $anio->id, ["hidden"])}}
                        {{ Form::hidden("comision_id", $comision->id, ["hidden"])}}
                        {{ Form::hidden("modulohorario_id", $modulosHorario->id, ["hidden"])}}
                        {{ Form::hidden("cuatrimestre_id", $cuatrimestre_id, ["hidden"])}}
                        {{ Form::hidden("dia", $index, ["hidden"])}}
                        <button type="submit" class="btn btn-success"><img src="{{ asset('svg/new.svg') }}" height="20" width="20" alt="Crear" title="Crear horario"></button>
                    </div>
                    </div>
                    {!!Form::close()!!}

                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </table>
    </div>
    <p class="container-fluid my-0 text-center p-1" style="background-color: #E7E7E7;">Estos horarios podrían no ser los oficiales actuales del Instituto. En caso de duda pregunte al preceptor correspondiente a la carrera.</p>
@endsection