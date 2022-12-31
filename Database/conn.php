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
    public function getUser_BYUSERNAME($username) {
        $query = $this->conn->prepare("SELECT * FROM usr WHERE usr_username = :username");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        $allUsr = $query->fetchAll(PDO::FETCH_ASSOC);
        return $allUsr;
    }

    public function addUser($name, $address, $date, $email, $tel, $username, $password) {
        $regisDate=date('Y-m-d');
        $insertUsr = $this->conn->prepare("INSERT INTO `usr`
        ( `usr_name`, `usr_address`, `usr_date`, `usr_email`, `usr_tel`, `usr_username`, `usr_password`, `usr_status`, `usr_view`, `usr_regis_date`) VALUES 
        ( :name , :address , :date , :email  , :tel , :username , :password , 'user' , 0 , :regis_date )");

        $insertUsr->bindParam(':name', $name, PDO::PARAM_STR);
        $insertUsr->bindParam(':address', $address, PDO::PARAM_STR);
        $insertUsr->bindParam(':date', $date, PDO::PARAM_STR);
        $insertUsr->bindParam(':email', $email, PDO::PARAM_STR);
        $insertUsr->bindParam(':tel', $tel, PDO::PARAM_STR);
        $insertUsr->bindParam(':username', $username, PDO::PARAM_STR);
        $insertUsr->bindParam(':password', $password, PDO::PARAM_STR);
        $insertUsr->bindParam(':regis_date', $regisDate, PDO::PARAM_STR);

        $insertUsr->execute();
    }   
}
