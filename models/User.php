<?php
class User {
    private $conn;
    private $table = "usuarios";
    public $id;
    public $nombre;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Registrar nuevo usuario
    public function register() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (nombre, email, password) VALUES (:nombre, :email, :password)");
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':password' => $this->password
        ]);
    }

    // Login de usuario
    public function login() {
        $stmt = $this->conn->prepare("SELECT id, nombre, email, password FROM " . $this->table . " WHERE email = :email LIMIT 1");
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->nombre = $row['nombre'];
                $this->email = $row['email'];
                return true;
            }
        }
        return false;
    }

    // Verificar si el email ya existe
    public function emailExists() {
        $stmt = $this->conn->prepare("SELECT id FROM " . $this->table . " WHERE email = :email LIMIT 1");
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>