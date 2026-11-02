@extends(Auth::guard('usuarios')->user()->rol === 'superadministrador' ? 'layouts.panel' : 'layouts.app2')

@section('titulo', 'QR de asistencia - ' . $materia->descripcion)

@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1>{{ $materia->descripcion }} — QR de asistencia</h1>
        <a href="{{ route('bolsadetrabajo.profesor.asistencia.planilla', $materia) }}" class="btn btn-secondary btn-sm">Ver planilla</a>
    </div>

    @if($errors->any())
        <div class="pf-card" style="border-color:#c0392b; background:#fdecea;">
            @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if(!$codigo)
        <div class="pf-card">
            <p class="pf-muted">Todavía no generaste un QR para hoy, o el último ya venció.
                Lo que escaneen los alumnos pisa lo que tuvieran cargado (por ejemplo, un ausente pasa a tardanza).</p>
            <form method="POST" action="{{ route('bolsadetrabajo.profesor.asistencia.qr.generar', $materia) }}" style="display:flex; gap:10px; align-items:center;">
                @csrf
                <div class="pf-tipo-qr" role="group" aria-label="Tipo de QR" style="display:inline-flex; border:1px solid #bbb; border-radius:6px; overflow:hidden;">
                    <label style="margin:0; padding:5px 12px; cursor:pointer; font-size:13px;">
                        <input type="radio" name="tipo" value="2" checked style="display:none;"> <span>Presente</span>
                    </label>
                    <label style="margin:0; padding:5px 12px; cursor:pointer; font-size:13px; border-left:1px solid #bbb;">
                        <input type="radio" name="tipo" value="1" style="display:none;"> <span>Tardanza</span>
                    </label>
                </div>
                <label for="minutos" style="font-size:13px;">válido por</label>
                <select name="minutos" id="minutos">
                    <option value="10">10 minutos</option>
                    <option value="15" selected>15 minutos</option>
                    <option value="20">20 minutos</option>
                    <option value="30">30 minutos</option>
                    <option value="60">1 hora</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Generar QR <span id="pf-tipo-texto">de presente</span></button>
            </form>
            <script>
                (function () {
                    var radios = document.querySelectorAll('.pf-tipo-qr input');
                    function pintar() {
                        radios.forEach(function (r) {
                            var l = r.parentNode;
                            l.style.background = r.checked ? (r.value === '1' ? '#b8860b' : '#2e7d32') : 'transparent';
                            l.style.color = r.checked ? '#fff' : 'inherit';
                            if (r.checked) document.getElementById('pf-tipo-texto').textContent = r.value === '1' ? 'de tardanza' : 'de presente';
                        });
                    }
                    radios.forEach(function (r) { r.addEventListener('change', pintar); });
                    pintar();
                })();
            </script>
        </div>
    @else
        <div class="pf-card" style="text-align:center;">
            @php
                $urlEscaneo = route('bolsadetrabajo.asistencia.escanear', $codigo->token);
            @endphp
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=280x280&data={{ urlencode($urlEscaneo) }}"
                 alt="QR de asistencia" width="280" height="280" style="margin:10px auto;">

            <p style="font-size:15px; margin:0 0 4px;">
                Este QR marca <strong>{{ $codigo->etiqueta_tipo }}</strong>.
            </p>
            <p class="pf-muted" style="font-size:13px;">
                Vence a las <strong id="pf-qr-vence">{{ $codigo->expira_en->format('H:i') }}</strong>.
                Si alguien no puede escanear, también puede entrar a:
            </p>
            <p style="font-size:12px; word-break:break-all;">{{ $urlEscaneo }}</p>

            <div style="display:flex; justify-content:center; gap:10px; margin-top:10px;">
                <form method="POST" action="{{ route('bolsadetrabajo.profesor.asistencia.qr.cerrar', [$materia, $codigo]) }}" onsubmit="return confirm('¿Cerrar el QR ahora?');">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Cerrar QR</button>
                </form>
                <form method="POST" action="{{ route('bolsadetrabajo.profesor.asistencia.qr.generar', $materia) }}">
                    @csrf
                    <input type="hidden" name="minutos" value="15">
                    <input type="hidden" name="tipo" value="{{ $codigo->tipo === 1 ? 2 : 1 }}">
                    <button type="submit" class="btn btn-secondary btn-sm">Cambiar a QR de {{ $codigo->tipo === 1 ? 'presente' : 'tardanza' }}</button>
                </form>
            </div>
        </div>

        <div class="pf-card">
            <h4 style="font-size:14px; margin-bottom:8px;">
                Alumnos registrados con este QR: <span id="pf-qr-cantidad">...</span>
            </h4>
            <ul id="pf-qr-lista" style="margin:0; padding-left:18px; font-size:13px;"></ul>
        </div>

        <script>
            (function () {
                var url = @json(route('bolsadetrabajo.profesor.asistencia.qr.escaneos', [$materia, $codigo]));
                function actualizar() {
                    fetch(url, { headers: { 'Accept': 'application/json' } })
                        .then(function (r) { return r.json(); })
                        .then(function (data) {
                            document.getElementById('pf-qr-cantidad').textContent = data.cantidad;
                            var lista = document.getElementById('pf-qr-lista');
                            lista.innerHTML = '';
                            data.alumnos.forEach(function (nombre) {
                                var li = document.createElement('li');
                                li.textContent = nombre;
                                lista.appendChild(li);
                            });
                            if (!data.vigente) clearInterval(intervalo);
                        })
                        .catch(function () {});
                }
                actualizar();
                var intervalo = setInterval(actualizar, 5000);
            })();
        </script>
    @endif
</div>
@endsection
