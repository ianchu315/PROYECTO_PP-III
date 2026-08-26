@extends('backend.layouts.main')
@section('content')


<!-- Listado de Profesores a los cuales corresponde cada materia, creado a modo de guía para el MÓDULO de "Presidentes"-->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container mt-4">

    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-light text-center align-middle">
            <tr>
                <th>Materia</th>
                <th>Titular</th>

            </tr>
        </thead>
        <tbody class="align-middle">
            @foreach($materias as $materia)
                <tr>
                    <!--Llama a la variable materia, pidiendo su descripción-->
                    <td>{{ $materia->descripcion }}</td>
                    <!--Enlaza la variable materia con profesor pidiendo su nombre, lo mismo con el apellido. En caso de no existir un dato coloca "Sin nombre" o "Sin apellido"-->
                    <td class="align-middle">{{ $materia->deProfesor->nombre??'sin nombre'}} {{ $materia->deProfesor->apellido??'sin apellido'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection