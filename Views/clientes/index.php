<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="animate-fadeIn">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-6 border-b border-slate-200">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-slate-800 flex items-center space-x-3">
                <i class="ph ph-users text-emerald-600"></i>
                <span>Gestión de Clientes</span>
            </h1>
            <p class="text-slate-600 mt-2">Administra la información de tus clientes</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="index.php?controller=clientes&action=create" 
               class="inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="ph ph-plus-circle text-xl"></i>
                <span>Nuevo Cliente</span>
            </a>
            <a href="index.php?controller=clientes&action=reportePdf" target="_blank"
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
    function renderizarClientes(datos, paginacion) {
        if(datos.length === 0) {
            $('#table-container').html(Utilidades.mostrarVacio(
                'ph ph-users-three',
                'No hay clientes registrados',
                'index.php?controller=clientes&action=create',
                'Agregar primer cliente'
            ));
            return;
        }

        const encabezados = ['ID', 'Nombre', 'Empresa', 'Email', 'Teléfono', 'Acciones'];
        let tabla = '<div class="overflow-x-auto"><table class="w-full"><thead class="bg-slate-800 text-white"><tr>';
        encabezados.forEach(h => tabla += `<th class="px-6 py-4 text-left text-sm font-semibold">${h}</th>`);
        tabla += '</tr></thead><tbody class="divide-y divide-slate-200">';

        datos.forEach(cliente => {
            tabla += `<tr class="hover:bg-slate-50 transition-colors duration-150">
                <td class="px-6 py-4 text-sm text-slate-600 font-medium">${cliente.id}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-user', cliente.nombre, 'font-semibold')}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-buildings', cliente.empresa)}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-envelope', cliente.email)}</td>
                <td class="px-6 py-4">${Utilidades.crearCeldaConIcono('ph ph-phone', cliente.telefono)}</td>
                <td class="px-6 py-4"><div class="flex items-center justify-center space-x-2">
                    ${Utilidades.crearBotonAccion('Editar', 'ph-pencil', `index.php?controller=clientes&action=edit&id=${cliente.id}`, 'bg-amber-500 hover:bg-amber-600')}
                    ${Utilidades.crearBotonAccion('Eliminar', 'ph-trash', `index.php?controller=clientes&action=delete&id=${cliente.id}`, 'bg-red-500 hover:bg-red-600', '¿Estás seguro de eliminar este cliente?')}
                </div></td>
            </tr>`;
        });

        tabla += '</tbody></table></div>';
        $('#table-container').html(tabla);
    }

    inicializarPaginacion('clientes', renderizarClientes);
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
