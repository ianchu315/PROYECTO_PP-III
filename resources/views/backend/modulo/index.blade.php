@extends('backend.layouts.main')

@section('title', 'Módulo horario')

@section('content')
<div class="container-fluid">
    @if(Session::has('status'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ Session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @forelse($modulos as $modulo)
    @if($loop->first)
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th class="ps-4">Hora de inicio</th>
                    <th>Hora de finalización</th>
                    <th>Duración (min)</th>
                    <th>
                        <a href="{{ route('modulo.create') }}" class="btn btn-success d-flex align-items-center gap-1">
                            <img src="{{ asset('svg/new.svg') }}" height="20" width="20" alt="Crear" title="Crear">
                            Crear módulo
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @endif

                <tr>
                    <td class="ps-4">{{ $modulo->horainicio }}</td>
                    <td>{{ $modulo->horafin }}</td>
                    <td>{{ $modulo->duracion }}</td>
                    <td>
                        <div class="d-flex flex-wrap justify-content-end gap-1">
                            <a href="{{ route('modulo.edit', $modulo->id) }}" class="btn btn-primary">
                                <img src="{{ asset('svg/edit.svg') }}" width="20" height="20" alt="Editar" title="Editar">
                            </a>
                            {{ Form::model($modulo, [ 'method' => 'delete', 'route' => ['modulo.destroy', $modulo->id] ]) }}
                            @csrf
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('¿Está seguro de borrar el módulo?')">
                                <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar" title="Borrar">
                            </button>
                            {!!Form::close()!!}
                        </div>
                    </td>
                </tr>

                @if($loop->last)
            </tbody>
        </table>
    </div>
    @endif

    @empty
    <a href="{{ route('modulo.create') }}" class="btn btn-success d-flex align-items-center gap-1">
        <img src="{{ asset('svg/new.svg') }}" height="20" width="20" alt="Crear" title="Crear">
        Crear módulo
    </a>
    @endforelse
</div>
@endsection
