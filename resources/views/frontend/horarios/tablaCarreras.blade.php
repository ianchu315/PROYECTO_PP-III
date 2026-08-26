@extends('frontend.layout.main')

@section('title', 'Horarios por Carreras')
@section('content')

<style>
/* Aquí están tus estilos de color, los mantuve intactos. */
.input-group-text {
    background-color: #800000 !important;
}
.form-control:focus {
    box-shadow: none;
}
.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
}
.form-control {
    border: none;
}
.card-header {
    background-color: #800000;
    color: white;
}
button[type="submit"] {
    padding: 15px;
    background-color: #800000;
    color: #ffffff;
    border: none;
    border-radius: 50px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
}
button[type="submit"]:hover {
    background-color: #d64e5e;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}
.alert {
    font-size: 0.9rem;
    margin-top: 0.5rem;
}
.table {
    margin-top: 1rem;
}

/* Las siguientes reglas son las que hacen el diseño responsivo sin afectar tus colores. */
@media(max-width: 768px) {
    .texto-tabla {
        font-size: 0.7em;
    }
    .table {
        font-size: 0.8rem;
    }
    th, td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 0.25rem;
    }
}

/* Esta regla fue eliminada en la solución anterior para evitar conflictos con Bootstrap. */
/* @media(max-width:1050px){
    .container div{
        flex-direction: column;
        margin: auto;
    }
} */
.text th, td{
    width:10rem;
}
</style>

<div class="container">
    <div class="card mt-3">
        <div class="card-header">Consulta de Horarios</div>
        <div class="card-body">
            {{ Form::open(['route' => 'horario.createHorario']) }}

            <div class="row mb-2">
                <div class="col-12 col-md-4 mb-2 mb-md-0">
                    <div class="input-group">
                        {{ Form::label("sede", 'Sede', ['class' => 'input-group-text text-light']) }}
                        {{Form::text("sede", $sede->descripcion , ["class" => "form-control rounded-end", "readonly" ])}}
                        {{Form::text("sede", $sede->id , ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        {{ Form::label("carrera_id", 'Carrera', ['class' => 'input-group-text text-light']) }}
                        {{Form::text("carrera_id", $carrera->descripcion , ["class" => "form-control rounded-end", "readonly" ])}}
                        {{Form::text("carrera_id", $carrera->id , ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="input-group">
                        {{ Form::label("resolucion_id", 'Resolución', ['class' => 'input-group-text text-light']) }}
                        {{Form::text("resolucion_id", $resolucion->resolucion ?? '' , ["class" => "form-control", "readonly" ])}}
                        {{Form::text("resolucion_id", $resolucion->id ?? '', ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 mb-2 mb-md-0">
                    <div class="input-group">
                        {{ Form::label("anio_id", 'Año', ['class' => 'input-group-text text-light']) }}
                        {{Form::text("anio_id", $anio->descripcion , ["class" => "form-control rounded-end", "readonly" ])}}
                        {{Form::text("anio_id", $anio->id , ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-2 mb-md-0">
                    <div class="input-group">
                        {{ Form::label("comision_id", 'Comisión', ['class' => 'input-group-text text-light']) }}
                        {{Form::text("comision_id", $comision->comision , ["class" => "form-control rounded-end", "readonly" ])}}
                        {{Form::text("comision_id", $comision->id , ["class" => "form-control", "hidden" ])}}
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        {{ Form::label("cuatrimestre_id", 'Modalidad', ['class' => 'input-group-text text-light']) }}
                        {{Form::select("cuatrimestre_id", [
                            '0' => 'Anual',
                            '1' => '1° Cuatrimestre',
                            '2' => '2° Cuatrimestre'
                        ], $cuatrimestre_id, ["class" => "form-control rounded-end", "disabled" ])}}
                    </div>
                </div>
            </div>
            
            {!!Form::close()!!}
        </div>
    </div>

    <div class="tablaScroll">
        <div class="table-responsive">
            <table class="table texto-tabla mb-0">
                <tr class="text-light text-center mb-0" style="background-color: #800000;">
                    <th class="text-left" scope="col">HORARIO</th>
                    @foreach($dias as $dia)
                    <th class="text-left" scope="col">{{$dia}}</th>
                    @endforeach
                </tr>
                
                @foreach($modulosHorarios as $modulosHorario)
                <tr>
                    <td class="bg-dark text-light text-center align-middle" style="background:#181818">{{$modulosHorario->horainicio}} a {{$modulosHorario->horafin}}</td>
                    @foreach($dias as $index=>$dia)
                    <td style="background:white;" class="">
                        @php ($a = 0)
                        @foreach($horarios as $horario)
                            @if($horario->dia == $index && $horario->moduloHorario->id == $modulosHorario->id )
                                @php ($a++)
                                <div class="text-center align-middle p-1">
                                    <strong class="h6 mb-1">{{$horario->materia->descripcion}}</strong>
                                    <p class="mb-3">{{$horario->profesor->apellido}}, {{$horario->profesor->nombre}} </p>
                                    <p class="mb-3">{{$horario->comentario}}</p>
                                </div>
                            @endif
                        @endforeach
                        @if($a == 0)
                            @php ($a++)
                            <div class="text-center py-4 m-auto">
                                <p class="align-middle px-auto">
                                    {{ Form::open(['route' => 'horario.createHorario']) }}
                                </p>
                            </div>
                            {{ Form::hidden("sede_id", $sede->id, ["hidden"])}}
                            {{ Form::hidden("carrera_id", $carrera->id, ["hidden"])}}
                            {{ Form::hidden("anio_id", $anio->id, ["hidden"])}}
                            {{ Form::hidden("comision_id", $comision->id, ["hidden"])}}
                            {{ Form::hidden("modulohorario_id", $modulosHorario->id, ["hidden"])}}
                            {{ Form::hidden("cuatrimestre_id", $cuatrimestre_id, ["hidden"])}}
                            {{ Form::hidden("dia", $index, ["hidden"])}}
                            {!!Form::close()!!}
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<p class='text-center mt-1 mb-1'>Estos horarios podr&iacute;an no ser los oficiales actuales del Instituto. En caso de duda pregunte al preceptor correspondiente a la carrera.</p>
@endsection