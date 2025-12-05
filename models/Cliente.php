<?php
class Cliente
{
    private $conn;
    private $table = "clientes";

    public $id;
    public $nombre;
    public $empresa;
    public $email;
    public $telefono;
    public $direccion;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Obtener todos los clientes
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY id ASC");
        $stmt->execute();
        return $stmt;
    }

    // Obtener clientes paginados
    public function getAllPaginated($limit = 10, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Contar total de clientes
    public function getTotal() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM " . $this->table);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Obtener cliente por ID
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

    // Crear nuevo cliente
    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (nombre, empresa, email, telefono, direccion) VALUES (:nombre, :empresa, :email, :telefono, :direccion)");
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':empresa' => $this->empresa,
            ':email' => $this->email,
            ':telefono' => $this->telefono,
            ':direccion' => $this->direccion
        ]);
    }

    // Actualizar cliente
    public function update() {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET nombre = :nombre, empresa = :empresa, email = :email, telefono = :telefono, direccion = :direccion WHERE id = :id");
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':empresa' => $this->empresa,
            ':email' => $this->email,
            ':telefono' => $this->telefono,
            ':direccion' => $this->direccion,
            ':id' => $this->id
        ]);
    }

    // Eliminar cliente
    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
        return $stmt->execute([':id' => $this->id]);
    }
}
