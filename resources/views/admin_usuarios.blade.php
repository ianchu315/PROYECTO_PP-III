<!-- // Muestra la lista de usuarios con foto, nombre, rol, email, carrera y fecha de registro, e incluye búsqueda, filtrado por rol, creación, edición y eliminación de usuarios.
 -->


@extends('layouts.dashboard_layout')

@section('content')



<section class="usuarios_container">

    <h1 class="usuarios_title">Usuarios</h1>

    <form method="GET" action="{{ route('bolsadetrabajo.usuarios') }}" id="filtroForm" class="admin_ofertas_botones">

        {{-- Campo de búsqueda --}}
        <div class="campo-icono">
            <i class="ri-search-2-line"></i>
            <input type="text" name="busqueda" class="admin_ofertas_buscar" placeholder="Buscar por nombre, apellido o email" value="{{ request('busqueda') }}">
        </div>

        <div class="filtros_buscar_trabajo_busqueda_ordenar dropdown dropdown-container dropdown-container-admin usuario_admin_container">
            <div class="dropdown-toggle usuario_admin_toggle">
                <div>
                    <span class="dropdown-label">{{ ucfirst($rol ?? 'Seleccionar rol') }}</span>
                </div>
                <i class="ri-arrow-down-s-line flecha-dropdown"></i>
            </div>
            <div class="filtros_buscar_trabajo_busqueda_ordenar_opciones dropdown-menu oculto">
                <h3 class="dropdown-opcion" data-value="usuario">Usuario</h3>
                <h3 class="dropdown-opcion" data-value="administrador">Administrador</h3>

            </div>
        </div>
        <input type="hidden" name="rol" id="rolInput" value="{{ $rol ?? '' }}">







        <button type="button" class="btn-resetear-filtros" onclick="window.location.href='{{ route('bolsadetrabajo.usuarios') }}'">
            <i class="ri-refresh-line"></i> Limpiar filtros
        </button>


        <button type="button" class="admin_ofertas_crear" onclick="window.location.href='{{ route('bolsadetrabajo.usuarios.create') }}'">
            <i class="ri-add-line"></i> Nuevo usuario
        </button>



    </form>


    <div class="usuarios_cards_container">

        @foreach($usuarios as $usuario)
        <div class="usuario_item">
            <div class="usuario_item_foto_nombre_boton">
                <div class="usuario_foto_nombre">
                    <div class="usuario_item_foto">
                        <img src="{{ $usuario->foto_perfil ? url('perfil/' . $usuario->foto_perfil) : asset('images/user1.png') }}"
                                    width="120" alt="Foto de {{$usuario->nombre}} {{$usuario->apellido}}">

                    </div>
                    <div class="usuario_item_nombre_boton">
                        <h2>{{ $usuario->nombre }}</h2>
                        <h3>{{ $usuario->apellido }}</h3>
                        <p>{{ $usuario->rol }}</p>
                    </div>
                </div>
                <div class="usuario_item_boton">
                    <a href="{{ route('bolsadetrabajo.usuarios.edit', $usuario->id) }}">
                        <i class="ri-edit-box-line"></i>
                    </a>


                    <form action="{{ route('bolsadetrabajo.usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none;border:none;padding:0;cursor:pointer;">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                </div>
            </div>

            <p><i class="ri-mail-line"></i>{{ $usuario->email }}</p>
            <p><i class="ri-graduation-cap-line"></i>{{ $usuario->carrera->descripcion ?? 'Sin carrera' }}</p>

            <p><i class="ri-calendar-line"></i>Registrado el {{ $usuario->created_at->format('d/m/Y') }}</p>

        </div>
        @endforeach

    </div>

</section>







</section>



@endsection