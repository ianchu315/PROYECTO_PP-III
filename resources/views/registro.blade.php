<!-- // Vista de registro de usuario que incluye formulario con campos de nombre, apellido, email y contraseña, validación de coincidencia de contraseñas, toggle de visibilidad de contraseña y botones para registrarse o ir a iniciar sesión.
 -->



@extends('layouts.autenticacion_layout')

@section('content')

<section class="registro_container">


    <div class="registro_card">
        <div class="fluid-container">
            <img src="{{ asset('images/fluid-1.svg') }}" id="fluid" class="fluid-1">
        </div>

        <form method="POST" action="{{ route('frontend.carreras.index') }}" class="registro-card-sin-fluid">
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
                <div class="registro_card_inputs_item">
                    <label for="rol">Tipo de usuario</label>
                    <select id="rol" name="rol">
                        <option value="usuario" {{ old('rol') == 'usuario' ? 'selected' : '' }}>Alumno</option>
                        <option value="profesor" {{ old('rol') == 'profesor' ? 'selected' : '' }}>Profesor</option>
                    </select>
                </div>
                <div class="registro_card_inputs_item" id="grupo_carrera">
                    <label for="carrera_id">Carrera que estás cursando</label>
                    <select id="carrera_id" name="carrera_id">
                        <option value="">Seleccioná tu carrera</option>
                        @foreach($carreras as $carrera)
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
        // --- Mostrar/ocultar carrera según el tipo de usuario ---
        const rolSelect = document.getElementById("rol");
        const grupoCarrera = document.getElementById("grupo_carrera");
        const carreraSelect = document.getElementById("carrera_id");

        function actualizarCarrera() {
            if (rolSelect.value === "profesor") {
                grupoCarrera.style.display = "none";
                carreraSelect.removeAttribute("required");
            } else {
                grupoCarrera.style.display = "";
                carreraSelect.setAttribute("required", "required");
            }
        }

        rolSelect.addEventListener("change", actualizarCarrera);
        actualizarCarrera();

        // --- Toast error ---
        let toast = document.getElementById("toast-error");
        if (toast) {
            setTimeout(() => toast.classList.add("hide"), 3000);
        }

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

        // --- Validación de coincidencia ---
        const passwordMatchMsg = document.getElementById("password-match");
        const form = document.querySelector("form");

        function validatePasswords() {
            if (passwordConfirm.value && password.value !== passwordConfirm.value) {
                passwordMatchMsg.style.display = "block";
                return false;
            } else {
                passwordMatchMsg.style.display = "none";
                return true;
            }
        }

        password.addEventListener("input", validatePasswords);
        passwordConfirm.addEventListener("input", validatePasswords);

        form.addEventListener("submit", (e) => {
            if (!validatePasswords()) {
                e.preventDefault();
            }
        });
    });
    const password = document.getElementById("password");
    const passwordConfirm = document.getElementById("password_confirmation");
    const form = document.querySelector("form");

    // Cada vez que se escriba en el input de confirmación
    passwordConfirm.addEventListener("input", () => {
        if (passwordConfirm.value !== password.value) {
            // Si no coinciden, mostramos un mensaje de error nativo
            passwordConfirm.setCustomValidity("Las contraseñas no coinciden");
        } else {
            // Si coinciden, quitamos el mensaje de error
            passwordConfirm.setCustomValidity("");
        }
    });

    // También validamos al enviar el formulario
    form.addEventListener("submit", (e) => {
        if (passwordConfirm.value !== password.value) {
            e.preventDefault(); // bloquea el submit
            passwordConfirm.reportValidity(); // muestra el mensaje nativo
        }
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