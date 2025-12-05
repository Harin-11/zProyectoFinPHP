<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Proyecto.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Programador.php';

class ProyectoController extends BaseController
{
    private $proyecto;
    private $cliente;
    private $programador;

    public function __construct()
    {
        parent::__construct();
        $this->proyecto = new Proyecto($this->db);
        $this->cliente = new Cliente($this->db);
        $this->programador = new Programador($this->db);
    }

    public function index()
    {
        // Los datos se cargarán con AJAX
        require_once __DIR__ . '/../Views/proyectos/index.php';
    }

    public function create()
    {
        $clientes = $this->cliente->getAll()->fetchAll(PDO::FETCH_ASSOC);
        $programadores = $this->programador->getDisponibles()->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/proyectos/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->asignarDatosPost($this->proyecto, ['nombre', 'descripcion', 'fecha_inicio', 'fecha_fin', 'estado']);
        $this->proyecto->cliente_id = (int)($_POST['cliente_id'] ?? 0);
        $this->proyecto->presupuesto = (float)($_POST['presupuesto'] ?? 0);
        $programadorId = !empty($_POST['programador_id']) ? (int)$_POST['programador_id'] : null;
        $this->proyecto->programador_id = $programadorId;

        // Validar programador disponible
        if ($programadorId && ($this->programador->id = $programadorId) && $this->programador->estaOcupado()) {
            $this->setMessage('error', 'El programador seleccionado ya está asignado a otro proyecto');
            $this->redirect('proyectos', 'create');
            return;
        }

        if ($this->proyecto->create()) {
            // Actualizar estado del programador si es necesario
            if ($programadorId && in_array($this->proyecto->estado, ['pendiente', 'en_proceso'])) {
                $this->programador->id = $programadorId;
                $this->programador->updateEstado('ocupado');
            }
            $this->setMessage('success', 'Proyecto creado exitosamente');
        } else {
            $this->setMessage('error', 'Error al crear proyecto');
        }
        $this->redirect('proyectos', 'index');
    }

    public function edit()
    {
        $this->proyecto->id = $_GET['id'] ?? 0;
        if (!$this->proyecto->getById()) {
            $this->setMessage('error', 'Proyecto no encontrado');
            $this->redirect('proyectos', 'index');
            return;
        }

        $clientes = $this->cliente->getAll()->fetchAll(PDO::FETCH_ASSOC);
        $programadores = $this->programador->getDisponibles()->fetchAll(PDO::FETCH_ASSOC);

        // Agregar programador actual si no está disponible
        if ($this->proyecto->programador_id) {
            $this->programador->id = $this->proyecto->programador_id;
            if ($this->programador->getById() && !in_array($this->programador->id, array_column($programadores, 'id'))) {
                $programadores[] = [
                    'id' => $this->programador->id,
                    'nombre' => $this->programador->nombre,
                    'email' => $this->programador->email,
                    'estado' => $this->programador->estado
                ];
            }
        }

        require_once __DIR__ . '/../Views/proyectos/edit.php';
    }

    // Helper para actualizar estado del programador según el proyecto
    private function actualizarEstadoProgramador($programadorId, $estadoProyecto)
    {
        if (!$programadorId) return;
        $this->programador->id = $programadorId;
        if (in_array($estadoProyecto, ['pendiente', 'en_proceso'])) {
            $this->programador->updateEstado('ocupado');
        } elseif (in_array($estadoProyecto, ['completado', 'cancelado']) && !$this->programador->estaOcupado()) {
            $this->programador->updateEstado('disponible');
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->proyecto->id = $_POST['id'] ?? 0;
        $proyectoActual = new Proyecto($this->db);
        $proyectoActual->id = $this->proyecto->id;
        $programadorAnterior = $proyectoActual->getById() ? $proyectoActual->programador_id : null;

        $this->asignarDatosPost($this->proyecto, ['nombre', 'descripcion', 'fecha_inicio', 'fecha_fin', 'estado']);
        $this->proyecto->cliente_id = (int)($_POST['cliente_id'] ?? 0);
        $this->proyecto->presupuesto = (float)($_POST['presupuesto'] ?? 0);
        $programadorId = !empty($_POST['programador_id']) ? (int)$_POST['programador_id'] : null;
        $this->proyecto->programador_id = $programadorId;

        // Validar programador si cambió
        if ($programadorId && $programadorId != $programadorAnterior && ($this->programador->id = $programadorId) && $this->programador->estaOcupado()) {
            $this->setMessage('error', 'El programador seleccionado ya está asignado a otro proyecto');
            $this->redirect('proyectos', 'edit', ['id' => $this->proyecto->id]);
            return;
        }

        if ($this->proyecto->update()) {
            // Liberar programador anterior si cambió
            if ($programadorAnterior && $programadorAnterior != $programadorId) {
                $this->programador->id = $programadorAnterior;
                if (!$this->programador->estaOcupado()) {
                    $this->programador->updateEstado('disponible');
                }
            }
            // Actualizar estado del programador actual
            $this->actualizarEstadoProgramador($programadorId, $this->proyecto->estado);
            $this->setMessage('success', 'Proyecto actualizado exitosamente');
        } else {
            $this->setMessage('error', 'Error al actualizar proyecto');
        }
        $this->redirect('proyectos', 'index');
    }

    public function delete()
    {
        $this->proyecto->id = $_GET['id'] ?? 0;
        $programadorId = ($this->proyecto->getById() && $this->proyecto->programador_id) ? $this->proyecto->programador_id : null;

        if ($this->proyecto->delete()) {
            // Liberar programador si no tiene más proyectos activos
            if ($programadorId) {
                $this->programador->id = $programadorId;
                if (!$this->programador->estaOcupado()) {
                    $this->programador->updateEstado('disponible');
                }
            }
            $this->setMessage('success', 'Proyecto eliminado exitosamente');
        } else {
            $this->setMessage('error', 'Error al eliminar proyecto');
        }
        $this->redirect('proyectos', 'index');
    }

    public function reportePdf()
    {
        require_once __DIR__ . '/../utils/PdfGenerator.php';
        $proyectos = $this->proyecto->getAll()->fetchAll(PDO::FETCH_ASSOC);
        PdfGenerator::generarReporteProyectos($proyectos);
    }

    public function obtenerPaginados()
    {
        $this->responderPaginado($this->proyecto);
    }
}
