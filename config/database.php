<?php
class Database {
    private $db_path = __DIR__ . '/database.db'; // Caminho para o banco de dados

    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("sqlite:" . $this->db_path);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
