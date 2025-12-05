// Sistema de paginación con AJAX - Versión simplificada
function inicializarPaginacion(controlador, funcionRenderizar) {
    let paginaActual = 1;
    const urlBase = Utilidades.obtenerUrlBase();

    // Cargar página
    function cargarPagina(pagina) {
        const url = `${urlBase}?controller=${controlador}&action=obtenerPaginados&page=${pagina}`;
        
        $('#table-container').html(Utilidades.mostrarCarga());
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(respuesta) {
                if(respuesta.exito) {
                    paginaActual = respuesta.paginacion.pagina_actual;
                    funcionRenderizar(respuesta.datos, respuesta.paginacion);
                    actualizarControles(respuesta.paginacion);
                } else {
                    $('#table-container').html(Utilidades.mostrarError());
                }
            },
            error: function() {
                $('#table-container').html(Utilidades.mostrarError());
            }
        });
    }

    // Actualizar controles de paginación
    function actualizarControles(paginacion) {
        const totalPaginas = paginacion.total_paginas;
        const paginaActual = paginacion.pagina_actual;
        const total = paginacion.total;
        const porPagina = paginacion.por_pagina;
        const inicio = (paginaActual - 1) * porPagina + 1;
        const fin = Math.min(paginaActual * porPagina, total);

        if(totalPaginas <= 1) {
            $('#pagination-container').hide();
            return;
        }

        $('#pagination-container').show();
        $('#pagination-info').html(`<i class="ph ph-info text-slate-400"></i><span>Mostrando ${inicio}-${fin} de ${total}</span>`);

        let html = '';
        
        // Botón Anterior
        html += paginaActual > 1 
            ? `<a href="#" data-page="${paginaActual - 1}" class="enlace-pagina inline-flex items-center space-x-1 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-all duration-200"><i class="ph ph-caret-left"></i><span>Anterior</span></a>`
            : `<span class="inline-flex items-center space-x-1 px-4 py-2 bg-slate-300 text-slate-500 rounded-lg cursor-not-allowed"><i class="ph ph-caret-left"></i><span>Anterior</span></span>`;

        // Números de página
        html += '<div class="flex items-center space-x-1">';
        const inicioPag = Math.max(1, paginaActual - 2);
        const finPag = Math.min(totalPaginas, paginaActual + 2);

        if(inicioPag > 1) {
            html += `<a href="#" data-page="1" class="enlace-pagina px-3 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition-colors duration-200">1</a>`;
            if(inicioPag > 2) html += '<span class="px-2 text-slate-400">...</span>';
        }

        for(let i = inicioPag; i <= finPag; i++) {
            html += i === paginaActual
                ? `<span class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-semibold">${i}</span>`
                : `<a href="#" data-page="${i}" class="enlace-pagina px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition-colors duration-200">${i}</a>`;
        }

        if(finPag < totalPaginas) {
            if(finPag < totalPaginas - 1) html += '<span class="px-2 text-slate-400">...</span>';
            html += `<a href="#" data-page="${totalPaginas}" class="enlace-pagina px-3 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition-colors duration-200">${totalPaginas}</a>`;
        }
        html += '</div>';

        // Botón Siguiente
        html += paginaActual < totalPaginas
            ? `<a href="#" data-page="${paginaActual + 1}" class="enlace-pagina inline-flex items-center space-x-1 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-all duration-200"><span>Siguiente</span><i class="ph ph-caret-right"></i></a>`
            : `<span class="inline-flex items-center space-x-1 px-4 py-2 bg-slate-300 text-slate-500 rounded-lg cursor-not-allowed"><span>Siguiente</span><i class="ph ph-caret-right"></i></span>`;

        $('#pagination-controls').html(html);

        // Event listeners
        $(document).off('click', '.enlace-pagina').on('click', '.enlace-pagina', function(e) {
            e.preventDefault();
            const pagina = $(this).data('page');
            if(pagina && pagina !== paginaActual) {
                cargarPagina(pagina);
                $('html, body').animate({scrollTop: $('#table-container').offset().top - 100}, 300);
            }
        });
    }

    // Cargar primera página
    cargarPagina(1);

    // Exponer función para recargar
    window.recargarPaginacion = () => cargarPagina(paginaActual);
}

