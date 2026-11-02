@extends('layouts.autenticacion_layout')

@section('content')
<section class="inicio_sesion_container">
    <div class="registro_card">
        <h1>Recuperar Contraseña</h1>
        <p>Ingresa tu correo electrónico y te enviaremos un link para restablecer tu contraseña.</p>

        <form action="{{ route('bolsadetrabajo.recuperar-contraseña.enviar') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Tu correo">
            <button type="submit">Enviar correo</button>
        </form>


        <button type="button" onclick="window.location.href='{{ route('bolsadetrabajo.iniciar-sesion') }}'">
            Volver al inicio de sesión
        </button>
    </div>
</section>
@endsection