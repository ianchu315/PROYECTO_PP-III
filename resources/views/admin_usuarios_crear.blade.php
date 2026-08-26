<!-- // Permite crear un nuevo usuario completando todos sus datos personales, académicos y de contacto, asignando rol y foto de perfil, mostrando errores de validación y un botón para guardar el usuario. -->



@extends('layouts.dashboard_layout')

@section('content')
<section class="usuarios_crear_container">

    <div class="editar_oferta_boton_container">
        <button onclick="window.location.href='{{ route('bolsadetrabajo.usuarios') }}'">
            <i class="ri-arrow-left-line"></i> Volver a usuarios
        </button>
    </div>

    

    <form action="{{ route('bolsadetrabajo.usuarios.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="titulo_crear_usuario">
            <h1>Crear un usuario</h1>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" maxlength="17" pattern="[A-Za-z]*" class="@error('nombre') input-error @enderror">
                @error('nombre')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" maxlength="17" pattern="[A-Za-z]*" class="@error('apellido') input-error @enderror">
                @error('apellido')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" maxlength="50" class="@error('email') input-error @enderror">
                @error('email')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="@error('password') input-error @enderror">
                @error('password')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="dni">DNI</label>
                <input type="text" id="dni" name="dni" maxlength="15" pattern="[0-9]*" class="@error('dni') input-error @enderror">
                @error('dni')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input
                    type="date"
                    id="fecha_nacimiento"
                    name="fecha_nacimiento"
                    class="@error('fecha_nacimiento') input-error @enderror"
                    max="{{ \Carbon\Carbon::now()->subYears(17)->format('Y-m-d') }}">
                @error('fecha_nacimiento')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="genero">Género</label>
                <select id="genero" name="genero" class="@error('genero') input-error @enderror">
                    <option value="" selected disabled>Seleccionar</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="no binario">No Binario</option>
                    <option value="transgenero">Transgénero</option>
                    <option value="otro">Otro</option>
                    <option value="prefiero no decirlo">Prefiero no decirlo</option>
                </select>
                @error('genero')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="carrera_id">Carrera</label>
                <select id="carrera_id" name="carrera_id" class="@error('carrera_id') input-error @enderror">
                    <option value="">Seleccionar</option>
                    @foreach($carreras as $carrera)
                    <option value="{{ $carrera->id }}">{{ $carrera->descripcion }}</option>
                    @endforeach
                </select>
                @error('carrera_id')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror

            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="nacionalidad">Nacionalidad</label>
                <input type="text" id="nacionalidad" name="nacionalidad" class="@error('nacionalidad') input-error @enderror">
                @error('nacionalidad')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="ciudad_residencia">Ciudad de residencia</label>
                <input type="text" id="ciudad_residencia" name="ciudad_residencia" class="@error('ciudad_residencia') input-error @enderror">
                @error('ciudad_residencia')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion"  class="@error('descripcion') input-error @enderror"></textarea>
                @error('descripcion')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="telefono">Telefono</label>
                <input type="text" id="telefono" name="telefono"  maxlength="15" pattern="[0-9+ ]*" class="@error('telefono') input-error @enderror">
                @error('telefono')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="rol">Rol</label>
                <select id="rol" name="rol"  class="@error('rol') input-error @enderror">
                    <option value="usuario">Usuario</option>
                    <option value="administrador">Administrador</option>
                </select>
                @error('rol')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="sitio_web">Sitio web (dejar vacío si no tiene)</label>
                <input type="url" id="sitio_web" name="sitio_web" class="@error('sitio_web') input-error @enderror">
                @error('sitio_web')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_item">
            <label for="foto_perfil">Foto de perfil</label><br>
            <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" >
            @error('foto_perfil')
            <span class="error-mensaje">{{ $message }}</span>
            @enderror
        </div>


        <button class="editar_usuario_boton" type="submit">Guardar usuario</button>
    </form>
</section>
@endsection