<!-- // Vista de inicio de sesión que incluye formulario con campos de email y contraseña, toggle de visibilidad de contraseña y botones para iniciar sesión, registrarse o recuperar contraseña.

 -->


@extends('layouts.autenticacion_layout')

@section('content')





<section class="inicio_sesion_container">


    <div class="registro_card inicio_card">
        <div class="fluid-container">
            <img src="{{ asset('images/fluid-1.svg') }}" id="fluid" class="fluid-1">
        </div>

        <form action="{{ route('bolsadetrabajo.iniciar-sesion.procesar') }}" method="POST" class="registro-card-sin-fluid">
            @csrf
            <div class="registro_card_iconos_redireccion">


                <i class="ri-user-shared-line  blanco-i"></i>


                <a href="/bolsadetrabajo/registro">
                    <i class="ri-user-add-line" ></i>
                    
                </a>




            </div>

            <div class="registro_card_titulo">
                <h1>Iniciá sesión</h1>
            </div>

            <input type="hidden" name="redirect" value="{{ request('redirect') }}">

            <div class="registro_card_inputs inicio_card_inputs">

                <div class="registro_card_inputs_item">
                    <input id="email" name="email" type="email" placeholder=" " value="{{ old('email') }}" autocomplete="new-email">
                    <label for="email">Correo electrónico</label>

                </div>
                <div class="registro_card_inputs_item">
                    <input id="password" name="password" type="password" placeholder=" " autocomplete="new-password">
                    <label for="password">Contraseña</label> <i class="ri-eye-off-line toggle-password" id="togglePassword"></i>

                </div>

                <div class="registro_card_botones">
                    <button type="submit">Iniciar sesión <i class="ri-check-double-line"></i></button>
                    <div class="inicio_sesion_botones_grupo">
                        <button type="button" onclick="window.location.href='/bolsadetrabajo/registro'" class="registro_boton_iniciar_sesion">Registrarse <i class="ri-corner-down-right-fill"></i></button>
                        <button type="button" onclick="window.location.href='/bolsadetrabajo/recuperar'" class="registro_boton_iniciar_sesion">
                            Recuperar contraseña <i class="ri-lock-2-line"></i>
                        </button>

                    </div>
                </div>
            </div>
        </form>


    </div>






</section>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Cambiar ícono
            this.classList.toggle('ri-eye-off-line');
            this.classList.toggle('ri-eye-line');
        });
    });


    document.addEventListener("DOMContentLoaded", () => {
        const inputs = document.querySelectorAll(".registro_card_inputs_item input");
        const container = document.querySelector(".registro_card_inputs");

        inputs.forEach(input => {
            input.addEventListener("focus", () => {
                container.classList.add("inputs-activos");
            });

            input.addEventListener("blur", () => {
                // Si ningún input sigue enfocado, se saca la clase
                if (![...inputs].some(i => i === document.activeElement)) {
                    container.classList.remove("inputs-activos");
                }
            });
        });
    });
</script>







@endsection