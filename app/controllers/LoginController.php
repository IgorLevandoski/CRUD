<?php
session_start();
header('Content-Type: application/json'); // Adiciona o cabeçalho JSON
require_once '../config/database.php';
require_once '../models/User.php';

class LoginController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function login($username, $password) {
        $this->user->username = $username;
        $this->user->password = $password;
        $user_id = $this->user->login();

        if ($user_id) {
            $token = bin2hex(random_bytes(16));
            $_SESSION['token'] = $token;

            // Retornar o token para ser salvo no localStorage via JavaScript
            echo json_encode(['token' => $token]);
        } else {
            echo json_encode(['error' => 'Login failed']);
        }
    }
}

// Se os dados do POST estiverem presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $loginController = new LoginController();
    $loginController->login($data['username'], $data['password']);
}
?>
