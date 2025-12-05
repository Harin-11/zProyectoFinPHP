<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Proyectos - TecnoSoluciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="<?php echo getBaseUrl() . '../jquery/jquery-3.7.1.min.js'; ?>"></script>
    <script src="<?php echo getBaseUrl() . 'js/utilidades.js'; ?>"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .animate-fadeIn { animation: fadeIn 0.5s ease-out; }
        .animate-slideIn { animation: slideIn 0.4s ease-out; }
        .animate-pulse-icon { animation: pulse 2s ease-in-out infinite; }
        .icon-hover:hover { transform: scale(1.1); transition: transform 0.2s; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col">
    <?php if(isset($_SESSION['user_id'])): ?>
    <nav class="bg-slate-800 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <i class="ph ph-code-bold text-2xl text-emerald-400 animate-pulse-icon"></i>
                    <h2 class="text-xl font-bold text-white">TecnoSoluciones S.A.</h2>
                </div>
                <ul class="flex items-center space-x-6">
                    <li>
                        <a href="index.php?controller=clientes&action=index" 
                           class="flex items-center space-x-2 text-slate-200 hover:text-emerald-400 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-slate-700">
                            <i class="ph ph-users text-lg icon-hover"></i>
                            <span class="font-medium">Clientes</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?controller=proyectos&action=index" 
                           class="flex items-center space-x-2 text-slate-200 hover:text-emerald-400 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-slate-700">
                            <i class="ph ph-folder-open text-lg icon-hover"></i>
                            <span class="font-medium">Proyectos</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?controller=programadores&action=index" 
                           class="flex items-center space-x-2 text-slate-200 hover:text-emerald-400 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-slate-700">
                            <i class="ph ph-user-gear text-lg icon-hover"></i>
                            <span class="font-medium">Programadores</span>
                        </a>
                    </li>
                    <li class="flex items-center space-x-4 pl-6 border-l border-slate-600">
                        <div class="flex items-center space-x-2 text-slate-300">
                            <i class="ph ph-user-circle text-xl"></i>
                            <span class="text-sm"><?php echo htmlspecialchars($_SESSION['user_nombre']); ?></span>
                        </div>
                        <a href="index.php?controller=auth&action=logout" 
                           class="flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-all duration-200 hover:shadow-lg">
                            <i class="ph ph-sign-out text-lg"></i>
                            <span class="font-medium">Salir</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <main class="flex-grow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if(isset($_SESSION['success'])): ?>
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-md animate-fadeIn flex items-center space-x-3">
                <i class="ph ph-check-circle text-2xl"></i>
                <div>
                    <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md animate-fadeIn flex items-center space-x-3">
                <i class="ph ph-warning-circle text-2xl"></i>
                <div>
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                    ?>
                </div>
            </div>
        <?php endif; ?>