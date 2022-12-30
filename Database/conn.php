<?php
import('dotenv')->config();

class Database
{
    private $conn;
    private function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $database = $_ENV['DB_DATABASE'];
        $this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    }

    public function getUser_BYID($id)
    {
        $query = $this->conn->prepare("SELECT * FROM usr WHERE usr_id = :usr_id ");
        $query->bindParam(':usr_id', $id, PDO::PARAM_INT);
        $query->execute();
        $allUsr = $query->fetchAll(PDO::FETCH_ASSOC);
        return $allUsr;
    }
}
