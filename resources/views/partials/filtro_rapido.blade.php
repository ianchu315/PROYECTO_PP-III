{{--
    Buscador rápido reutilizable (filtra en el momento, sin recargar la página).

    Uso:
      @include('partials.filtro_rapido', ['target' => '#mi-tabla', 'placeholder' => 'Buscar alumno...'])

    $celdas  (opcional) buscar solo en las primeras N celdas de cada fila.
    $target  Selector CSS de lo que se filtra:
               - una <table>      → filtra sus filas del <tbody>
               - un <select>      → filtra sus opciones
               - cualquier otro   → filtra sus hijos directos (listas de tarjetas)
    Busca sin importar mayúsculas ni tildes, y todas las palabras escritas
    tienen que aparecer (ej: "perez ana" encuentra "Pérez, Ana").
    Funciona sobre lo que ya está cargado en la página; las listas paginadas
    del servidor tienen su propio buscador con recarga.
--}}
@once
<style>
    .pf-filtro { display:flex; align-items:center; gap:10px; margin:0 0 12px; flex-wrap:wrap; }
    .pf-filtro input[type="search"] { flex:1; min-width:200px; max-width:420px; padding:7px 10px; border:1px solid #bbb; border-radius:6px; font-size:14px; }
    .pf-filtro-cuenta { font-size:12px; color:#777; }
    .pf-filtro-vacio td, .pf-filtro-vacio { font-size:13px; color:#777; text-align:center; padding:10px; }
</style>
<script>
(function () {
    if (window.__pfFiltroRapido) return; // evita iniciarlo dos veces
    window.__pfFiltroRapido = true;

    function norm(t) {
        return (t || '').toString().toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/\s+/g, ' ').trim();
    }
    function coincide(texto, palabras) {
        for (var i = 0; i < palabras.length; i++) { if (texto.indexOf(palabras[i]) === -1) return false; }
        return true;
    }

    function iniciar(input) {
        var destino = document.querySelector(input.getAttribute('data-pf-filtrar'));
        var cuenta = input.parentNode.querySelector('.pf-filtro-cuenta');
        if (!destino) return;

        var items, esSelect = destino.tagName === 'SELECT', vacio = null, opciones = null;

        if (esSelect) {
            // Los <option> no se pueden ocultar de forma confiable en todos los
            // navegadores: se guardan y se vuelve a armar la lista filtrada.
            opciones = Array.prototype.slice.call(destino.options).map(function (o) {
                return { value: o.value, texto: o.text, clave: norm(o.text), placeholder: o.value === '' };
            });
            items = opciones.filter(function (o) { return !o.placeholder; });
        } else if (destino.tagName === 'TABLE') {
            items = Array.prototype.slice.call(destino.tBodies[0].rows);
            vacio = document.createElement('tr');
            vacio.className = 'pf-filtro-vacio';
            vacio.style.display = 'none';
            var celdas = destino.tHead ? destino.tHead.rows[0].cells.length : 1;
            vacio.innerHTML = '<td colspan="' + celdas + '">Ningún resultado para esa búsqueda.</td>';
            destino.tBodies[0].appendChild(vacio);
        } else {
            items = Array.prototype.slice.call(destino.children);
            vacio = document.createElement('p');
            vacio.className = 'pf-filtro-vacio';
            vacio.style.display = 'none';
            vacio.textContent = 'Ningún resultado para esa búsqueda.';
            destino.appendChild(vacio);
        }

        // Con data-pf-celdas="1" solo se busca en las primeras N celdas de cada
        // fila (ej.: el nombre del alumno, sin los botones Presente/Ausente).
        var nCeldas = parseInt(input.getAttribute('data-pf-celdas') || '0', 10);
        var claves = esSelect ? null : items.map(function (el) {
            if (nCeldas > 0 && el.cells) {
                return norm(Array.prototype.slice.call(el.cells, 0, nCeldas).map(function (c) { return c.textContent; }).join(' '));
            }
            return norm(el.textContent);
        });
        var total = items.length;

        function aplicar() {
            var palabras = norm(input.value).split(' ').filter(Boolean);
            var visibles = 0;

            if (esSelect) {
                var actual = destino.value;
                destino.innerHTML = '';
                opciones.forEach(function (o) {
                    if (o.placeholder || o.value === actual || coincide(o.clave, palabras)) {
                        var op = document.createElement('option');
                        op.value = o.value; op.text = o.texto;
                        if (o.value === actual) op.selected = true;
                        destino.appendChild(op);
                        if (!o.placeholder) visibles++;
                    }
                });
            } else {
                items.forEach(function (el, i) {
                    var ok = coincide(claves[i], palabras);
                    el.style.display = ok ? '' : 'none';
                    if (ok) visibles++;
                });
                if (vacio) vacio.style.display = (visibles === 0 && total > 0) ? '' : 'none';
            }

            if (cuenta) cuenta.textContent = palabras.length ? (visibles + ' de ' + total) : (total + ' en total');
        }

        input.addEventListener('input', aplicar);
        input.addEventListener('keydown', function (e) { if (e.key === 'Enter') e.preventDefault(); });
        aplicar();
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[data-pf-filtrar]').forEach(iniciar);
    });
})();
</script>
@endonce
<div class="pf-filtro">
    <input type="search" data-pf-filtrar="{{ $target }}" @if(!empty($celdas)) data-pf-celdas="{{ $celdas }}" @endif placeholder="{{ $placeholder ?? 'Buscar...' }}" autocomplete="off" aria-label="{{ $placeholder ?? 'Buscar' }}">
    <span class="pf-filtro-cuenta"></span>
</div>
