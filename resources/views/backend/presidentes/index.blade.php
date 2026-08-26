@extends('backend.layouts.main')
@section('content')

    <!--If que muestra los avisos exitosos de creacion o modificación-->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif  

    @if(session('deleted'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('deleted') }}",
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                backdrop: true,
                position: 'center',
                background: '#e6fff2',
                color: '#155724',
                customClass: {
                    popup: 'swal2-popup-custom'
                }
            });
        });
    </script>
    @endif

<div class="container mt-4">

    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-light text-center align-middle">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Carrera</th>
                <th>Materia</th>
                <th>Horario</th>
                <th colspan="2">
                    <a class="btn btn-success d-flex align-items-center justify-content-center gap-2" href="{{ route('presidentes.create') }}">
                        <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
                        Crear Presidente
                    </a>
                </th>
            </tr>
        </thead>
        <tbody class="align-middle">

            <!--Tabla donde llama a las variables de cada columna correspondiente-->
            @foreach($presidentes as $presidente)
                <tr>
                    <td>{{ $presidente->nombre->nombre }}</td>
                    <td>{{ $presidente->apellido->apellido }}</td>
                    <td>{{ $presidente->carrera->descripcion }}</td>
                    <td>{{ $presidente->materia->descripcion }}</td>
                    <td>{{ $presidente->horario }}</td>

                    <!--Boton que permite editar la fila sleccionada-->
                    <td class="text-center">
                        <a href="{{ route('presidentes.edit', $presidente->id) }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                            <img src="{{ asset('svg/edit.svg') }}" width="18" height="18" alt="Editar" title="Editar">
                            Editar
                        </a>
                    </td>

                    <!--Boton que permite eliminar la fila sleccionada-->
                    <td class="text-center">
                        <form action="{{ route('presidentes.destroy', $presidente->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este presidente?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-2">
                                <img src="{{ asset('svg/delete.svg') }}" width="18" height="18" alt="Eliminar" title="Eliminar">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
