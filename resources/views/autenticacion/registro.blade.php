@extends('layouts.autenticacion_layout')

@section('content')

<style>
    /* Ajustes para que el registro no quede amontonado y el select de carrera se vea bien */
    .registro_card { height: auto; min-height: 640px; }
    .registro_card_inputs { gap: 26px; }

    .registro_card_select { display: flex; flex-direction: column; gap: 6px; }
    .registro_card_select label { color: #700101; font-size: 14px; }
    .registro_card_select select {
        border: none;
        border-bottom: 2px solid #700101;
        background: transparent;
        padding: 8px 0 4px 0;
        font-size: 14px;
        outline: none;
        color: #333;
    }
</style>

<section class="registro_container">

    <div class="registro_card">
        <div class="fluid-container">
            <img src="{{ asset('images/fluid-1.svg') }}" id="fluid" class="fluid-1">
        </div>

        <form method="POST" action="{{ route('bolsadetrabajo.registro.store') }}" class="registro-card-sin-fluid">
            @csrf
            <div class="registro_card_iconos_redireccion">
                <i class="ri-user-add-line blanco-i"></i>
                <a href="/bolsadetrabajo/inicio">
                    <i class="ri-user-shared-line"></i>
                </a>
            </div>

            <div class="registro_card_titulo">
                <h1>Creá una cuenta</h1>
            </div>

            <div class="registro_card_inputs">

                <div class="registro_card_select">
                    <label for="carrera_id">Carrera</label>
                    <select id="carrera_id" name="carrera_id">
                        <option value="">-- Seleccioná tu carrera --</option>
                        @foreach ($carreras as $carrera)
                            <option value="{{ $carrera->id }}" {{ old('carrera_id') == $carrera->id ? 'selected' : '' }}>
                                {{ $carrera->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="registro_card_inputs_grupo">
                    <div class="registro_card_inputs_item">
                        <input id="nombre" name="nombre" type="text" placeholder=" " value="{{ old('nombre') }}">
                        <label for="nombre">Nombre</label>
                    </div>
                    <div class="registro_card_inputs_item">
                        <input id="apellido" name="apellido" type="text" placeholder=" " value="{{ old('apellido') }}">
                        <label for="apellido">Apellido</label>
                    </div>
                    <div class="registro_card_inputs_item">
                        <input id="dni" name="dni" type="text" placeholder=" " inputmode="numeric"
                             maxlength="8" value="{{ old('dni') }}" autocomplete="off">
                    <label for="dni">Documento</label>
                    </div>
                </div>

                <div class="registro_card_inputs_item">
                    <input id="correo" name="email" type="email" placeholder=" " value="{{ old('email') }}" autocomplete="new-email">
                    <label for="correo">Correo electrónico</label>
                </div>

                <div class="registro_card_inputs_item">
                    <input id="password" name="password" type="password" placeholder=" " autocomplete="new-password">
                    <label for="password">Contraseña</label>
                    <i class="ri-eye-off-line toggle-password" id="togglePassword"></i>
                </div>

                <div class="registro_card_inputs_item">
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder=" " autocomplete="new-password">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <i class="ri-eye-off-line toggle-password" id="togglePasswordConfirm"></i>
                </div>

                <span id="password-match" style="display:none; color:#c0392b; font-size:13px;">Las contraseñas no coinciden</span>

            </div>

            <div class="registro_card_botones">
                <button type="submit">
                    Registrarse <i class="ri-check-double-line"></i>
                </button>
                <button type="button" onclick="window.location.href='{{ route('bolsadetrabajo.iniciar-sesion') }}'"
                    class="registro_boton_iniciar_sesion">
                    Iniciar sesión <i class="ri-corner-down-right-fill"></i>
                </button>
            </div>

        </form>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const togglePassword = document.getElementById("togglePassword");
        const password = document.getElementById("password");
        togglePassword.addEventListener("click", () => {
            password.type = password.type === "password" ? "text" : "password";
            togglePassword.classList.toggle("ri-eye-off-line");
            togglePassword.classList.toggle("ri-eye-line");
            // Formateo de DNI: solo 8 dígitos, con puntos automáticos (12.345.678)
        const dniInput = document.getElementById("dni");
        dniInput.addEventListener("input", () => {
        let digits = dniInput.value.replace(/\D/g, "").slice(0, 8);
        dniInput.value = digits.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });

        const togglePasswordConfirm = document.getElementById("togglePasswordConfirm");
        const passwordConfirm = document.getElementById("password_confirmation");
        togglePasswordConfirm.addEventListener("click", () => {
            passwordConfirm.type = passwordConfirm.type === "password" ? "text" : "password";
            togglePasswordConfirm.classList.toggle("ri-eye-off-line");
            togglePasswordConfirm.classList.toggle("ri-eye-line");
        });

        const passwordMatchMsg = document.getElementById("password-match");
        const form = document.querySelector("form");

        function validatePasswords() {
            if (passwordConfirm.value && password.value !== passwordConfirm.value) {
                passwordMatchMsg.style.display = "block";
                return false;
            }
            passwordMatchMsg.style.display = "none";
            return true;
        }

        password.addEventListener("input", validatePasswords);
        passwordConfirm.addEventListener("input", validatePasswords);

        form.addEventListener("submit", (e) => {
            if (!validatePasswords()) {
                e.preventDefault();
                passwordConfirm.setCustomValidity("Las contraseñas no coinciden");
                passwordConfirm.reportValidity();
            } else {
                passwordConfirm.setCustomValidity("");
            }
        });

        const inputs = document.querySelectorAll(".registro_card_inputs_item input");
        const container = document.querySelector(".registro_card_inputs");
        inputs.forEach(input => {
            input.addEventListener("focus", () => container.classList.add("inputs-activos"));
            input.addEventListener("blur", () => {
                if (![...inputs].some(i => i === document.activeElement)) {
                    container.classList.remove("inputs-activos");
                }
            });
        });
    });
</script>

@endsection