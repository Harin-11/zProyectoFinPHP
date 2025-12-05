<?php
class Programador {
    private $conn;
    private $table = "programadores";

    public $id;
    public $nombre;
    public $email;
    public $telefono;
    public $especialidad;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los programadores
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY id ASC");
        $stmt->execute();
        return $stmt;
    }

    // Obtener programadores paginados
    public function getAllPaginated($limit = 10, $offset = 0) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY id ASC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Contar total de programadores
    public function getTotal() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM " . $this->table);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Obtener programadores disponibles
    public function getDisponibles() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE estado = 'disponible' ORDER BY id ASC");
        $stmt->execute();
        return $stmt;
    }

    // Obtener programador por ID
    public function getById() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach($row as $key => $value) {
                if(property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
            return true;
        }
        return false;
    }

    // Verificar si el programador está ocupado
    public function estaOcupado() {
        $query = "SELECT COUNT(*) as total FROM proyectos 
                  WHERE programador_id = :id 
                  AND estado IN ('pendiente', 'en_proceso')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }

    // Obtener proyectos del programador
    public function getProyectos() {
        $query = "SELECT p.*, c.nombre as cliente_nombre, c.empresa 
                  FROM proyectos p
                  LEFT JOIN clientes c ON p.cliente_id = c.id
                  WHERE p.programador_id = :id
                  ORDER BY p.id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    // Crear nuevo programador
    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (nombre, email, telefono, especialidad, estado) VALUES (:nombre, :email, :telefono, :especialidad, :estado)");
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':telefono' => $this->telefono,
            ':especialidad' => $this->especialidad,
            ':estado' => $this->estado
        ]);
    }

    // Actualizar programador
    public function update() {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET nombre = :nombre, email = :email, telefono = :telefono, especialidad = :especialidad, estado = :estado WHERE id = :id");
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':telefono' => $this->telefono,
            ':especialidad' => $this->especialidad,
            ':estado' => $this->estado,
            ':id' => $this->id
        ]);
    }

    // Actualizar estado del programador
    public function updateEstado($nuevoEstado) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET estado = :estado WHERE id = :id");
        return $stmt->execute([':estado' => $nuevoEstado, ':id' => $this->id]);
    }

    // Eliminar programador
    public function delete() {
        if($this->estaOcupado()) return false;
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
        return $stmt->execute([':id' => $this->id]);
    }
}
?>

