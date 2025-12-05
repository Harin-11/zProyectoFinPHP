<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="animate-fadeIn">
    <div class="mb-6">
        <a href="index.php?controller=proyectos&action=index" 
           class="inline-flex items-center space-x-2 text-slate-600 hover:text-slate-800 transition-colors duration-200 mb-4">
            <i class="ph ph-arrow-left"></i>
            <span class="font-medium">Volver a Proyectos</span>
        </a>
        <h1 class="text-3xl font-bold text-slate-800 flex items-center space-x-3">
            <i class="ph ph-pencil text-emerald-600"></i>
            <span>Editar Proyecto</span>
        </h1>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-8 max-w-4xl">
        <form method="POST" action="index.php?controller=proyectos&action=update" class="space-y-6">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($this->proyecto->id); ?>">

            <div class="space-y-2">
                <label for="nombre" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                    <i class="ph ph-folder text-emerald-600"></i>
                    <span>Nombre del Proyecto <span class="text-red-500">*</span></span>
                </label>
                <input type="text" id="nombre" name="nombre" 
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                       value="<?php echo htmlspecialchars($this->proyecto->nombre); ?>" required>
            </div>

            <div class="space-y-2">
                <label for="descripcion" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                    <i class="ph ph-file-text text-emerald-600"></i>
                    <span>Descripción</span>
                </label>
                <textarea id="descripcion" name="descripcion" rows="4"
                          class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none resize-none"><?php echo htmlspecialchars($this->proyecto->descripcion); ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="cliente_id" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-users text-emerald-600"></i>
                        <span>Cliente <span class="text-red-500">*</span></span>
                    </label>
                    <select id="cliente_id" name="cliente_id" 
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none bg-white"
                            required>
                        <option value="">Seleccione un cliente</option>
                        <?php foreach($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id']; ?>" 
                                    <?php echo ($cliente['id'] == $this->proyecto->cliente_id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cliente['nombre']) . ' - ' . htmlspecialchars($cliente['empresa']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="programador_id" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-user-gear text-emerald-600"></i>
                        <span>Programador</span>
                    </label>
                    <select id="programador_id" name="programador_id" 
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none bg-white">
                        <option value="">Sin asignar</option>
                        <?php if(!empty($programadores)): ?>
                            <?php foreach($programadores as $programador): ?>
                                <option value="<?php echo $programador['id']; ?>" 
                                        <?php echo ($programador['id'] == $this->proyecto->programador_id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($programador['nombre']); ?>
                                    <?php if(!empty($programador['especialidad'])): ?>
                                        - <?php echo htmlspecialchars($programador['especialidad']); ?>
                                    <?php endif; ?>
                                    <?php if(isset($programador['estado']) && $programador['estado'] == 'ocupado' && $programador['id'] != $this->proyecto->programador_id): ?>
                                        (Ocupado)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <p class="text-xs text-slate-500 mt-1 flex items-center space-x-1">
                        <i class="ph ph-info"></i>
                        <span>Solo se muestran programadores disponibles y el asignado actual</span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="fecha_inicio" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-calendar text-emerald-600"></i>
                        <span>Fecha Inicio <span class="text-red-500">*</span></span>
                    </label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           value="<?php echo htmlspecialchars($this->proyecto->fecha_inicio); ?>" required>
                </div>

                <div class="space-y-2">
                    <label for="fecha_fin" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-calendar-check text-emerald-600"></i>
                        <span>Fecha Fin <span class="text-red-500">*</span></span>
                    </label>
                    <input type="date" id="fecha_fin" name="fecha_fin" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           value="<?php echo htmlspecialchars($this->proyecto->fecha_fin); ?>" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="estado" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-circle-dashed text-emerald-600"></i>
                        <span>Estado <span class="text-red-500">*</span></span>
                    </label>
                    <select id="estado" name="estado" 
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none bg-white"
                            required>
                        <option value="pendiente" <?php echo ($this->proyecto->estado == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="en_proceso" <?php echo ($this->proyecto->estado == 'en_proceso') ? 'selected' : ''; ?>>En Proceso</option>
                        <option value="completado" <?php echo ($this->proyecto->estado == 'completado') ? 'selected' : ''; ?>>Completado</option>
                        <option value="cancelado" <?php echo ($this->proyecto->estado == 'cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="presupuesto" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-currency-dollar text-emerald-600"></i>
                        <span>Presupuesto (S/.) <span class="text-red-500">*</span></span>
                    </label>
                    <input type="number" id="presupuesto" name="presupuesto" 
                           step="0.01" min="0"
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           value="<?php echo htmlspecialchars($this->proyecto->presupuesto); ?>" required>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-slate-200">
                <button type="submit" 
                        class="flex-1 inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="ph ph-floppy-disk text-xl"></i>
                    <span>Actualizar Proyecto</span>
                </button>
                <a href="index.php?controller=proyectos&action=index" 
                   class="flex-1 inline-flex items-center justify-center space-x-2 bg-slate-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-slate-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <i class="ph ph-x text-xl"></i>
                    <span>Cancelar</span>
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
