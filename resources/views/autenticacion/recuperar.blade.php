@extends('layouts.autenticacion_layout')

@section('content')

<section class="inicio_sesion_container">
    <div class="registro_card recuperar_card">
        <div class="fluid-container">
            <img src="{{ asset('images/fluid-1.svg') }}" id="fluid" class="fluid-1">
        </div>

        <form action="{{ route('password.email') }}" method="POST" class="registro-card-sin-fluid">
            @csrf

            <div class="registro_card_iconos_redireccion">
                <i class="ri-lock-2-line blanco-i"></i>
                <a href="/bolsadetrabajo/inicio">
                    <i class="ri-user-shared-line"></i>
                </a>
                
            </div>

            <div class="registro_card_titulo">
                <h1>Recuperar contraseña</h1>
            </div>

            <div class="registro_card_inputs inicio_card_inputs recuperar_card_inputs">
                <div class="registro_card_inputs_item">
                    <input id="email" name="email" type="email" placeholder=" " required autocomplete="new-email">
                    <label for="email">Correo electrónico</label>
                </div>

                <div class="registro_card_botones">
                    <button type="submit">Enviar enlace <i class="ri-mail-send-line"></i></button>
                    <button type="button" onclick="window.location.href='/bolsadetrabajo/inicio'">
                        Volver al inicio <i class="ri-arrow-go-back-line"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>
</section>

@endsection