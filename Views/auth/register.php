<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="min-h-[calc(100vh-200px)] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md animate-fadeIn">
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-200">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full mb-4 animate-pulse-icon">
                    <i class="ph ph-user-plus text-3xl text-white"></i>
                </div>
                <h2 class="text-3xl font-bold text-slate-800 mb-2">Registrarse</h2>
                <p class="text-slate-600">Crea tu cuenta en el sistema</p>
            </div>

            <form method="POST" action="index.php?controller=auth&action=register" class="space-y-5">
                <div class="space-y-2">
                    <label for="nombre" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-user text-emerald-600"></i>
                        <span>Nombre Completo</span>
                    </label>
                    <input type="text" id="nombre" name="nombre" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           placeholder="Juan Pérez" required>
                </div>

                <div class="space-y-2">
                    <label for="email" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-envelope text-emerald-600"></i>
                        <span>Email</span>
                    </label>
                    <input type="email" id="email" name="email" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           placeholder="tu@email.com" required>
                </div>

                <div class="space-y-2">
                    <label for="password" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-lock text-emerald-600"></i>
                        <span>Contraseña</span>
                    </label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           placeholder="••••••••" required>
                </div>

                <div class="space-y-2">
                    <label for="password_confirm" class="flex items-center space-x-2 text-sm font-semibold text-slate-700">
                        <i class="ph ph-lock-key text-emerald-600"></i>
                        <span>Confirmar Contraseña</span>
                    </label>
                    <input type="password" id="password_confirm" name="password_confirm" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 outline-none"
                           placeholder="••••••••" required>
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-3 rounded-lg font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                    <i class="ph ph-user-plus text-xl"></i>
                    <span>Registrarse</span>
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-slate-600 text-sm">
                    ¿Ya tienes cuenta? 
                    <a href="index.php?controller=auth&action=showLogin" 
                       class="text-emerald-600 hover:text-emerald-700 font-semibold transition-colors duration-200">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>