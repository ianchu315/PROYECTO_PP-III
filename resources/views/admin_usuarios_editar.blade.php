<!-- // Permite editar los datos de un usuario existente, incluyendo nombre, apellido, email, contraseña, DNI, fecha de nacimiento, género, carrera, nacionalidad, ciudad, descripción, teléfono, rol, sitio web y foto de perfil, mostrando errores de validación y un botón para guardar los cambios.
 -->


@extends('layouts.dashboard_layout')

@section('content')


<section class="usuarios_container usuarios_container_editar">

    <div class="editar_oferta_boton_container">
        <button onclick="window.location.href='/bolsadetrabajo/usuarios'"><i class="ri-arrow-left-line"></i>Volver a usuarios</button>
    </div>

    

    <form action="{{ route('bolsadetrabajo.usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="titulo_crear_usuario">
            <h1>Editar Usuario</h1>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ $usuario->nombre }}" maxlength="17"  class="@error('nombre') input-error @enderror">
                @error('nombre')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="{{ $usuario->apellido }}" maxlength="17" class="@error('apellido') input-error @enderror">
                @error('apellido')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $usuario->email }}" maxlength="50"  class="@error('email') input-error @enderror">
                @error('email')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="password">Contraseña (dejar vacío para no cambiar)</label>
                <input type="password" id="password" name="password" class="@error('password') input-error @enderror">
                @error('password')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="dni">DNI</label>
                <input type="text" id="dni" name="dni" value="{{ $usuario->dni }}" maxlength="8" class="@error('dni') input-error @enderror">
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
                    value="{{ $usuario->fecha_nacimiento }}"
                    max="{{ \Carbon\Carbon::now()->subYears(17)->format('Y-m-d') }}"
                    class="@error('fecha_nacimiento') input-error @enderror"
                    >
                @error('fecha_nacimiento')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="genero">Género</label>
                <select id="genero" name="genero" class="@error('genero') input-error @enderror">
                    <option value="" disabled>Seleccionar</option>
                    <option value="masculino" {{ $usuario->genero === 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ $usuario->genero === 'femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="no binario" {{ $usuario->genero === 'no binario' ? 'selected' : '' }}>No Binario</option>
                    <option value="transgenero" {{ $usuario->genero === 'transgenero' ? 'selected' : '' }}>Transgénero</option>
                    <option value="otro" {{ $usuario->genero === 'otro' ? 'selected' : '' }}>Otro</option>
                    <option value="prefiero no decirlo" {{ $usuario->genero === 'prefiero no decirlo' ? 'selected' : '' }}>Prefiero no decirlo</option>
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
                    <option value="{{ $carrera->id }}" {{ $usuario->carrera_id == $carrera->id ? 'selected' : '' }}>
                        {{ $carrera->descripcion }}
                    </option>
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
                <input type="text" id="nacionalidad" name="nacionalidad" value="{{ $usuario->nacionalidad }}" maxlength="30" class="@error('nacionalidad') input-error @enderror">
                @error('nacionalidad')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="ciudad_residencia">Ciudad de residencia</label>
                <input type="text" id="ciudad_residencia" name="ciudad_residencia" value="{{ $usuario->ciudad_residencia }}" class="@error('ciudad_residencia') input-error @enderror">
                @error('ciudad_residencia')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion"  class="@error('descripcion') input-error @enderror">{{ $usuario->descripcion }}</textarea>
                @error('descripcion')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="telefono">Teléfono</label>
                <input type="number" id="telefono" name="telefono" value="{{ $usuario->telefono }}" maxlength="15" class="@error('telefono') input-error @enderror">
                @error('telefono')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_grupo">
            <div class="editar_oferta_item">
                <label for="rol">Rol</label>
                <select id="rol" name="rol" class="@error('rol') input-error @enderror">
                    <option value="usuario" {{ $usuario->rol === 'usuario' ? 'selected' : '' }}>Usuario</option>
                    <option value="administrador" {{ $usuario->rol === 'administrador' ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('rol')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
            <div class="editar_oferta_item">
                <label for="sitio_web">Sitio web</label>
                <input type="url" id="sitio_web" name="sitio_web" value="{{ $usuario->sitio_web }}" class="@error('sitio_web') input-error @enderror">
                @error('sitio_web')
                <span class="error-mensaje">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="editar_oferta_item">
            <label>Foto actual:</label><br>
            @if ($usuario->foto_perfil)
            <img src="{{ asset('storage/usuarios/' . $usuario->foto_perfil) }}" alt="Foto actual" width="100">
            @else
            <p>No hay foto cargada.</p>
            @endif

            <br><label for="nueva_foto">Cambiar foto de perfil:</label>
            <input type="file" name="nueva_foto" id="nueva_foto" accept="image/*" class="@error('nueva_foto') input-error @enderror">
            @error('nueva_foto')
            <span class="error-mensaje">{{ $message }}</span>
            @enderror
        </div>


        <button class="editar_usuario_boton" type="submit">Guardar cambios</button>
    </form>


    @endsection