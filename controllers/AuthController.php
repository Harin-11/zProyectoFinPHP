<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends BaseController {
    private $user;

    public function __construct() {
        parent::__construct();
        $this->user = new User($this->db);
    }

    public function showLogin() {
        if(isset($_SESSION['user_id'])) {
            $this->redirect('clientes', 'index');
            return;
        }
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        
        $this->user->email = $_POST['email'] ?? '';
        $this->user->password = $_POST['password'] ?? '';

        if($this->user->login()) {
            $_SESSION['user_id'] = $this->user->id;
            $_SESSION['user_nombre'] = $this->user->nombre;
            $_SESSION['user_email'] = $this->user->email;
            $this->redirect('clientes', 'index');
        } else {
            $this->setMessage('error', 'Credenciales incorrectas');
            $this->redirect('auth', 'showLogin');
        }
    }

    public function showRegister() {
        if(isset($_SESSION['user_id'])) {
            $this->redirect('clientes', 'index');
            return;
        }
        require_once __DIR__ . '/../Views/auth/register.php';
    }

    public function register() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        
        $this->user->nombre = $_POST['nombre'] ?? '';
        $this->user->email = $_POST['email'] ?? '';
        $this->user->password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if(empty($this->user->nombre) || empty($this->user->email) || empty($this->user->password)) {
            $this->setMessage('error', 'Todos los campos son obligatorios');
            $this->redirect('auth', 'showRegister');
            return;
        }

        if($this->user->password !== $password_confirm) {
            $this->setMessage('error', 'Las contraseñas no coinciden');
            $this->redirect('auth', 'showRegister');
            return;
        }

        if($this->user->emailExists()) {
            $this->setMessage('error', 'El email ya está registrado');
            $this->redirect('auth', 'showRegister');
            return;
        }

        if($this->user->register()) {
            $this->setMessage('success', 'Registro exitoso. Por favor inicia sesión');
            $this->redirect('auth', 'showLogin');
        } else {
            $this->setMessage('error', 'Error al registrar usuario');
            $this->redirect('auth', 'showRegister');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('auth', 'showLogin');
    }
}
?>