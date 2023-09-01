<?php
$Notfound = import('./components/api/Notfound');
$db = new Database;

Wexpress::post(
    '*',
    function () use ($db) {
        $name = $_POST['name'] ?? "";
        $bio = $_POST['bio'] ?? "";
        $address = $_POST['address'] ?? "";
        $date = $_POST['date'] ?? "";
        $email = $_POST['email'] ?? "";
        $tel = $_POST['tel'] ?? "";
        $username = $_POST['username'] ?? "";
        $password = $_POST['password'] ?? "";

        $db = new Database;

        $address = htmlspecialchars($address);
        if ($_FILES['usr_img'] ?? false) {
            $img_type = mime_content_type($_FILES['usr_img']['tmp_name']);
        }
        // check size
        if (
            mb_strlen($name) > 200 ||
            mb_strlen($name) < 1 ||
            mb_strlen($bio) > 200 ||
            mb_strlen($bio) < 1 ||
            mb_strlen($address) > 250 ||
            mb_strlen($address) < 1  ||
            mb_strlen($email) > 100 ||
            mb_strlen($email) == 0 ||
            mb_strlen($tel) != 10 ||
            mb_strlen($username) > 50 ||
            mb_strlen($username) == 0 ||
            mb_strlen($password) > 50 ||
            !isset($_FILES['usr_img']) ||
            $_FILES['usr_img']['size'] > 2048000 ||
            $img_type != 'image/jpeg' && $img_type != 'image/png' ||
            preg_match('/[^a-zA-Zก-ฮเ\s]/', $name) ||
            preg_match('/[^a-zA-Zก-ฮเ0-9.\s]/', $bio) ||
            preg_match('/[^\d-]/', $date) ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            preg_match('/\D/', $tel) ||
            preg_match('/\W/', $username) ||
            $username == 'admin' ||
            $username == 'home' ||
            $username == 'explore' ||
            $username == 'poll' ||
            $username == 'board' ||
            $username == 'people' ||
            $username == 'create-post' ||
            $username == 'about' ||
            $username == 'contact' ||
            $username == 'help' ||
            $username == 'privacy' ||
            $username == 'question' ||
            $username == 'business' ||
            $username == 'ads' ||
            $username == 'phpmyadmin' ||
            $username == 'php' ||
            $username == 'api' ||
            $db->getUser_ByUsername($username)
        ) {
            Res::json(['status' => 0, 'message' => 'bad request']);
            die;
        }
        $img_name = md5($_FILES['usr_img']['name'] . rand()) . '.jpg';
        move_uploaded_file($_FILES['usr_img']['tmp_name'], "./public/profile/$img_name");
        $password = md5($password);
        $db->insetUser(
            $name,
            $bio,
            $address,
            $date,
            $email,
            $tel,
            $username,
            $password,
            $img_name
        );
        Res::json(['status' => 0, 'message' => 'login success']);
    }
);

Wexpress::all('*', $Notfound);
