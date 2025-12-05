// Utilidades generales para el sistema
const Utilidades = {
    // Obtener URL base
    obtenerUrlBase: function() {
        let urlBase = window.location.href.split('?')[0];
        return urlBase.endsWith('index.php') ? urlBase : (urlBase.endsWith('/') ? urlBase : urlBase + '/') + 'index.php';
    },

    // Formatear fecha
    formatearFecha: function(fechaString) {
        if(!fechaString || fechaString === '0000-00-00') return 'N/A';
        const fecha = new Date(fechaString);
        return fecha.toLocaleDateString('es-ES', {day: '2-digit', month: '2-digit', year: 'numeric'});
    },

    // Crear celda con icono
    crearCeldaConIcono: function(icono, texto, clases = '') {
        return `<div class="flex items-center space-x-2 ${clases}">
            <i class="${icono} text-slate-400"></i>
            <span class="text-sm ${clases.includes('font-semibold') ? 'font-semibold text-slate-800' : 'text-slate-700'}">${texto || 'N/A'}</span>
        </div>`;
    },

    // Crear botón de acción
    crearBotonAccion: function(texto, icono, url, color, confirmar = false) {
        const clases = `inline-flex items-center space-x-1 ${color} text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md transform hover:scale-105`;
        const onclick = confirmar ? `onclick="return confirm('${confirmar}')"` : '';
        return `<a href="${url}" ${onclick} class="${clases}">
            <i class="ph ${icono}"></i>
            <span>${texto}</span>
        </a>`;
    },

    // Mostrar mensaje de vacío
    mostrarVacio: function(icono, mensaje, urlCrear, textoBoton) {
        return `<div class="p-12 text-center">
            <i class="${icono} text-6xl text-slate-300 mb-4"></i>
            <p class="text-slate-500 text-lg font-medium">${mensaje}</p>
            <a href="${urlCrear}" class="inline-flex items-center space-x-2 mt-4 text-emerald-600 hover:text-emerald-700 font-semibold">
                <i class="ph ph-plus-circle"></i>
                <span>${textoBoton}</span>
            </a>
        </div>`;
    },

    // Mostrar carga
    mostrarCarga: function() {
        return '<div class="p-12 text-center"><i class="ph ph-spinner text-4xl text-emerald-600 animate-spin"></i><p class="mt-4 text-slate-600">Cargando...</p></div>';
    },

    // Mostrar error
    mostrarError: function(mensaje = 'Error al cargar los datos') {
        return `<div class="p-12 text-center text-red-600">${mensaje}</div>`;
    }
};

