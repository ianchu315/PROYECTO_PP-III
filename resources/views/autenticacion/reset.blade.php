@extends('layouts.autenticacion_layout')

@section('content')

<section class="inicio_sesion_container">
    <div class="registro_card recuperar_card reset_card">
        <div class="fluid-container">
            <img src="{{ asset('images/fluid-1.svg') }}" id="fluid" class="fluid-1">
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="registro-card-sin-fluid">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="registro_card_iconos_redireccion">
                <i class="ri-lock-2-line blanco-i"></i>
                <a href="/bolsadetrabajo/inicio">
                    <i class="ri-user-shared-line"></i>
                </a>
                
            </div>

            <div class="registro_card_titulo">
                <h1>Restablecer contraseña</h1>
            </div>

            <div class="registro_card_inputs">
                <div class="registro_card_inputs_item">
                    <input id="email" name="email" type="email" placeholder=" ">
                    <label for="email">Correo electrónico</label>
                </div>

                <div class="registro_card_inputs_item">
                    <input id="password" name="password" type="password" placeholder=" ">
                    <label for="password">Nueva contraseña</label><i class="ri-eye-off-line toggle-password" id="togglePassword"></i>
                </div>

                <div class="registro_card_inputs_item">
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder=" ">
                    <label for="password_confirmation">Confirmar contraseña</label><i class="ri-eye-off-line toggle-password" id="togglePasswordConfirm"></i>
                </div>

                <div class="registro_card_botones">
                    <button type="submit">Cambiar contraseña <i class="ri-lock-unlock-line"></i></button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Toggle contraseña ---
        const togglePassword = document.getElementById("togglePassword");
        const password = document.getElementById("password");
        togglePassword.addEventListener("click", () => {
            const type = password.type === "password" ? "text" : "password";
            password.type = type;
            togglePassword.classList.toggle("ri-eye-off-line");
            togglePassword.classList.toggle("ri-eye-line");
        });

        const togglePasswordConfirm = document.getElementById("togglePasswordConfirm");
        const passwordConfirm = document.getElementById("password_confirmation");
        togglePasswordConfirm.addEventListener("click", () => {
            const type = passwordConfirm.type === "password" ? "text" : "password";
            passwordConfirm.type = type;
            togglePasswordConfirm.classList.toggle("ri-eye-off-line");
            togglePasswordConfirm.classList.toggle("ri-eye-line");
        });
    });
</script>


@endsection
