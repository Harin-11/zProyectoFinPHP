<?php
class Proyecto {
    private $conn;
    private $table = "proyectos";

    public $id;
    public $nombre;
    public $descripcion;
    public $cliente_id;
    public $programador_id;
    public $fecha_inicio;
    public $fecha_fin;
    public $estado;
    public $presupuesto;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Query base para proyectos con joins
    private function getBaseQuery() {
        return "SELECT p.*, c.nombre as cliente_nombre, c.empresa, 
                       pr.nombre as programador_nombre, pr.email as programador_email
                FROM " . $this->table . " p
                LEFT JOIN clientes c ON p.cliente_id = c.id
                LEFT JOIN programadores pr ON p.programador_id = pr.id";
    }

    // Obtener todos los proyectos
    public function getAll() {
        $stmt = $this->conn->prepare($this->getBaseQuery() . " ORDER BY p.id ASC");
        $stmt->execute();
        return $stmt;
    }

    // Obtener proyectos paginados
    public function getAllPaginated($limit = 10, $offset = 0) {
        $stmt = $this->conn->prepare($this->getBaseQuery() . " ORDER BY p.id ASC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Contar total de proyectos
    public function getTotal() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM " . $this->table);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Obtener proyecto por ID
    public function getById() {
        $stmt = $this->conn->prepare($this->getBaseQuery() . " WHERE p.id = :id LIMIT 1");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach(['id', 'nombre', 'descripcion', 'cliente_id', 'programador_id', 'fecha_inicio', 'fecha_fin', 'estado', 'presupuesto'] as $key) {
                if(isset($row[$key])) $this->$key = $row[$key];
            }
            return true;
        }
        return false;
    }

    public function create() {
        $programadorId = !empty($this->programador_id) ? $this->programador_id : null;
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (nombre, descripcion, cliente_id, programador_id, fecha_inicio, fecha_fin, estado, presupuesto) VALUES (:nombre, :descripcion, :cliente_id, :programador_id, :fecha_inicio, :fecha_fin, :estado, :presupuesto)");
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':cliente_id' => $this->cliente_id,
            ':programador_id' => $programadorId,
            ':fecha_inicio' => $this->fecha_inicio,
            ':fecha_fin' => $this->fecha_fin,
            ':estado' => $this->estado,
            ':presupuesto' => $this->presupuesto
        ]);
    }

    public function update() {
        $programadorId = !empty($this->programador_id) ? $this->programador_id : null;
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET nombre = :nombre, descripcion = :descripcion, cliente_id = :cliente_id, programador_id = :programador_id, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, estado = :estado, presupuesto = :presupuesto WHERE id = :id");
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':cliente_id' => $this->cliente_id,
            ':programador_id' => $programadorId,
            ':fecha_inicio' => $this->fecha_inicio,
            ':fecha_fin' => $this->fecha_fin,
            ':estado' => $this->estado,
            ':presupuesto' => $this->presupuesto,
            ':id' => $this->id
        ]);
    }

    // Eliminar proyecto
    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
        return $stmt->execute([':id' => $this->id]);
    }
}
?>