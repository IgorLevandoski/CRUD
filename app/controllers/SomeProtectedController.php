<?php
session_start();

// Verifique se o cabeçalho de autorização foi enviado
if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    $token = str_replace('Bearer ', '', $authHeader);

    // Verifique se o token corresponde ao que está armazenado na sessão
    if ($token === $_SESSION['token']) {
        // Retorne uma resposta JSON se o token for válido
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Access granted']);
    } else {
        // Retorne um erro de autenticação
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['error' => 'Invalid token']);
    }
} else {
    // Se o cabeçalho de autorização não for encontrado
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Authorization header not found']);
}
?>
