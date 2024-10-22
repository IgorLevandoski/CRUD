<?php
require_once '../config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    $sql = "
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        password TEXT NOT NULL
    );
    ";
    $db->exec($sql);

    echo "Tabela criada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar tabela: " . $e->getMessage();
}

// Inserir um usuário com senha criptografada
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $db->prepare($sql);

$username = 'admin';
$password = password_hash('admin123', PASSWORD_BCRYPT); // Hash da senha

$stmt->execute([$username, $password]);

echo "Usuário inserido com sucesso!";
?>
