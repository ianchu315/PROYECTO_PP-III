@extends('layouts.panel')

@section('titulo', 'Escanear QR de asistencia')

@section('content')
<div class="pf-page-header">
    <h1>Escanear QR de asistencia</h1>
    <a href="{{ route('bolsadetrabajo.asistencia.index') }}" class="btn btn-secondary btn-sm">Volver</a>
</div>

<div class="pf-card" style="text-align:center;">
    <p class="pf-muted" style="font-size:13px;">
        Apuntá la cámara al QR que muestra el profesor. Si es de presente quedás presente;
        si es de tardanza, quedás con tardanza.
    </p>

    <div id="pf-lector" style="width:100%; max-width:360px; margin:0 auto;"></div>
    <p id="pf-lector-estado" class="pf-muted" style="font-size:13px; margin-top:10px;">Iniciando cámara…</p>
</div>

<div class="pf-card">
    <h4 style="font-size:14px; margin-bottom:8px;">¿No funciona la cámara?</h4>
    <p class="pf-muted" style="font-size:12px;">
        La cámara solo se habilita en páginas seguras (https) o en localhost. También podés escanear el
        QR con la cámara normal del celular, o pegar acá el enlace o código que figura debajo del QR.
    </p>
    <form id="pf-manual" style="display:flex; gap:8px;">
        <input type="text" id="pf-manual-texto" placeholder="Enlace o código del QR" style="flex:1;" required>
        <button type="submit" class="btn btn-primary btn-sm">Registrar</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
    (function () {
        // El QR trae una URL .../asistencia/escanear/{token}. Nos quedamos
        // solo con el token y armamos la URL con ESTE sitio, así funciona
        // aunque el QR se haya generado desde otro dominio.
        var base = @json(route('bolsadetrabajo.asistencia.escanear', ['token' => '__TOKEN__']));
        var estado = document.getElementById('pf-lector-estado');
        var yaLeido = false;

        function extraerToken(texto) {
            texto = (texto || '').trim();
            var m = texto.match(/escanear\/([A-Za-z0-9]+)/);
            if (m) return m[1];
            return /^[A-Za-z0-9]{20,64}$/.test(texto) ? texto : null;
        }

        function ir(texto) {
            var token = extraerToken(texto);
            if (!token) {
                estado.textContent = 'Ese código no es un QR de asistencia.';
                return false;
            }
            yaLeido = true;
            estado.textContent = 'Código leído, registrando…';
            window.location.href = base.replace('__TOKEN__', token);
            return true;
        }

        document.getElementById('pf-manual').addEventListener('submit', function (e) {
            e.preventDefault();
            ir(document.getElementById('pf-manual-texto').value);
        });

        if (typeof Html5Qrcode === 'undefined') {
            estado.textContent = 'No se pudo cargar el lector. Usá la cámara del celular o pegá el enlace abajo.';
            return;
        }

        var lector = new Html5Qrcode('pf-lector');
        lector.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 240, height: 240 } },
            function (texto) {
                if (yaLeido) return;
                if (ir(texto)) { lector.stop().catch(function () {}); }
            },
            function () {}
        ).then(function () {
            estado.textContent = 'Cámara lista. Apuntá al QR.';
        }).catch(function () {
            estado.textContent = 'No pude abrir la cámara (permiso denegado o sitio sin https). Usá la opción de abajo.';
        });
    })();
</script>
@endsection
