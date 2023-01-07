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
    public function searchUser(string $search)
    {
        $search = "%$search%";
        $query = $this->conn->prepare("SELECT * FROM usr WHERE usr_name LIKE :search OR usr_username LIKE :search ORDER BY usr_id DESC LIMIT 100");
        $query->bindParam(':search', $search, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
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
    public function checkMachPassword(int $id, string $password): bool
    {
        $query = $this->conn->prepare("SELECT * FROM usr WHERE usr_id = :id AND usr_password = :password LIMIT 1");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        return $query->rowCount() > 0;
    }
    public function changePassword(int $id, string $password): bool
    {
        $query = $this->conn->prepare("UPDATE usr SET `usr_password` = :password WHERE usr_id = :id LIMIT 1;");
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deleteAllBoard_ByUsrID(int $id): bool
    {
        $query = $this->conn->prepare("DELETE FROM board WHERE usr_id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deleteAllBoardDetail_ByUsrID(int $id): bool
    {
        $query = $this->conn->prepare("DELETE FROM board_detail WHERE usr_id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deleteAllFollow_ByUsrID(int $id): bool
    {
        $query = $this->conn->prepare("DELETE FROM follow WHERE fol_atk = :id OR fol_def = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
    public  function deleteAllPoll_ByUsrId(int $id): bool
    {
        $query = $this->conn->prepare("DELETE FROM poll WHERE usr_id = :id ;");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
    public  function deleteAllPollLog_ByUsrId(int $id): bool
    {
        $query = $this->conn->prepare("DELETE FROM poll_log WHERE usr_id = :id ;");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deleteUser_ByID(int $id)
    {
        $query = $this->conn->prepare("DELETE FROM usr WHERE usr_id = :id LIMIT 1;");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function isFollow(int $atk, int $def): bool
    {
        $query = $this->conn->prepare("SELECT * FROM follow WHERE fol_atk = :atk AND fol_def = :def LIMIT 1;");
        $query->bindParam(':atk', $atk, PDO::PARAM_INT);
        $query->bindParam(':def', $def, PDO::PARAM_INT);
        $query->execute();
        return $query->rowCount() > 0;
    }
    public function insertFollow(int $atk, int $def): bool
    {
        $date = date('Y-m-d');
        $query = $this->conn->prepare("INSERT INTO 
        `follow`(`fol_id`, `fol_atk`, `fol_def`, `fol_date`) 
        VALUES (NULL, :atk , :def , :date )");
        $query->bindParam(':atk', $atk, PDO::PARAM_INT);
        $query->bindParam(':def', $def, PDO::PARAM_INT);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        return $query->execute();
    }
    public function FollowCount(int $atk = 0, int $def = 0): int
    {
        $query = $this->conn->prepare("SELECT * FROM follow WHERE fol_atk = :atk OR fol_def = :def ;");
        $query->bindParam(':atk', $atk, PDO::PARAM_INT);
        $query->bindParam(':def', $def, PDO::PARAM_INT);
        $query->execute();
        return $query->rowCount();
    }
    public function findFollow(int $atk = 0, int $def = 0): array
    {
        $query = $this->conn->prepare("SELECT * FROM follow WHERE fol_atk = :atk OR fol_def = :def LIMIT 100;");
        $query->bindParam(':atk', $atk, PDO::PARAM_INT);
        $query->bindParam(':def', $def, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteFollow(int $atk, int $def): bool
    {
        $query = $this->conn->prepare("DELETE FROM follow WHERE fol_atk = :atk AND fol_def = :def LIMIT 1;");
        $query->bindParam(':atk', $atk, PDO::PARAM_INT);
        $query->bindParam(':def', $def, PDO::PARAM_INT);
        return $query->execute();
    }
    public function getPost_ByID(int $id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM post WHERE post_id = :id LIMIT 1;");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    public function getAllPost_ByID(int $id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM post WHERE post_id = :id;");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    public function getPost_ByUsrID(int $id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM post WHERE post_usr_id = :id LIMIT 1;");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    public function getAllPost_ByUsrID(int $id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM post WHERE post_usr_id = :id;");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    public function deletePost_ByID(int $id)
    {
        $query = $this->conn->prepare("DELETE FROM post WHERE post_id = :id LIMIT 1;");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deletePostDetail_ByPostID(int $post_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM post_detail WHERE post_id = :post_id ;");
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deletePostDetail_ByUsrID(int $id): bool
    {
        $query = $this->conn->prepare("DELETE FROM post_detail WHERE usr_id = :id ;");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deletePostLike(int $pl_id = 0, int $post_id = 0, int $usr_id = 0): bool
    {
        $query = $this->conn->prepare("DELETE FROM post_like WHERE pl_id = :pl_id OR post_id = :post_id OR usr_id = :usr_id");
        $query->bindParam(':pl_id', $pl_id, PDO::PARAM_INT);
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function postView_UP(int $post_id): void
    {
        $query = $this->conn->prepare("UPDATE post SET `post_view`=`post_view`+1 WHERE post_id = :post_id LIMIT 1;");
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $query->execute();
    }
    public function insertLikePost(int $post_id, int $usr_id): bool
    {
        $query = $this->conn->prepare("INSERT INTO `post_like`
        (`pl_id`, `post_id`, `usr_id`) VALUES 
        (NULL, :post_id , :usr_id ;)");
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function isLikePost(int $post_id, int $usr_id): bool
    {
        $query = $this->conn->prepare("SELECT * FROM post_like WHERE post_id = :post_id AND usr_id = :usr_id LIMIT 1;");
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        $query->execute();
        return $query->rowCount() > 0;
    }
    public function deleteLikePost(int $post_id, int $usr_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM post_like WHERE post_id = :post_id AND usr_id = :usr_id LIMIT 1;");
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function getCate_ByID(int $cat_id): array
    {
        $query = $this->conn->prepare("SELECT * FROM cat WHERE cat_id = :cat_id LIMIT 1;");
        $query->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getPostLikeCount(int $post_id): int
    {
        $query = $this->conn->prepare("SELECT * FROM post_like WHERE post_id = :post_id");
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $query->execute();
        return $query->rowCount();
    }
    public function getPostCommentCount(int $post_id): int
    {
        $query = $this->conn->prepare("SELECT * FROM post_detail WHERE post_id = :post_id ;");
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $query->execute();
        return $query->rowCount();
    }
    public function insetPost(string $post_detail, int $usr_id, int $cat_id, string $img_name): bool
    {
        $date = date('Y-m-d');
        $query = $this->conn->prepare("INSERT INTO `post`
    (`post_id`, `post_detail`, `post_date`, `post_usr_id`, `post_cat_id`, `post_img`, `post_view`) VALUES 
    (NULL, :post_detail ,'$date', :usr_id , :cat_id , :img_name , 0)");
        $query->bindParam(':post_detail', $post_detail, PDO::PARAM_STR);
        $query->bindParam(':post_date', $date, PDO::PARAM_STR);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        $query->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $query->bindParam(':img_name', $img_name, PDO::PARAM_STR);
        return $query->execute();
    }
}
