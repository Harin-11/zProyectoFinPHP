<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="animate-fadeIn">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-6 border-b border-slate-200">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-slate-800 flex items-center space-x-3">
                <i class="ph ph-folder-open text-emerald-600"></i>
                <span>Gestión de Proyectos</span>
            </h1>
            <p class="text-slate-600 mt-2">Administra todos tus proyectos</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="index.php?controller=proyectos&action=create" 
               class="inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="ph ph-plus-circle text-xl"></i>
                <span>Nuevo Proyecto</span>
            </a>
            <a href="index.php?controller=proyectos&action=reportePdf" target="_blank"
               class="inline-flex items-center justify-center space-x-2 bg-slate-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-slate-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="ph ph-file-pdf text-xl"></i>
                <span>Generar PDF</span>
            </a>
        </div>
    </div>

    <div id="table-container" class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden animate-slideIn"></div>

    <div id="pagination-container" class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white rounded-xl shadow-lg border border-slate-200 p-4" style="display: none;">
        <div id="pagination-info" class="text-sm text-slate-600 flex items-center space-x-2"></div>
        <div id="pagination-controls" class="flex items-center space-x-2"></div>
    </div>
</div>

<script src="<?php echo getBaseUrl() . 'js/paginacion.js'; ?>"></script>
<script>
$(document).ready(function() {
    const estados = {
        pendiente: {color: 'bg-amber-100 text-amber-800 border-amber-300', icono: 'ph-clock'},
        en_proceso: {color: 'bg-blue-100 text-blue-800 border-blue-300', icono: 'ph-gear'},
        completado: {color: 'bg-emerald-100 text-emerald-800 border-emerald-300', icono: 'ph-check-circle'},
        cancelado: {color: 'bg-red-100 text-red-800 border-red-300', icono: 'ph-x-circle'}
    };

    function renderizarProyectos(datos, paginacion) {
        if(datos.length === 0) {
            $('#table-container').html(Utilidades.mostrarVacio(
                'ph ph-folder-simple',
                'No hay proyectos registrados',
                'index.php?controller=proyectos&action=create',
                'Crear primer proyecto'
            ));
            return;
        }

        const encabezados = ['ID', 'Nombre', 'Cliente', 'Programador', 'Fecha Inicio', 'Fecha Fin', 'Estado', 'Presupuesto', 'Acciones'];
        let tabla = '<div class="overflow-x-auto"><table class="w-full"><thead class="bg-slate-800 text-white"><tr>';
        encabezados.forEach(h => tabla += `<th class="px-6 py-4 text-left text-sm font-semibold">${h}</th>`);
        tabla += '</tr></thead><tbody class="divide-y divide-slate-200">';

        datos.forEach(proyecto => {
            const estado = estados[proyecto.estado] || estados.pendiente;
            const estadoTexto = proyecto.estado.charAt(0).toUpperCase() + proyecto.estado.slice(1).replace('_', ' ');
            
            tabla += `<tr class="hover:bg-slate-50 transition-colors duration-150">
                <td class="px-6 py-4 text-sm text-slate-600 font-medium">${proyecto.id}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-folder', proyecto.nombre, 'font-semibold')}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-users', proyecto.cliente_nombre)}</td>
                <td class="px-6 py-4">${proyecto.programador_nombre ? Utilidades.crearCeldaConIcono('ph ph-user-gear', proyecto.programador_nombre) : '<span class="text-sm text-slate-400 italic">Sin asignar</span>'}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-calendar', Utilidades.formatearFecha(proyecto.fecha_inicio))}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-calendar-check', Utilidades.formatearFecha(proyecto.fecha_fin))}</td>
                <td class="px-6 py-4"><span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-semibold border ${estado.color}"><i class="ph ${estado.icono}"></i><span>${estadoTexto}</span></span></td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-currency-dollar', 'S/. ' + parseFloat(proyecto.presupuesto || 0).toFixed(2), 'font-semibold')}</td>
                <td class="px-6 py-4"><div class="flex items-center justify-center space-x-2">
                    ${Utilidades.crearBotonAccion('Editar', 'ph-pencil', `index.php?controller=proyectos&action=edit&id=${proyecto.id}`, 'bg-amber-500 hover:bg-amber-600')}
                    ${Utilidades.crearBotonAccion('Eliminar', 'ph-trash', `index.php?controller=proyectos&action=delete&id=${proyecto.id}`, 'bg-red-500 hover:bg-red-600', '¿Estás seguro de eliminar este proyecto?')}
                </div></td>
            </tr>`;
        });

        tabla += '</tbody></table></div>';
        $('#table-container').html(tabla);
    }

    inicializarPaginacion('proyectos', renderizarProyectos);
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
