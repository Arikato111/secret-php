<?php
import('dotenv')->config();

class Database
{
    private $conn;
    function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $database = $_ENV['DB_DATABASE'];

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        } catch (PDOException $err) {
            echo 'Failed to connect database ' . $err;
        }
    }
    public function getUser_All(bool $hide_private = false, bool $desc = false): array | bool
    {
        if ($hide_private) {
            $mode = '
            `usr_name`, 
            `usr_address`, `usr_date`,
            `usr_email`, `usr_tel`,
            `usr_username`, `usr_view`,
            `usr_regis_date`, `usr_img` ';
        } else {
            $mode = '*';
        }
        if ($desc) {
            $query = $this->conn->prepare("SELECT $mode FROM usr ORDER BY usr_id DESC");
        } else {
            $query = $this->conn->prepare("SELECT $mode FROM usr WHERE 0");
        }
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    public function getUser_ByID(int $id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM usr WHERE usr_id = :id LIMIT 1;");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch();
        } else {
            return false;
        }
    }
    public function getUser_ByUsername(string $username): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM usr WHERE usr_username = :username LIMIT 1;");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch();
        } else {
            return false;
        }
    }
    public function insetUser(
        string $name,
        string $bio,
        string $address,
        string $date,
        string $email,
        string $tel,
        string $username,
        string $password,
        string $img_name
    ): bool {
        $regisDate = date('Y-m-d');
        $query = $this->conn->prepare("INSERT INTO `usr`
        (`usr_id`, `usr_name`, `usr_bio`, `usr_address`, `usr_date`, `usr_email`, `usr_tel`, `usr_username`, `usr_password`, `usr_status`, `usr_view`, `usr_regis_date`, `usr_img`) VALUES 
        (NULL, :name, :bio , :address , :date , :email , :tel , :username , :password , 'user' , 0,'$regisDate', :img_name );");

        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':bio', $bio, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':tel', $tel, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':img_name', $img_name, PDO::PARAM_STR);
        return $query->execute();
    }
    public function getLogin(string $username, string $password): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM usr WHERE usr_username = :username AND usr_password = :password LIMIT 1;");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    public function updateImgProfile(int $id, string $img): bool
    {
        $query = $this->conn->prepare("UPDATE usr SET usr_img = :img WHERE usr_id = :id ");
        $query->bindParam(':img', $img, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function updateProfileDetail(
        int $id,
        string $name,
        string $bio,
        string $address,
        string $date,
        string $email,
        string $tel
    ) {
        $query = $this->conn->prepare("UPDATE usr SET
        `usr_name` = :name ,
        `usr_bio` = :bio ,
        `usr_address` = :address ,
        `usr_date` = :date ,
        `usr_email` = :email ,
        `usr_tel` = :tel 
        WHERE usr_id = :id LIMIT 1");
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':bio', $bio, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':tel', $tel, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
}
