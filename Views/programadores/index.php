<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="animate-fadeIn">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-6 border-b border-slate-200">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-slate-800 flex items-center space-x-3">
                <i class="ph ph-user-gear text-emerald-600"></i>
                <span>Gestión de Programadores</span>
            </h1>
            <p class="text-slate-600 mt-2">Administra tu equipo de desarrollo</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="index.php?controller=programadores&action=create" 
               class="inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="ph ph-plus-circle text-xl"></i>
                <span>Nuevo Programador</span>
            </a>
            <a href="index.php?controller=programadores&action=reportePdf" target="_blank"
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
    function renderizarProgramadores(datos, paginacion) {
        if(datos.length === 0) {
            $('#table-container').html(Utilidades.mostrarVacio(
                'ph ph-user-gear',
                'No hay programadores registrados',
                'index.php?controller=programadores&action=create',
                'Agregar primer programador'
            ));
            return;
        }

        const encabezados = ['ID', 'Nombre', 'Email', 'Teléfono', 'Especialidad', 'Estado', 'Proyectos Activos', 'Acciones'];
        let tabla = '<div class="overflow-x-auto"><table class="w-full"><thead class="bg-slate-800 text-white"><tr>';
        encabezados.forEach(h => tabla += `<th class="px-6 py-4 text-left text-sm font-semibold">${h}</th>`);
        tabla += '</tr></thead><tbody class="divide-y divide-slate-200">';

        datos.forEach(programador => {
            const proyectosActivos = (programador.proyectos || []).filter(p => ['pendiente', 'en_proceso'].includes(p.estado));
            const estadoBadge = programador.estado === 'disponible' 
                ? '<span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300"><i class="ph ph-check-circle"></i><span>Disponible</span></span>'
                : '<span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-300"><i class="ph ph-clock"></i><span>Ocupado</span></span>';
            
            tabla += `<tr class="hover:bg-slate-50 transition-colors duration-150">
                <td class="px-6 py-4 text-sm text-slate-600 font-medium">${programador.id}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-user', programador.nombre, 'font-semibold')}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-envelope', programador.email)}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-phone', programador.telefono)}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-code', programador.especialidad)}</td>
                <td class="px-6 py-4">${estadoBadge}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-folder-open', proyectosActivos.length, 'font-semibold')}</td>
                <td class="px-6 py-4"><div class="flex items-center justify-center space-x-2">
                    ${Utilidades.crearBotonAccion('Historial', 'ph-list-bullets', `index.php?controller=programadores&action=historial&id=${programador.id}`, 'bg-blue-500 hover:bg-blue-600')}
                    ${Utilidades.crearBotonAccion('Editar', 'ph-pencil', `index.php?controller=programadores&action=edit&id=${programador.id}`, 'bg-amber-500 hover:bg-amber-600')}
                    ${Utilidades.crearBotonAccion('Eliminar', 'ph-trash', `index.php?controller=programadores&action=delete&id=${programador.id}`, 'bg-red-500 hover:bg-red-600', '¿Estás seguro de eliminar este programador?')}
                </div></td>
            </tr>`;
        });

        tabla += '</tbody></table></div>';
        $('#table-container').html(tabla);
    }

    inicializarPaginacion('programadores', renderizarProgramadores);
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
