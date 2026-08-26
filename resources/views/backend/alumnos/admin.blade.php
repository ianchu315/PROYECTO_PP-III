@extends('backend.layouts.main')

<link rel="shortcut icon" type="image/png" href="{{ asset('/img/logo1.png') }}">
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

<!-- Bootstrap + estilos -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="style/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('title', 'Inscripciones')
@section('content')

    <div class="container-fluid my-4">

        {{-- Mensajes de alerta --}}
        @if (session('mensaje2'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Atención!</strong> {{ session('mensaje2') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        {{-- Barra de filtros responsive --}}
        <div class="row bg-light p-3 rounded shadow-sm">
            {{ Form::open(['route' => 'ir_admin_post', 'method' => 'POST', 'class' => 'w-100']) }}
            <div class="row gy-2 gx-2 align-items-center">

                {{-- Botones de acceso rápido --}}
                <div class="col-12 col-md-auto d-flex flex-wrap gap-2">
                    <a href="{{ route('ir_admin') }}" class="btn btn-success">Hoy</a>
                    <a href="{{ route('inscripcion', 'admin') }}" class="btn btn-danger">Sin Turno</a>
                    <a href="{{ route('ir_admin', 'todos') }}" class="btn btn-primary">Todos</a>
                </div>

                {{-- Filtros --}}
                <div class="col-12 col-md d-flex flex-wrap gap-2">
                    <div class="input-group">
                        <span class="input-group-text">DNI</span>
                        {{ Form::number('dni', old('dni'), ['class' => 'form-control', 'placeholder' => '']) }}
                    </div>

                    <div class="input-group">
                        <span class="input-group-text">Fecha</span>
                        {{ Form::date('fecha', old('fecha'), ['class' => 'form-control']) }}
                    </div>

                    <div class="input-group">
                        <span class="input-group-text">Carrera</span>
                        {{ Form::select('carrera_id', $carreras_sel, null, ['class' => 'form-select', 'placeholder' => '']) }}
                    </div>
                </div>

                {{-- Botón buscar --}}
                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-primary w-100">
                        Buscar <i class="fa fa-search"></i>
                    </button>
                </div>

            </div>
            {!! Form::close() !!}
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                    type="button" role="tab">Pre-Inscriptos</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                    type="button" role="tab">Documentación</button>
            </li>
        </ul>

        <div class="tab-content p-3 bg-white shadow-sm rounded-bottom" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                @include('backend/alumnos/partials/admin/tabla_registros')
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                @include('backend/alumnos/partials/admin/tabla_registros_doc')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/admin.js"></script>
@endsection
