<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Programador.php';

class ProgramadorController extends BaseController {
    private $programador;

    public function __construct() {
        parent::__construct();
        $this->programador = new Programador($this->db);
    }

    public function index() {
        // Los datos se cargarán con AJAX
        require_once __DIR__ . '/../Views/programadores/index.php';
    }

    public function create() {
        require_once __DIR__ . '/../Views/programadores/create.php';
    }

    public function store() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $this->asignarDatosPost($this->programador, ['nombre', 'email', 'telefono', 'especialidad']);
        $this->programador->estado = 'disponible';
        $this->procesarAccion($this->programador, 'crear', 'Programador creado exitosamente', 'Error al crear programador', 'programadores');
    }

    public function edit() {
        $this->programador->id = $_GET['id'] ?? 0;
        if(!$this->programador->getById()) {
            $this->setMessage('error', 'Programador no encontrado');
            $this->redirect('programadores', 'index');
            return;
        }
        require_once __DIR__ . '/../Views/programadores/edit.php';
    }

    public function update() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $this->programador->id = $_POST['id'] ?? 0;
        $this->asignarDatosPost($this->programador, ['nombre', 'email', 'telefono', 'especialidad', 'estado']);
        $this->procesarAccion($this->programador, 'actualizar', 'Programador actualizado exitosamente', 'Error al actualizar programador', 'programadores');
    }

    public function delete() {
        $this->programador->id = $_GET['id'] ?? 0;
        if($this->programador->estaOcupado()) {
            $this->setMessage('error', 'No se puede eliminar el programador porque tiene proyectos asignados');
            $this->redirect('programadores', 'index');
            return;
        }
        $this->procesarAccion($this->programador, 'eliminar', 'Programador eliminado exitosamente', 'Error al eliminar programador', 'programadores');
    }

    public function historial() {
        $this->programador->id = $_GET['id'] ?? 0;
        if(!$this->programador->getById()) {
            $this->setMessage('error', 'Programador no encontrado');
            $this->redirect('programadores', 'index');
            return;
        }
        $proyectos = $this->programador->getProyectos()->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/programadores/historial.php';
    }

    public function reportePdf() {
        require_once __DIR__ . '/../utils/PdfGenerator.php';
        $programadores = $this->programador->getAll()->fetchAll(PDO::FETCH_ASSOC);
        PdfGenerator::generarReporteProgramadores($programadores);
    }

    public function obtenerPaginados() {
        $this->responderPaginado($this->programador, function($programadores) {
            foreach($programadores as &$prog) {
                $this->programador->id = $prog['id'];
                $prog['esta_ocupado'] = $this->programador->estaOcupado();
                $prog['proyectos'] = $this->programador->getProyectos()->fetchAll(PDO::FETCH_ASSOC);
            }
            return $programadores;
        });
    }
}
?>

