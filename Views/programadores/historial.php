<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="animate-fadeIn">
    <div class="mb-6">
        <a href="index.php?controller=programadores&action=index" 
           class="inline-flex items-center space-x-2 text-slate-600 hover:text-slate-800 transition-colors duration-200 mb-4">
            <i class="ph ph-arrow-left"></i>
            <span class="font-medium">Volver a Programadores</span>
        </a>
        <h1 class="text-3xl font-bold text-slate-800 flex items-center space-x-3">
            <i class="ph ph-list-bullets text-emerald-600"></i>
            <span>Historial de Proyectos - <?php echo htmlspecialchars($this->programador->nombre); ?></span>
        </h1>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6 mb-6 animate-slideIn">
        <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center space-x-2">
            <i class="ph ph-user-gear text-emerald-600"></i>
            <span>Información del Programador</span>
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center space-x-3">
                <i class="ph ph-envelope text-slate-400 text-xl"></i>
                <div>
                    <p class="text-xs text-slate-500">Email</p>
                    <p class="font-semibold text-slate-800"><?php echo htmlspecialchars($this->programador->email); ?></p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <i class="ph ph-phone text-slate-400 text-xl"></i>
                <div>
                    <p class="text-xs text-slate-500">Teléfono</p>
                    <p class="font-semibold text-slate-800"><?php echo htmlspecialchars($this->programador->telefono ?? 'N/A'); ?></p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <i class="ph ph-code text-slate-400 text-xl"></i>
                <div>
                    <p class="text-xs text-slate-500">Especialidad</p>
                    <p class="font-semibold text-slate-800"><?php echo htmlspecialchars($this->programador->especialidad ?? 'N/A'); ?></p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <i class="ph ph-circle-dashed text-slate-400 text-xl"></i>
                <div>
                    <p class="text-xs text-slate-500">Estado</p>
                    <?php if($this->programador->estado == 'disponible'): ?>
                        <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300">
                            <i class="ph ph-check-circle"></i>
                            <span>Disponible</span>
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-300">
                            <i class="ph ph-clock"></i>
                            <span>Ocupado</span>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden animate-slideIn">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-800 flex items-center space-x-2">
                <i class="ph ph-folder-open text-emerald-600"></i>
                <span>Proyectos Asignados</span>
            </h2>
        </div>
        <?php if(empty($proyectos)): ?>
            <div class="p-12 text-center">
                <i class="ph ph-folder-simple text-6xl text-slate-300 mb-4"></i>
                <p class="text-slate-500 text-lg font-medium">Este programador no tiene proyectos asignados</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-800 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Proyecto</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Cliente</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Fecha Inicio</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Fecha Fin</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Estado</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Presupuesto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php 
                        $estadoColors = [
                            'pendiente' => 'bg-amber-100 text-amber-800 border-amber-300',
                            'en_proceso' => 'bg-blue-100 text-blue-800 border-blue-300',
                            'completado' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                            'cancelado' => 'bg-red-100 text-red-800 border-red-300'
                        ];
                        $estadoIcons = [
                            'pendiente' => 'ph-clock',
                            'en_proceso' => 'ph-gear',
                            'completado' => 'ph-check-circle',
                            'cancelado' => 'ph-x-circle'
                        ];
                        foreach($proyectos as $index => $proyecto): 
                        ?>
                            <tr class="hover:bg-slate-50 transition-colors duration-150 animate-slideIn" style="animation-delay: <?php echo $index * 0.05; ?>s">
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium"><?php echo htmlspecialchars($proyecto['id']); ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <i class="ph ph-folder text-slate-400"></i>
                                        <span class="text-sm font-semibold text-slate-800"><?php echo htmlspecialchars($proyecto['nombre']); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <i class="ph ph-users text-slate-400"></i>
                                        <span class="text-sm text-slate-700"><?php echo htmlspecialchars($proyecto['cliente_nombre'] ?? 'N/A'); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <i class="ph ph-calendar text-slate-400"></i>
                                        <span class="text-sm text-slate-700"><?php echo $proyecto['fecha_inicio'] ? date('d/m/Y', strtotime($proyecto['fecha_inicio'])) : 'N/A'; ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <i class="ph ph-calendar-check text-slate-400"></i>
                                        <span class="text-sm text-slate-700"><?php echo $proyecto['fecha_fin'] ? date('d/m/Y', strtotime($proyecto['fecha_fin'])) : 'N/A'; ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-semibold border <?php echo $estadoColors[$proyecto['estado']] ?? $estadoColors['pendiente']; ?>">
                                        <i class="ph <?php echo $estadoIcons[$proyecto['estado']] ?? $estadoIcons['pendiente']; ?>"></i>
                                        <span><?php echo ucfirst(str_replace('_', ' ', $proyecto['estado'])); ?></span>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <i class="ph ph-currency-dollar text-slate-400"></i>
                                        <span class="text-sm font-semibold text-slate-800">S/. <?php echo number_format($proyecto['presupuesto'], 2); ?></span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

