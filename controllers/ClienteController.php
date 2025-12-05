<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController extends BaseController {
    private $cliente;

    public function __construct() {
        parent::__construct();
        $this->cliente = new Cliente($this->db);
    }

    public function index() {
        // Los datos se cargarán con AJAX
        require_once __DIR__ . '/../Views/clientes/index.php';
    }

    public function create() {
        require_once __DIR__ . '/../Views/clientes/create.php';
    }

    public function store() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $this->asignarDatosPost($this->cliente, ['nombre', 'empresa', 'email', 'telefono', 'direccion']);
        $this->procesarAccion($this->cliente, 'crear', 'Cliente creado exitosamente', 'Error al crear cliente', 'clientes');
    }

    public function edit() {
        $this->cliente->id = $_GET['id'] ?? 0;
        if(!$this->cliente->getById()) {
            $this->setMessage('error', 'Cliente no encontrado');
            $this->redirect('clientes', 'index');
            return;
        }
        require_once __DIR__ . '/../Views/clientes/edit.php';
    }

    public function update() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $this->cliente->id = $_POST['id'] ?? 0;
        $this->asignarDatosPost($this->cliente, ['nombre', 'empresa', 'email', 'telefono', 'direccion']);
        $this->procesarAccion($this->cliente, 'actualizar', 'Cliente actualizado exitosamente', 'Error al actualizar cliente', 'clientes');
    }

    public function delete() {
        $this->cliente->id = $_GET['id'] ?? 0;
        $this->procesarAccion($this->cliente, 'eliminar', 'Cliente eliminado exitosamente', 'Error al eliminar cliente', 'clientes');
    }

    public function reportePdf() {
        require_once __DIR__ . '/../utils/PdfGenerator.php';
        $clientes = $this->cliente->getAll()->fetchAll(PDO::FETCH_ASSOC);
        PdfGenerator::generarReporteClientes($clientes);
    }

    public function obtenerPaginados() {
        $this->responderPaginado($this->cliente);
    }
}
?>