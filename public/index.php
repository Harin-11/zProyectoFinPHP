<?php
$controlador = $_GET['controller'] ?? 'auth';
$accion = $_GET['action'] ?? 'showLogin';

$controladores = [
    'auth' => 'AuthController',
    'clientes' => 'ClienteController',
    'proyectos' => 'ProyectoController',
    'programadores' => 'ProgramadorController'
];

if (!isset($controladores[$controlador])) {
    die("Controlador no encontrado");
}

require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../controllers/' . $controladores[$controlador] . '.php';

$nombreControlador = $controladores[$controlador];
if (!class_exists($nombreControlador)) {
    die("Clase de controlador no encontrada: " . $nombreControlador);
}

$instancia = new $nombreControlador();
if (!method_exists($instancia, $accion)) {
    die("Acción no encontrada");
}

$instancia->$accion();
