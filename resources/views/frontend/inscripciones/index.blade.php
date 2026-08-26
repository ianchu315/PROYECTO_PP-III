@extends('frontend.layout.main')
@section('title', 'Inscripciones')
@section('content')

    <div class="links">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
            </div>
        @endif
  <!-- <div class=" alert alert-light text-center text-danger"><h2>INGRESO 2025 </h2></div> -->
 
     {{--   {!! $html !!} 
        {!! $html2 !!}  --}}
   
        <br>
        <!-- <a class='btn btn-outline-dark form-control ' href='http://www.isft38.edu.ar/inscripciones/controlar/dni'>Validar Turno para Pre-inscripción</a> -->
      {{--   <div class=" alert alert-warning text-center">Si no hay turnos disponibles, podés anotarte en la
            <a class="text-primary" href="{{ route('lista.espera') }}">Lista de Espera</a>
        </div> --}}
       
       
    </div>
@endsection
