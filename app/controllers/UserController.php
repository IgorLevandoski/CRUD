<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';

class UserController {
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
            $token = bin2hex(random_bytes(16)); // Gera um token
            $_SESSION['token'] = $token; // Armazena o token na sessão
            echo json_encode(['token' => $token]);
        } else {
            echo json_encode(['error' => 'Login failed']);
        }
    }

    public function validateToken() {
        if (isset($_SESSION['token'])) {
            return json_encode(['valid' => true]);
        } else {
            return json_encode(['valid' => false, 'error' => 'Unauthorized']);
        }
    }

    // Exemplo de como proteger rotas de inserção
    public function insert($data) {
        if (!$this->validateToken()) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        // Código para inserir dados...
    }

    // Exemplo de como proteger rotas de deleção
    public function delete($id) {
        if (!$this->validateToken()) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        // Código para deletar dados...
    }

    // Exemplo de como proteger rotas de atualização
    public function update($id, $data) {
        if (!$this->validateToken()) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        // Código para atualizar dados...
    }
}

// Se os dados do POST estiverem presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $userController = new UserController();
    $userController->login($data['username'], $data['password']);
}

// Rota para validar o token
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'validate') {
    $userController = new UserController();
    echo $userController->validateToken();
}
?>
