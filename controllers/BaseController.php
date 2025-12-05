<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';

class BaseController {
    protected $db;

    public function __construct() {
        if(!$this->isAuthController()) {
            $this->requireAuth();
        }
        $database = new Database();
        $this->db = $database->getConnection();
    }

    protected function requireAuth() {
        if(!isset($_SESSION['user_id'])) {
            header("Location: " . url('auth', 'showLogin'));
            exit();
        }
    }

    protected function isAuthController() {
        return get_class($this) === 'AuthController';
    }

    protected function redirect($controller, $action, $params = []) {
        header("Location: " . url($controller, $action, $params));
        exit();
    }

    protected function setMessage($type, $message) {
        $_SESSION[$type] = $message;
    }

    // Helper para procesar acciones CRUD
    protected function procesarAccion($modelo, $accion, $mensajeExito, $mensajeError, $redirectController) {
        $metodos = ['crear' => 'create', 'actualizar' => 'update', 'eliminar' => 'delete'];
        $metodo = $metodos[$accion] ?? null;
        if(!$metodo || !method_exists($modelo, $metodo)) return;
        
        $resultado = $modelo->$metodo();
        $this->setMessage($resultado ? 'success' : 'error', $resultado ? $mensajeExito : $mensajeError);
        $this->redirect($redirectController, 'index');
    }

    // Helper para asignar datos POST a modelo
    protected function asignarDatosPost($modelo, $campos) {
        foreach($campos as $campo) {
            if(property_exists($modelo, $campo)) {
                $modelo->$campo = $_POST[$campo] ?? '';
            }
        }
    }

    // Helper para respuesta JSON paginada
    protected function responderPaginado($modelo, $procesarDatos = null) {
        header('Content-Type: application/json');
        $pagina = (int)($_GET['page'] ?? 1);
        $porPagina = 10;
        $desplazamiento = ($pagina - 1) * $porPagina;
        
        $total = $modelo->getTotal();
        $totalPaginas = ceil($total / $porPagina);
        $datos = $modelo->getAllPaginated($porPagina, $desplazamiento)->fetchAll(PDO::FETCH_ASSOC);
        
        if($procesarDatos && is_callable($procesarDatos)) {
            $datos = $procesarDatos($datos);
        }
        
        echo json_encode([
            'exito' => true,
            'datos' => $datos,
            'paginacion' => [
                'pagina_actual' => $pagina,
                'total_paginas' => $totalPaginas,
                'total' => $total,
                'por_pagina' => $porPagina
            ]
        ]);
        exit;
    }
}
?>

