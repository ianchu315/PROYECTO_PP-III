@extends('backend.layouts.main')
@section('title', 'Sedes')
@section('content')
@forelse($sedes as $sede)
@if($loop->first)
<div class="descripciones container">
  <!-- Contenedor responsive -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>Sede</th>
          <th>Ciudad</th>
          <th>Calle</th>
          <th>Número</th>
          <th>
            <a class="btn btn-success btn-sm d-flex align-items-center gap-1" href="{{ route('sede.create') }}">
              <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
              Crear Sede
            </a>
          </th>
        </tr>
      </thead>
      <tbody>
@endif
        <tr class="table-light text-center">
          <td class="text-primary fw-bold">{{ $sede->descripcion }}</td>
          <td>{{ $sede->ciudad }}</td>
          <td>{{ $sede->calle }}</td>
          <td>{{ $sede->numero }}</td>
          <td class="d-flex flex-wrap gap-2 justify-content-center">
            {{ Form::model($sede, [ 'method' => 'delete' , 'route' => ['sede.destroy', $sede->id] ]) }}
              @csrf
              <a href="{{ route('sede.show', ['sede' => $sede->id ]) }}" class="btn btn-info btn-sm">
                <img src="{{ asset('svg/show.svg') }}" width="20" height="20" alt="Mostrar" title="Mostrar">
              </a>
              <a href="{{ route('sede.edit', ['sede' => $sede->id ]) }}" class="btn btn-primary btn-sm">
                <img src="{{ asset('svg/edit.svg') }}" width="20" height="20" alt="Editar" title="Editar">
              </a>
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de borrar la sede?');">
                <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar" title="Borrar">
              </button>
            {!!Form::close()!!}
          </td>
        </tr>

        <!-- Emails y Teléfonos -->
        <tr>
          <td colspan="5">
            <div class="row g-2">
              <div class="col-12 col-md-6">
                {{ Form::open(['route' => 'sedeemail.store']) }}
                  @csrf
                  <div class="input-group">
                    {{Form::hidden("sede_id", $sede->id)}}
                    {{Form::email("email", null, ["class" => "form-control", "placeholder" => "Nuevo email"]) }}
                    <button type="submit" class="btn btn-success">
                      <img src="{{ asset('svg/mail.svg') }}" width="20" height="20" alt="Nuevo email" title="Nuevo email">
                    </button>
                  </div>
                {!!Form::close()!!}

                @foreach($sede->emails as $email)
                  {{ Form::model($email, [ 'method' => 'delete' , 'route' => ['sedeemail.destroy', $email->id] ]) }}
                    @csrf
                    <div class="d-flex align-items-center mt-1">
                      <button type="submit" class="btn btn-danger btn-sm me-2" onclick="return confirm('¿Está seguro de borrar el email?');">
                        <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar">
                      </button> 
                      <span>{{ $email->email }}</span>
                    </div>
                  {!!Form::close()!!}
                @endforeach
              </div>

              <div class="col-12 col-md-6">
                {{ Form::open(['route' => 'sedetelefono.store']) }}
                  @csrf
                  <div class="row g-2">
                    <div class="col-12 col-sm-3">
                      {{Form::hidden("sede_id", $sede->id)}}
                      {{Form::number("caracteristica", null, ["class" => "form-control", "placeholder" => "Cód."]) }}
                    </div>
                    <div class="col-12 col-sm-6">
                      {{Form::number("numero", null, ["class" => "form-control", "placeholder" => "Número"]) }}
                    </div>
                    <div class="col-12 col-sm-3">
                      <button type="submit" class="btn btn-success w-100">
                        <img src="{{ asset('svg/phone.svg') }}" width="20" height="20" alt="Teléfono">
                      </button>
                    </div>
                  </div>
                {!!Form::close()!!}

                @foreach($sede->telefonos as $telef)
                  {{ Form::model($telef, [ 'method' => 'delete' , 'route' => ['sedetelefono.destroy', $telef->id] ]) }}
                    @csrf
                    <div class="d-flex align-items-center mt-1">
                      <button type="submit" class="btn btn-danger btn-sm me-2" onclick="return confirm('¿Está seguro de borrar el teléfono?');">
                        <img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar">
                      </button> 
                      <span>{{ $telef->caracteristica }} - {{ $telef->numero }}</span>
                    </div>
                  {!!Form::close()!!}
                @endforeach
              </div>
            </div>
          </td>
        </tr>

@if($loop->last)
      </tbody>
    </table>
  </div>
</div>
@endif
@empty
<div class="descripciones container">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Sede</th>
          <th>Ciudad</th>
          <th>Calle</th>
          <th>Número</th>
          <th>
            <a class="btn btn-success btn-sm d-flex align-items-center gap-1" href="{{ route('sede.create') }}">
              <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
              Crear Sede
            </a>
          </th>
        </tr>
      </thead>
    </table>
  </div>
  <p class="text-center">No hay sedes.</p>
</div>
@endforelse

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
      <!-- 
    Agregar en App\Providers\AppServiceProvider:
    use Illuminate\Pagination\Paginator;
        public function boot() { Paginator::useBootstrap(); } -->
    </div>
    @endsection