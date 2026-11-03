{{-- Información del usuario en el panel general: datos + última conexión,
     avisos según el rol y novedades del instituto. Recibe $usuario e $infoUsuario
     (armados en PanelUsuarioController). --}}
@php
    $rolesLabel = [
        'usuario'            => 'Alumno',
        'profesor'           => 'Profesor',
        'preceptor'          => 'Preceptor',
        'administrador'      => 'Administrador',
        'superadministrador' => 'Superadministrador',
    ];
    $ultimaConexion = $infoUsuario['ultimaConexion'] ?? null;
    $avisos = $infoUsuario['avisos'] ?? [];
    $novedades = $infoUsuario['novedades'] ?? collect();
@endphp

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:16px; margin-top:16px; align-items:start;">

    {{-- Mi usuario --}}
    <div class="pf-card" style="margin:0;">
        <h3>👤 Mi usuario</h3>
        <p style="margin-bottom:4px;"><strong>{{ $usuario->nombre }} {{ $usuario->apellido }}</strong></p>
        <p class="pf-muted" style="margin-bottom:4px;">{{ $usuario->email }}</p>
        <p class="pf-muted" style="margin-bottom:4px;">Rol: {{ $rolesLabel[$usuario->rol] ?? ucfirst($usuario->rol) }}</p>
        @if($usuario->rol === 'usuario' && $usuario->carrera)
            <p class="pf-muted" style="margin-bottom:4px;">Carrera: {{ $usuario->carrera->descripcion }}</p>
        @endif
        <p class="pf-muted" style="margin-bottom:0;">
            Última conexión:
            @if($ultimaConexion)
                {{ $ultimaConexion->format('d/m/Y') }} a las {{ $ultimaConexion->format('H:i') }} hs
            @else
                es tu primer ingreso registrado 🎉
            @endif
        </p>
    </div>

    {{-- Avisos --}}
    <div class="pf-card" style="margin:0;">
        <h3>🔔 Avisos</h3>
        @forelse($avisos as $aviso)
            <p style="margin-bottom:8px;">
                {{ $aviso['icono'] }}
                @if(!empty($aviso['url']))
                    <a href="{{ $aviso['url'] }}">{{ $aviso['texto'] }}</a>
                @else
                    {{ $aviso['texto'] }}
                @endif
            </p>
        @empty
            <p class="pf-muted mb-0">No tenés avisos nuevos por ahora. ¡Todo al día! 🎈</p>
        @endforelse
    </div>

    {{-- Novedades --}}
    <div class="pf-card" style="margin:0;">
        <h3>📰 Novedades</h3>
        @forelse($novedades as $novedad)
            <div style="margin-bottom:10px;">
                <strong>{{ $novedad['titulo'] }}</strong>
                @if($novedad['fecha'])
                    <span class="pf-muted" style="font-size:12px;"> · {{ $novedad['fecha'] }}</span>
                @endif
                @if($novedad['resumen'])
                    <div class="pf-muted" style="font-size:13px;">{{ $novedad['resumen'] }}</div>
                @endif
            </div>
        @empty
            <p class="pf-muted">Todavía no hay novedades publicadas.</p>
        @endforelse
        <a href="{{ route('novedades') }}" style="font-size:13px;">Ver todas las novedades →</a>
    </div>
</div>
