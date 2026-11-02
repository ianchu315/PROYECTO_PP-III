{{-- Tarjeta lateral fija para el superadministrador: dos listas (espera y activos). --}}
@if($mostrarPopupSuperUsuario ?? false)

<div class="panel-super-card" id="panelSuperCard">
    <div class="panel-super-header">
        <h2><i class="ri-shield-user-line"></i> Panel de usuarios</h2>
        <button type="button" class="panel-super-cerrar" id="cerrarPanelSuper" title="Ocultar">&times;</button>
    </div>

    <div class="panel-super-body">

        {{-- ================= LISTA DE ESPERA ================= --}}
        <div class="panel-super-seccion">
            <h3>Lista de espera <span class="panel-super-contador">{{ isset($usuariosPendientes) ? $usuariosPendientes->count() : 0 }}</span></h3>

            @if(!isset($usuariosPendientes) || $usuariosPendientes->isEmpty())
                <p class="panel-super-vacio">No hay usuarios pendientes.</p>
            @else
                @include('partials.filtro_rapido', ['target' => '#lista-espera-items', 'placeholder' => 'Buscar en la lista de espera...'])
                <div id="lista-espera-items">
                @foreach($usuariosPendientes as $usuarioPendiente)
                    <div class="panel-super-item">
                        <div class="panel-super-datos">
                            <strong>{{ $usuarioPendiente->nombre }} {{ $usuarioPendiente->apellido }}</strong>
                            <span>{{ $usuarioPendiente->email }}</span>
                            <span class="panel-super-carrera">{{ $usuarioPendiente->carrera->descripcion ?? 'Sin carrera' }}</span>
                        </div>
                        <div class="panel-super-acciones">
                           <form action="{{ route('admin.aprobacion.approve', $usuarioPendiente->id) }}" method="POST" class="panel-super-form-aprobar">
                                @csrf
                                <input type="hidden" name="volver" value="{{ url()->current() }}">
                                <button class="btn btn-sm btn-success" type="submit" name="rol" value="usuario">
                                    Aprobar como Alumno
                                </button>
                                <button class="btn btn-sm btn-primary" type="submit" name="rol" value="profesor">
                                    Aprobar como Profesor
                                </button>
                            </form>
                            <form action="{{ route('admin.aprobacion.reject', $usuarioPendiente->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="volver" value="{{ url()->current() }}">
                                <button class="btn btn-sm btn-danger" type="submit">Rechazar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                </div>
            @endif
        </div>

        {{-- ================= USUARIOS ACTIVOS ================= --}}
        <div class="panel-super-seccion">
            <h3>Usuarios activos <span class="panel-super-contador">{{ isset($usuariosActivos) ? $usuariosActivos->count() : 0 }}</span></h3>

            @if(!isset($usuariosActivos) || $usuariosActivos->isEmpty())
                <p class="panel-super-vacio">No hay usuarios activos.</p>
            @else
                @include('partials.filtro_rapido', ['target' => '#usuarios-activos-items', 'placeholder' => 'Buscar usuario activo...'])
                <div id="usuarios-activos-items">
                @foreach($usuariosActivos as $usuarioActivo)
                    <div class="panel-super-item">
                        <div class="panel-super-datos">
                            <strong>{{ $usuarioActivo->nombre }} {{ $usuarioActivo->apellido }}</strong>
                            <span>{{ $usuarioActivo->email }}</span>
                            <span class="panel-super-rol-badge">{{ $usuarioActivo->rol === 'profesor' ? 'Profesor' : 'Alumno' }}</span>
                        </div>
                        <div class="panel-super-acciones">
                            <form action="{{ route('bolsadetrabajo.usuarios.destroy', $usuarioActivo->id) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar a {{ $usuarioActivo->nombre }} {{ $usuarioActivo->apellido }}? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                </div>
            @endif
        </div>

    </div>
</div>

<button type="button" id="abrirPanelSuper" class="panel-super-toggle" style="display:none;">
    <i class="ri-shield-user-line"></i> Panel de usuarios
</button>

<style>
    .panel-super-card {
        position: fixed; top: 90px; right: 20px;
        width: 370px; max-height: 80vh;
        display: flex; flex-direction: column;
        background: #fff; border-radius: 14px;
        box-shadow: 0 6px 24px rgba(0,0,0,0.18);
        z-index: 1050; overflow: hidden;
    }
    .panel-super-header {
        background: #700101; color: #fff; padding: 12px 16px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .panel-super-header h2 { font-size: 16px; margin: 0; font-weight: 500; }
    .panel-super-cerrar {
        background: transparent; border: none; color: #fff;
        font-size: 22px; line-height: 1; cursor: pointer;
    }
    .panel-super-body { padding: 12px; overflow-y: auto; }
    .panel-super-seccion { margin-bottom: 18px; }
    .panel-super-seccion h3 {
        font-size: 14px; color: #700101; margin: 0 0 8px 0;
        border-bottom: 1px solid #eee; padding-bottom: 4px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .panel-super-contador {
        background: #700101; color: #fff; font-size: 11px;
        border-radius: 10px; padding: 1px 8px;
    }
    .panel-super-vacio { color: #666; font-size: 13px; margin: 6px 0; }
    .panel-super-item {
        border: 1px solid #eee; border-radius: 10px;
        padding: 9px; margin-bottom: 9px;
    }
    .panel-super-datos { display: flex; flex-direction: column; gap: 2px; margin-bottom: 8px; }
    .panel-super-datos strong { font-size: 13px; }
    .panel-super-datos span { font-size: 12px; color: #666; }
    .panel-super-carrera, .panel-super-rol-badge { color: #700101 !important; }
    .panel-super-acciones { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .panel-super-form-aprobar { display: flex; align-items: center; gap: 6px; }
    .panel-super-rol { font-size: 12px; padding: 3px; border: 1px solid #ccc; border-radius: 6px; }
    .panel-super-toggle {
        position: fixed; top: 90px; right: 20px; z-index: 1050;
        background: #700101; color: #fff; border: none;
        padding: 10px 14px; border-radius: 10px; cursor: pointer;
        box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    }
    @media (max-width: 768px) {
        .panel-super-card { position: static; width: auto; max-height: none; margin: 16px; }
        .panel-super-toggle { display: none !important; }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const card = document.getElementById("panelSuperCard");
        const cerrar = document.getElementById("cerrarPanelSuper");
        const abrir = document.getElementById("abrirPanelSuper");
        if (cerrar && card && abrir) {
            cerrar.addEventListener("click", () => { card.style.display = "none"; abrir.style.display = "inline-block"; });
            abrir.addEventListener("click", () => { card.style.display = "flex"; abrir.style.display = "none"; });
        }
    });
</script>

@endif