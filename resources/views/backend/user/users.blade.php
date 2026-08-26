@extends('backend.layouts.main')
@section('title', 'Usuarios')
@section('content')

<div class="descripciones">

  @if($users->count())
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover align-middle">
        <thead>
          <tr>
            <th class="align-middle">Usuario</th>
            <th class="align-middle">Email</th>
            <th class="text-end align-middle">
              <a class="btn btn-success" href="{{ route('users.create') }}">
                <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
                Crear Usuario
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
            <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td class="text-end">
                {{ Form::model($user, [ 'method' => 'delete' , 'route' => ['users.destroy', $user->id] ]) }}
                @csrf
                <a href="{{ route('users.show', ['user' => $user->id ]) }}" class="btn btn-info">
                  <img src="{{ asset('svg/show.svg') }}" width="20" height="20" alt="Mostrar" title="Mostrar">
                </a>
                <a href="{{ route('users.edit', ['user' => $user->id ]) }}" class="btn btn-primary">
                  <img src="{{ asset('svg/edit.svg') }}" width="20" height="20" alt="Editar" title="Editar">
                </a>
                <button type="submit" class="btn btn-danger" onclick="if (!confirm('¿Está seguro de borrar este usuario?')) return false;">
                  <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar" title="Borrar">
                </button>
                {!! Form::close() !!}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <div class="text-center my-4">
      <p class="text-capitalize">No hay usuarios.</p>
      <a class="btn btn-success" href="{{ route('users.create') }}">
        <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
        Crear Usuario
      </a>
    </div>
  @endif

</div>

<!-- Paginación -->
<div class="d-flex justify-content-center">
  {!! $users->links() !!}
</div>

@endsection
