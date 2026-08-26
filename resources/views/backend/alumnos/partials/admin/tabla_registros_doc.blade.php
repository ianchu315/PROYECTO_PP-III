<div class="tabla table-responsive">
    <style>
        tr td {
            text-align: center;
            vertical-align: middle;
        }

        .valor_booleano6:checked {
            background-color: #40fd0d;
            border-color: #40fd0d;
        }

        /* Opcional: mejora visual en móviles */
        @media (max-width: 768px) {
            table td button {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>

    <table id="tabla-registros" class="table table-dark table-striped align-middle">

        <thead class="table-dark text-light">
            <tr>
                <th>Día y Hora</th>
                <th>DNI</th>
                <th>Fotocopia de dni</th>
                <th>Fotocopia de título</th>
                <th>Certificado de secundaria</th>
                <th>Foto</th>
                <th>Partida de nacimiento</th>
                <th>INSCRIPTO</th>
                <th>Legajo</th>
                <th>Inscripción</th>
                <th>Solicitud Alumno</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($registros as $registro)
                <tr>
                    @php $date = new DateTime($registro->dia_hora); @endphp
                    <td>{{ $date->format('d-m H:i') }}</td>
                    <td>{{ $registro->dni }}</td>

                    {{-- Fotocopia DNI --}}
                    <td>
                        <form class="cambiar-booleano-form"
                              action="{{ route('check.fotoc.dni', ['id' => $registro->id]) }}"
                              method="POST">
                            @csrf @method('PUT')
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input type="checkbox" name="valor_booleano"
                                       class="valor_booleano form-check-input"
                                       {{ $registro->fotoc_dni_ok ? 'checked' : '' }}>
                            </div>
                        </form>
                    </td>

                    {{-- Fotocopia Título --}}
                    <td>
                        <form class="cambiar-booleano-form2"
                              action="{{ route('check.fotoc.titulo', ['id' => $registro->id]) }}"
                              method="POST">
                            @csrf @method('PUT')
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input type="checkbox" name="valor_booleano2"
                                       class="valor_booleano2 form-check-input"
                                       {{ $registro->fotoc_titulo_ok ? 'checked' : '' }}>
                            </div>
                        </form>
                    </td>

                    {{-- Certificado Secundaria --}}
                    <td>
                        <form class="cambiar-booleano-form3"
                              action="{{ route('check.certif.secund', ['id' => $registro->id]) }}"
                              method="POST">
                            @csrf @method('PUT')
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input type="checkbox" name="valor_booleano3"
                                       class="valor_booleano3 form-check-input"
                                       {{ $registro->certificado_sec_ok ? 'checked' : '' }}>
                            </div>
                        </form>
                    </td>

                    {{-- Foto --}}
                    <td>
                        <form class="cambiar-booleano-form4"
                              action="{{ route('check.foto', ['id' => $registro->id]) }}"
                              method="POST">
                            @csrf @method('PUT')
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input type="checkbox" name="valor_booleano4"
                                       class="valor_booleano4 form-check-input"
                                       {{ $registro->foto_ok ? 'checked' : '' }}>
                            </div>
                        </form>
                    </td>

                    {{-- Partida de Nacimiento --}}
                    <td>
                        <form class="cambiar-booleano-form5"
                              action="{{ route('check.part.nac', ['id' => $registro->id]) }}"
                              method="POST">
                            @csrf @method('PUT')
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input type="checkbox" name="valor_booleano5"
                                       class="valor_booleano5 form-check-input"
                                       {{ $registro->partida_nac_ok ? 'checked' : '' }}>
                            </div>
                        </form>
                    </td>

                    {{-- Inscripto --}}
                    <td>
                        <form class="cambiar-booleano-form6"
                              action="{{ route('check.confirmado', ['id' => $registro->id]) }}"
                              method="POST">
                            @csrf @method('PUT')
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input type="checkbox" name="valor_booleano6"
                                       class="valor_booleano6 form-check-input"
                                       {{ $registro->confirmado ? 'checked' : '' }}
                                       onclick="if (!confirm('¿Está seguro de modificar la Inscripción?')) return false;">
                            </div>
                        </form>
                    </td>

                    {{-- Botones de acción --}}
                    <td>
                        {{ Form::model($registro, ['method' => 'get', 'route' => ['legajo', 'id' => $registro->id]]) }}
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            Descargar Legajo
                        </button>
                        {!! Form::close() !!}
                    </td>

                    <td>
                        {{ Form::model($registro, ['method' => 'get', 'route' => ['solic', 'id' => $registro->id]]) }}
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            Descargar Inscripción
                        </button>
                        {!! Form::close() !!}
                    </td>

                    <td>
                        {{ Form::model($registro, ['method' => 'get', 'route' => ['solic.alumno', 'hash' => $registro->hash]]) }}
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            Descargar Solicitud
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
