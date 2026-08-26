document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.open-modal-btn').forEach(button => {
        button.addEventListener('click', function () {
            const modalId = this.dataset.modalId;
            /**
             * Obtiene el elemento del DOM correspondiente al ID del modal.
             */
            const modal = document.getElementById(modalId);
            modal.classList.add('show');
            document.body.classList.add('modal-open'); 
        });
    });


    document.querySelectorAll('.close-modal-btn').forEach(button => {
        button.addEventListener('click', function () {
            /**
             * Obtiene el elemento contenedor más cercano con la clase 'modal-container' al elemento actual.
             */
            const modal = this.closest('.modal-container');
            modal.classList.remove('show');
            document.body.classList.remove('modal-open'); 
        });
    });


    document.querySelectorAll('.modal-container').forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.remove('show');
                document.body.classList.remove('modal-open'); 
            }
        });
    });
});

var lastScrollTop = 0;
const navbar = document.getElementById("navbar");
const navMobile = document.getElementById("dashboard_header_mobile");


if (navbar) {
    navbar.style.transition = "top .3s";
}

window.addEventListener("scroll", function() {
    /**
     * Obtiene la posición actual de desplazamiento vertical de la ventana.
     */
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop > lastScrollTop) {
        navbar.style.top = "-100px";
    } else {
        navbar.style.top = "0";
    }
    lastScrollTop = scrollTop;
});

if (navMobile) {
    navMobile.style.transition = "top .3s";
}

window.addEventListener("scroll", function() {
    /**
     * Obtiene la posición actual de desplazamiento vertical de la ventana.
     */
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop > lastScrollTop) {
        navMobile.style.top = "-100px";
    } else {
        navMobile.style.top = "0";
    }
    lastScrollTop = scrollTop;
});


/**
 * Crea un IntersectionObserver que agrega la clase 'visible' a los elementos
 * cuando al menos el 10% de ellos es visible en el viewport.
 */
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, {
    threshold: 0.1
});

document.querySelectorAll('.ofertas_item, .card-experiencia').forEach(card => {
    observer.observe(card);
});




document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('filtroForm');

  const closeAll = () => {
    document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.add('oculto'));
    document.querySelectorAll('.flecha-dropdown').forEach(f => f.classList.remove('flecha-rotada'));
  };

  document.querySelectorAll('.dropdown-container').forEach(dropdown => {
    const toggle = dropdown.querySelector('.dropdown-toggle');
    const menu = dropdown.querySelector('.dropdown-menu');
    const label = dropdown.querySelector('.dropdown-label');
    const flecha = dropdown.querySelector('.flecha-dropdown');

    // 1) Buscar input hidden: preferimos data-target -> nextElementSibling -> búsqueda por name
    let hiddenInput = null;
    const targetId = dropdown.dataset.target;
    if (targetId) hiddenInput = document.getElementById(targetId);

    if (!hiddenInput) {
      let next = dropdown.nextElementSibling;
      while (next && next.nodeType !== 1) next = next.nextElementSibling;
      if (next && next.tagName === 'INPUT' && next.type === 'hidden') hiddenInput = next;
    }

    if (!hiddenInput) {
      ['rol','orden','estado'].some(name => {
        const el = dropdown.parentElement.querySelector(`input[name="${name}"]`);
        if (el) { hiddenInput = el; return true; }
        return false;
      });
    }

    // Abrir / cerrar (y cerrar otros dropdowns al abrir uno)
    if (toggle) {
      toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        document.querySelectorAll('.dropdown-container').forEach(d => {
          if (d !== dropdown) {
            const m = d.querySelector('.dropdown-menu');
            if (m) m.classList.add('oculto');
            const f = d.querySelector('.flecha-dropdown');
            if (f) f.classList.remove('flecha-rotada');
          }
        });
        if (menu) menu.classList.toggle('oculto');
        if (flecha) flecha.classList.toggle('flecha-rotada');
      });
    }

    // Selección de opción
    if (menu) {
      menu.querySelectorAll('.dropdown-opcion').forEach(opcion => {
        opcion.addEventListener('click', (e) => {
          e.stopPropagation();
          const texto = opcion.textContent.trim();
          const value = opcion.dataset.value ?? texto; // usa data-value si existe (importante para rol)
          if (label) label.textContent = texto;

          if (hiddenInput) {
            // Si es orden, normalizamos a 'antiguas' / 'recientes'
            if (hiddenInput.name === 'orden') {
              hiddenInput.value = texto.toLowerCase().includes('antigua') ? 'antiguas' : 'recientes';
            } else {
              hiddenInput.value = value;
            }
          } else {
            console.warn('Hidden input no encontrado para este dropdown:', dropdown);
          }

          if (menu) menu.classList.add('oculto');
          if (flecha) flecha.classList.remove('flecha-rotada');

          if (form) form.submit();
        });
      });
    }
  });

  // clic fuera -> cerrar
  document.addEventListener('click', () => closeAll());
  // escape -> cerrar
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeAll(); });
});







const input = document.getElementById('inputPalabraClave');
const contenedor = document.getElementById('contenedorPalabras');
const inputOculto = document.getElementById('palabrasClaveOculto');
const btnAgregar = document.getElementById('btnAgregarPalabra');
const palabrasSet = new Set();

