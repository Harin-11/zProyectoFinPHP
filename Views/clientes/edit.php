<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="animate-fadeIn">
    <div class="mb-6">
        <a href="index.php?controller=clientes&action=index" 
           class="inline-flex items-center space-x-2 text-slate-600 hover:text-slate-800 transition-colors duration-200 mb-4">
            <i class="ph ph-arrow-left"></i>
            <span class="font-medium">Volver a Clientes</span>
        </a>
        <h1 class="text-3xl font-bold text-slate-800 flex items-center space-x-3">
            <i class="ph ph-pencil text-emerald-600"></i>
            <span>Editar Cliente</span>
        </h1>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-8 max-w-3xl">
        <form method="POST" action="index.php?controller=clientes&action=update" class="space-y-6">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($this->cliente->id); ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2 space-y-2">
                    <label for="nombre" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-user text-emerald-600"></i>
                        <span>Nombre Completo <span class="text-red-500">*</span></span>
                    </label>
                    <input type="text" id="nombre" name="nombre" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           value="<?php echo htmlspecialchars($this->cliente->nombre); ?>" required>
                </div>

                <div class="space-y-2">
                    <label for="empresa" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-buildings text-emerald-600"></i>
                        <span>Empresa</span>
                    </label>
                    <input type="text" id="empresa" name="empresa" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           value="<?php echo htmlspecialchars($this->cliente->empresa); ?>">
                </div>

                <div class="space-y-2">
                    <label for="email" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-envelope text-emerald-600"></i>
                        <span>Email</span>
                    </label>
                    <input type="email" id="email" name="email" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           value="<?php echo htmlspecialchars($this->cliente->email); ?>">
                </div>

                <div class="space-y-2">
                    <label for="telefono" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-phone text-emerald-600"></i>
                        <span>Teléfono</span>
                    </label>
                    <input type="text" id="telefono" name="telefono" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           value="<?php echo htmlspecialchars($this->cliente->telefono); ?>">
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label for="direccion" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-map-pin text-emerald-600"></i>
                        <span>Dirección</span>
                    </label>
                    <textarea id="direccion" name="direccion" rows="3"
                              class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none resize-none"><?php echo htmlspecialchars($this->cliente->direccion); ?></textarea>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-slate-200">
                <button type="submit" 
                        class="flex-1 inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="ph ph-floppy-disk text-xl"></i>
                    <span>Actualizar Cliente</span>
                </button>
                <a href="index.php?controller=clientes&action=index" 
                   class="flex-1 inline-flex items-center justify-center space-x-2 bg-slate-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-slate-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <i class="ph ph-x text-xl"></i>
                    <span>Cancelar</span>
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>