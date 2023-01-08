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
    public function getUser_All(bool $hide_private = false, bool $desc = false, int $limit = 0): array | bool
    {
        $limitor = $limit != 0 ? "LIMIT $limit" : '';
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
            $query = $this->conn->prepare("SELECT $mode FROM usr ORDER BY usr_id DESC $limitor");
        } else {
            $query = $this->conn->prepare("SELECT $mode FROM usr $limitor");
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
    public function findFollow(int $atk = 0, int $def = 0): array | bool
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
    public function getAllPost(int $limit = 0, bool $desc = false, int $cat_id = 0): array | bool
    {
        $sort = $desc ? "ORDER BY post_id DESC " : "";
        $cat = $cat_id == 0 ? "" : " WHERE post_cat_id = $cat_id ";
        if ($limit > 0) {
            $query = $this->conn->prepare("SELECT * FROM post $cat $sort LIMIT $limit ;");
        } else {
            $query = $this->conn->prepare("SELECT * FROM post $cat $sort;");
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
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
        return $query->fetchAll(PDO::FETCH_ASSOC);
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
        (NULL, :post_id , :usr_id )");
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function isLikePost(int $post_id, int $usr_id): bool
    {
        $query = $this->conn->prepare("SELECT * FROM post_like 
        WHERE post_id = :post_id AND usr_id = :usr_id LIMIT 1;");
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
    public function getCate_ByID(int $cat_id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM cat WHERE cat_id = :cat_id LIMIT 1;");
        $query->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getCate_ByPath(string $cat_path): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM cat WHERE cat_path = :cat_path LIMIT 1;");
        $query->bindParam(':cat_path', $cat_path, PDO::PARAM_STR);
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
    public function insertPost(string $post_detail, int $usr_id, int $cat_id, string $img_name): bool
    {
        $date = date('Y-m-d');
        $query = $this->conn->prepare("INSERT INTO `post`
    (`post_id`, `post_detail`, `post_date`, `post_usr_id`, `post_cat_id`, `post_img`, `post_view`) VALUES 
    (NULL, :post_detail ,:post_date, :usr_id , :cat_id , :img_name , 0)");
        $query->bindParam(':post_detail', $post_detail, PDO::PARAM_STR);
        $query->bindParam(':post_date', $date, PDO::PARAM_STR);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        $query->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $query->bindParam(':img_name', $img_name, PDO::PARAM_STR);
        return $query->execute();
    }
    public function getAllCategory(bool $desc = false): array | bool
    {
        if ($desc) {
            $query = $this->conn->prepare("SELECT * FROM cat ORDER BY cat_id DESC");
        } else {
            $query = $this->conn->prepare("SELECT * FROM cat");
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function myFeed(int $usr_id): array
    {
        $feedPost = [];

        $your_follow = $this->findFollow(atk: $usr_id);
        $post_size = sizeof($your_follow) == 0 ? 0 : 50 / sizeof($your_follow);
        foreach ($your_follow as $fol) {
            $getPost = $this->getAllPost_ByUsrID($fol['fol_def']);
            if (!$getPost) continue;
            $post_limit = $post_size;
            foreach ($getPost as $p) {
                if ($post_limit == 0) {
                    break;
                }
                array_push($feedPost, $p);
                $post_limit--;
            }
        }
        array_multisort(array_column($feedPost, 'post_id'), SORT_DESC, $feedPost);
        return $feedPost;
    }
    public function getPostComment_ByID(int $pd_id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM post_detail WHERE pd_id = :pd_id LIMIT 1");
        $query->bindParam(':pd_id', $pd_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllPostComment_ByPostID(int $post_id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM post_detail WHERE post_id = :post_id ORDER BY pd_id DESC LIMIT 1000");
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deletePostComment__ByID(int $pd_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM post_detail WHERE pd_id = :pd_id LIMIT 1 ;");
        $query->bindParam(':pd_id', $pd_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function insertPostComment(int $post_id, string $pd_name, int $usr_id): bool
    {
        $date = date('Y-m-d');
        $query = $this->conn->prepare("INSERT INTO `post_detail`
        (`pd_id`, `post_id`, `pd_name`, `pd_date`, `usr_id`) VALUES
        (NULL, :post_id , :pd_name , :date , :usr_id )");
        $query->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $query->bindParam(':pd_name', $pd_name, PDO::PARAM_STR);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function getBoard_ByID(int $b_id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM board WHERE b_id = :b_id LIMIT 1 ;");
        $query->bindParam(':b_id', $b_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllBoard(int $limit = 0, bool $desc = false, int $cat = 0): array | bool
    {
        $limitor = $limit != 0 ? "LIMIT $limit" : "";
        $sort = $desc ? " ORDER BY b_id DESC " : "";
        $cate = $cat != 0 ? " WHERE cat_id = $cat " : "";
        $query = $this->conn->prepare("SELECT * FROM board $cate $sort $limitor ;");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllBoard_ByUsrID(int $usr_id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM board WHERE usr_id = :usr_id ORDER BY b_id DESC LIMIT 1000");
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getBoardDetailCount_ByBID(int $b_id): int
    {
        $query = $this->conn->prepare("SELECT * FROM board_detail WHERE b_id = :b_id ;");
        $query->bindParam(':b_id', $b_id, PDO::PARAM_INT);
        $query->execute();
        return $query->rowCount();
    }
    public function deleteBoard_ByID(int $b_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM board WHERE b_id = :b_id LIMIT 1 ;");
        $query->bindParam(':b_id', $b_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function insertBoard(string $b_name, int $usr_id, int $cat_id): bool
    {
        $date = date('Y-m-d');
        $query = $this->conn->prepare("INSERT INTO `board`
        (`b_id`, `b_name`, `b_date`, `usr_id`, `b_view`, `cat_id`) VALUES 
        (NULL, :b_name , :date , :usr_id , 0, :cat_id )");
        $query->bindParam(':b_name', $b_name, PDO::PARAM_STR);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        $query->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deleteAllBoardDetail_ByBID($b_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM board_detail WHERE b_id = :b_id ");
        $query->bindParam(':b_id', $b_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function Board_ViewUp(int $b_id): bool
    {
        $query = $this->conn->prepare("UPDATE board SET `b_view`=`b_view`+1 WHERE b_id = :b_id LIMIT 1 ");
        $query->bindParam(':b_id', $b_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public  function insertBoardDetail(int $b_id, string $bd_name, int $usr_id): bool
    {
        $date = date('Y-m-d');
        $query = $this->conn->prepare("INSERT INTO `board_detail`
        (`bd_id`, `b_id`, `bd_name`, `bd_date`, `usr_id`) VALUES 
        (NULL, :b_id , :bd_name , :date , :usr_id )");
        $query->bindParam(':b_id', $b_id, PDO::PARAM_INT);
        $query->bindParam(':bd_name', $bd_name, PDO::PARAM_STR);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deleteBoardDetail_ByID(int $bd_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM board_detail WHERE bd_id = :bd_id LIMIT 1;");
        $query->bindParam(':bd_id', $bd_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function getBoardDetail_ByID(int $bd_id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM board_detail WHERE bd_id = :bd_id LIMIT 1;");
        $query->bindParam(':bd_id', $bd_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllBoardDetail(int $limit = 0, bool $desc = false): array | bool
    {
        $limitor = $limit != 0 ? "LIMIT $limit" : "";
        $sort = $desc ? "ORDER BY bd_id DESC" : "";
        $query = $this->conn->prepare("SELECT * FROM board_detail $sort $limitor ;");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllBoardDetail_ByBID(int $b_id, bool $desc = false, int $limit = 0): array | bool
    {
        $sort = $desc ? 'ORDER BY bd_id DESC' : '';
        $limitor = $limit != 0 ? "LIMIT $limit" : '';
        $query = $this->conn->prepare("SELECT *FROM board_detail WHERE b_id = :b_id $sort $limitor ;");
        $query->bindParam(':b_id', $b_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllPoll(int $limit = 0, bool $desc = false): array  | bool
    {
        $limitor = $limit != 0 ? "LIMIT $limit" : "";
        $sort = $desc ? 'ORDER BY poll_id DESC' : "";
        $query = $this->conn->prepare("SELECT * FROM poll $sort  $limitor");
        $query->execute();
        return $query->fetchAll();
    }
    public function getPoll_ByID(int $p_id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM poll WHERE poll_id = :p_id ;");
        $query->bindParam(':p_id', $p_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function searchPoll(string $search, int $limit = 0, bool $desc = false): array | bool
    {
        $search = "%$search%";
        $limitor = $limit != 0 ? "LIMIT $limit" : '';
        $sort = $desc ? "ORDER BY poll_id DESC" : '';

        $query = $this->conn->prepare("SELECT * FROM poll WHERE poll_name LIKE :search $sort $limitor ;");
        $query->bindParam(':search', $search, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllPollDetail_ByPID(int $p_id, int $limit = 0, $desc = false): array  | bool
    {
        $limitor = $limit != 0 ? "LIMIT $limit" : '';
        $sort = $desc ? "ORDER BY pd_id DESC" : '';
        $query = $this->conn->prepare("SELECT * FROM poll_detail WHERE poll_id = :p_id $sort $limitor ;");
        $query->bindParam(':p_id', $p_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPollDetail_ByID(int $pd_id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM poll_detail WHERE pd_id = :pd_id LIMIT 1;");
        $query->bindParam(':pd_id', $pd_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function isVoted(int $poll_id, $usr_id)
    {
        $query = $this->conn->prepare("SELECT * FROM poll_log WHERE
        `poll_id` = :p_id AND `usr_id` = :usr_id LIMIT 1");
        $query->bindParam(':p_id', $poll_id, PDO::PARAM_INT);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        $query->execute();
        return $query->rowCount() > 0;
    }
    public function insertVote(int $poll_id, int $usr_id): bool
    {
        $query = $this->conn->prepare("INSERT INTO `poll_log`
        (`pl_id`, `poll_id`, `usr_id`) VALUES 
        (NULL, :poll_id, :usr_id );");
        $query->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function PollDetailCount_Up(int $pd_id): bool
    {
        $query = $this->conn->prepare("UPDATE poll_detail SET `pd_count`=`pd_count`+1 WHERE pd_id = :pd_id LIMIT 1");
        $query->bindParam(':pd_id', $pd_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function PollView_Up(int $p_id): bool
    {
        $query = $this->conn->prepare("UPDATE poll SET `poll_view`=`poll_view`+1 WHERE poll_id = :poll_id LIMIT 1;");
        $query->bindParam(':poll_id', $p_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function updateStatusUser(int $usr_id, string  $status): bool
    {
        $query = $this->conn->prepare("UPDATE usr SET `usr_status`= :usr_status WHERE usr_id = :usr_id LIMIT  1");
        $query->bindParam(':usr_status', $status, PDO::PARAM_STR);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function reporBoardDetail_Count(): int
    {
        $query = $this->conn->prepare("SELECT * FROM board_detail");
        $query->execute();
        return $query->rowCount();
    }
    public function reportUser_Count(): int
    {
        $query = $this->conn->prepare("SELECT * FROM usr");
        $query->execute();
        return $query->rowCount();
    }
    public function reportUserRegisToday(): int
    {
        $date = date('Y-m-d');
        $query = $this->conn->prepare("SELECT * FROM usr WHERE usr_regis_date = '$date'");
        $query->execute();
        return $query->rowCount();
    }

    public function insertPoll(string $poll_name, int $usr_id): bool
    {
        $date = date('Y-m-d');
        $query = $this->conn->prepare("INSERT INTO `poll`
        (`poll_id`, `poll_name`, `poll_date`, `usr_id`, `poll_view`) VALUES 
        (NULL, :poll_name , :date , :usr_id , 0)");
        $query->bindParam(':poll_name', $poll_name, PDO::PARAM_STR);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function updatePoll(int $poll_id, string $poll_name): bool
    {
        $query = $this->conn->prepare("UPDATE poll SET `poll_name`= :poll_name WHERE poll_id = :poll_id LIMIT 1");
        $query->bindParam(':poll_name', $poll_name, PDO::PARAM_STR);
        $query->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function insertPollDetail(int $poll_id, string $pd_name): bool
    {
        $query = $this->conn->prepare("INSERT INTO `poll_detail`
        (`pd_id`, `poll_id`, `pd_name`, `pd_count`) VALUES 
        (NULL, :poll_id , :pd_name , 0)");
        $query->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
        $query->bindParam(':pd_name', $pd_name, PDO::PARAM_STR);
        return $query->execute();
    }
    public function deletePollDetail_ByID(int $pd_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM poll_detail WHERE pd_id = :pd_id LIMIT 1");
        $query->bindParam(':pd_id', $pd_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function updatePollDetail(int $pd_id, string $pd_name): bool
    {
        $query = $this->conn->prepare("UPDATE poll_detail SET pd_name = :pd_name WHERE pd_id = :pd_id LIMIT 1");
        $query->bindParam(':pd_name', $pd_name, PDO::PARAM_STR);
        $query->bindParam(':pd_id', $pd_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deletePoll_ByID(int $poll_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM poll WHERE poll_id = :poll_id LIMIT 1");
        $query->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function deleteAllPollDetail_ByPID(int $poll_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM poll_detail WHERE poll_id = :poll_id ");
        $query->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function Poll_TopVote(int $poll_id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM poll_detail WHERE poll_id = :poll_id ORDER BY pd_count LIMIT 1");
        $query->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function deleteAllPollLog_ByPID(int $poll_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM poll_log WHERE poll_id = :poll_id");
        $query->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function insertCategory(string $cat_name, string $cat_path, string $cat_img): bool
    {
        $query = $this->conn->prepare("INSERT INTO
         `cat`(`cat_id`, `cat_name`, `cat_path`, `cat_img`) 
        VALUES (NULL, :cat_name , :cat_path , :cat_img)");
        $query->bindParam(':cat_name', $cat_name, PDO::PARAM_STR);
        $query->bindParam(':cat_path', $cat_path, PDO::PARAM_STR);
        $query->bindParam(':cat_img', $cat_img, PDO::PARAM_STR);
        return $query->execute();
    }
    public function Cate_check(string $cat_name, string $cat_path, int $not_id = 0): bool
    {
        if ($not_id > 0) {
            $query = $this->conn->prepare("SELECT * FROM cat WHERE ( cat_name = :cat_name OR cat_path = :cat_path ) AND cat_id != :cat_id LIMIT 1");
            $query->bindParam(':cat_id', $not_id, PDO::PARAM_INT);
        } else {
            $query = $this->conn->prepare("SELECT * FROM cat WHERE cat_name = :cat_name OR cat_path = :cat_path LIMIT 1");
        }
        $query->bindParam(':cat_name', $cat_name, PDO::PARAM_STR);
        $query->bindParam(':cat_path', $cat_path, PDO::PARAM_STR);
        $query->execute();
        return $query->rowCount() > 0;
    }
    public function deleteCate_ByID(int $cat_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM cat WHERE cat_id = :cat_id LIMIT 1;");
        $query->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function updateCate(int $cat_id, string $cat_name, string $cat_path): bool
    {
        $query = $this->conn->prepare("UPDATE cat SET `cat_name`= :cat_name ,`cat_path` = :cat_path WHERE cat_id = :cat_id LIMIT 1;");
        $query->bindParam(':cat_name', $cat_name, PDO::PARAM_STR);
        $query->bindParam(':cat_path', $cat_path, PDO::PARAM_STR);
        $query->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function updateCate_Img(int $cat_id, string $cat_img): bool
    {
        $query = $this->conn->prepare("UPDATE cat SET `cat_img` = :cat_img WHERE cat_id = :cat_id LIMIT 1 ;");
        $query->bindParam(':cat_img', $cat_img, PDO::PARAM_STR);
        $query->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function insertLog(int $usr_id): bool
    {
        $token1 = sha1($usr_id . time() . rand());
        $token2 = sha1($usr_id . time() . rand());
        $date = date('Y-m-d');
        $query  = $this->conn->prepare("INSERT INTO `login_log`
        (`log_id`, `token1`, `token2`, `usr_id`, `log_date`) VALUES 
        (NULL , :token1 , :token2 , :usr_id , :date )");
        $query->bindParam(':token1', $token1, PDO::PARAM_STR);
        $query->bindParam(':token2', $token2, PDO::PARAM_STR);
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $result = $query->execute();
        if ($result) {
            setcookie('token1', $token1, time() + (86400 * 30), "/");
            setcookie('token2', $token2, time() + (86400 * 30), "/");
            return true;
        } else {
            return false;
        }
    }
    public function getAllLog(int $limit = 0, bool $desc = false): array | bool
    {
        $limitor = $limit != 0 ? "LIMIT $limit" : '';
        $sort = $desc ? "ORDER BY log_id DESC" : '';
        $query = $this->conn->prepare("SELECT * FROM login_log $sort $limitor ;");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getLog_ByUsrID(int $usr_id): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM login_log WHERE usr_id = :usr_id ORDER BY log_id DESC");
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getLog_ByToken(string $token1, string $token2): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM login_log WHERE token1 = :token1 AND token2 = :token2 LIMIT 1 ;");
        $query->bindParam(':token1', $token1, PDO::PARAM_STR);
        $query->bindParam(':token2', $token2, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getLog_ByTokenOne(string $token1): array | bool
    {
        $query = $this->conn->prepare("SELECT * FROM login_log WHERE token1 = :token1  LIMIT 1 ;");
        $query->bindParam(':token1', $token1, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function deleteLog_ByID($log_id): bool
    {
        $query = $this->conn->prepare("DELETE FROM login_log WHERE log_id = :log_id LIMIT 1;");
        $query->bindParam(':log_id', $log_id, PDO::PARAM_INT);
        return $query->execute();
    }
    public function getAllLog_ByUsrID(int $usr_id, int $limit = 0, $desc = false): array | bool
    {
        $limitor = $limit != 0 ? "LIMIT $limit" : '';
        $sort = $desc ? "ORDER BY log_id DESC" : '';
        $query = $this->conn->prepare("SELECT * FROM login_log WHERE usr_id = :usr_id $sort $limitor ;");
        $query->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
