<div class="tabla table-responsive">
    <style>
        tr td {
            text-align: center;
            vertical-align: middle;
        }

        @media (max-width: 768px) {
            table td a,
            table td button {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>

    <table id="tabla-registros" class="table table-dark table-striped align-middle">

        <thead class="table-dark text-light">
            <tr>
                <th>N°</th>
                <th>Día y Hora</th>
                <th>DNI</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Carrera</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($registros as $registro)
                <tr>
                    @php $date = new DateTime($registro->dia_hora); @endphp
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $date->format('d-m H:i') }}</td>
                    <td>{{ $registro->dni }}</td>
                    <td>
                        <img src="{{ url('foto/' . $registro->foto) }}" 
                             alt="Foto aspirante" class="img-thumbnail" width="70" height="70">
                    </td>
                    <td>{{ $registro->nombre }}</td>
                    <td>{{ $registro->apellido }}</td>

                    {{-- Carrera --}}
                    @php $variable = ''; @endphp
                    <select style="display: none" disabled class="form-select form-select-sm">
                        @foreach ($carreras as $carrera)
                            <option value="{{ $carrera->id }}"
                                {{ $registro->carrera_id == $carrera->id ? 'selected' : '' }}>
                                {{ $carrera->descripcion }}
                                {{ $registro->carrera_id == $carrera->id ? ($variable = $carrera->descripcion) : '' }}
                            </option>
                        @endforeach
                    </select>
                    <td>{{ $variable }}</td>

                    {{-- Botones de acción --}}
                    <td style="min-width: 180px">
                        <a href="{{ route('registro.editar', $registro->id) }}" 
                           class="btn btn-primary btn-sm" title="Editar">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        @if (Auth::user()->is_admin == 1)
                            <button type="button" class="btn btn-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modal{{ $registro->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal de confirmación de borrado --}}
@foreach ($registros as $registro)
    <div class="modal fade" id="modal{{ $registro->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <strong>DNI:</strong> {{ number_format($registro->dni, 0, ',', '.') }} 
                    ({{ $registro->nombre }} {{ $registro->apellido }})<br>
                    ¿Estás seguro de que deseas eliminar a este usuario?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                    <form action="{{ route('registro.eliminar', $registro->id) }}" class="d-inline" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger" title="Eliminar">
                            Eliminar <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