function agregarPalabra() {
    const palabra = input.value.trim();
    if (palabra !== '' && !palabrasSet.has(palabra)) {
        palabrasSet.add(palabra);

        const tag = document.createElement('div');
        tag.className = 'tag';
        tag.innerHTML = `${palabra}<span onclick="eliminarPalabra(this, '${palabra}')">×</span>`;
        contenedor.appendChild(tag);

        input.value = '';
        actualizarInputOculto();
    }
}

input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        agregarPalabra();
    }
});

btnAgregar.addEventListener('click', agregarPalabra);

function actualizarInputOculto() {
    inputOculto.value = Array.from(palabrasSet).join(',');
}

function eliminarPalabra(elemento, palabra) {
    elemento.parentElement.remove();
    palabrasSet.delete(palabra);
    actualizarInputOculto();
}


/**
 * Elimina una palabra de la interfaz y del conjunto de palabras.
 * @param {HTMLElement} el - Elemento HTML relacionado con la palabra.
 * @param {string} palabra - Palabra a eliminar.
 */
function eliminarPalabra(el, palabra) {
    el.parentElement.remove();
    palabrasSet.delete(palabra);
    actualizarInputOculto();
}

/**
 * Actualiza el valor de un input oculto con las palabras del set separadas por comas.
 */
function actualizarInputOculto() {
    inputOculto.value = [...palabrasSet].join(',');
}

document.addEventListener('DOMContentLoaded', () => {
    /**
     * Obtiene un array de valores separados por comas desde el valor de inputOculto.
     */
    const existentes = inputOculto.value.split(',');
    existentes.forEach(palabra => {
        if (palabra.trim() !== '') {
            palabrasSet.add(palabra);
            const tag = document.createElement('div');
            tag.className = 'tag';
            tag.innerHTML = `${palabra}<span onclick="eliminarPalabra(this, '${palabra}')">×</span>`;
            contenedor.appendChild(tag);
        }
    });
});



document.addEventListener('DOMContentLoaded', () => {
/**
 * Obtiene el elemento del DOM con el id 'dropdownMoneda'.
 */
  const dropdown = document.getElementById('dropdownMoneda');
  const toggle = dropdown.querySelector('.dropdown-toggle');
  const menu = dropdown.querySelector('.dropdown-menu');
  const label = dropdown.querySelector('.dropdown-label');
  const input = dropdown.querySelector('#monedaInput');
  const flecha = dropdown.querySelector('.flecha-dropdown');

  toggle.addEventListener('click', () => {
    menu.classList.toggle('oculto');
    flecha.classList.toggle('flecha-rotada');
  });

  menu.querySelectorAll('h3').forEach(option => {
    option.addEventListener('click', () => {
    /**
     * Obtiene el valor del atributo 'data-value' del elemento option.
     */
      const value = option.getAttribute('data-value');
      label.textContent = value;
      input.value = value;
      menu.classList.add('oculto');
      flecha.classList.remove('flecha-rotada');
    });
  });

  
  document.addEventListener('click', (e) => {
    if (!dropdown.contains(e.target)) {
      menu.classList.add('oculto');
      flecha.classList.remove('flecha-rotada');
    }
  });

  
  toggle.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      menu.classList.toggle('oculto');
      flecha.classList.toggle('flecha-rotada');
    }
  });
});


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.guardar-oferta').forEach(icono => {
        icono.addEventListener('click', function () {
            const ofertaId = this.getAttribute('data-id');

            fetch('/guardar-oferta', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ oferta_id: ofertaId })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert('Error al guardar la oferta');
                }
            });
        });
    });
});





 document.addEventListener('DOMContentLoaded', function () {
        // Abrir modal
        document.querySelectorAll('.open-modal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const modalId = btn.getAttribute('data-modal-id');
                const modal = document.getElementById(modalId);
                if (modal) modal.style.display = 'flex';
            });
        });

        // Cerrar modal
        document.querySelectorAll('.close-modal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const modal = btn.closest('.modal-container');
                if (modal) modal.style.display = 'none';
            });
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.postular-btn').forEach(btn => {
          btn.addEventListener('click', function() {
              const ofertaId = this.dataset.ofertaId;
              const yaPostulado = this.dataset.yaPostulado === '1';
              const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
              const button = this;
  
              let url = yaPostulado 
                  ? `/postulaciones/cancelar/${ofertaId}` 
                  : `/postulaciones/store`;
  
              let options = {
                  method: yaPostulado ? 'DELETE' : 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': token,
                  },
                  body: yaPostulado ? null : JSON.stringify({ oferta_id: ofertaId })
              };
  
              fetch(url, options)
                  .then(res => res.json())
                  .then(data => {
                      if (data.success) {
                          button.dataset.yaPostulado = yaPostulado ? '0' : '1';
                          button.textContent = yaPostulado ? 'Aplicar' : 'Aplicado';
                      } else if (data.error) {
                          alert(data.error);
                      }
                  })
                  .catch(err => console.error(err));
          });
      });
  });
  

















    