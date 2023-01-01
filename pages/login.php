<?php
$db = import('./Database/db');

if(isset($_GET['logout'])) {
    session_unset();
    header('Location: /login');die;
}

if(isset($_POST['login'])) {
    $username = $_POST['usr_username'];
    $password = md5($_POST['usr_password']);
    $usr = fetch($db->query("SELECT * FROM usr WHERE 
    usr_username = '$username' AND 
    usr_password = '$password'"));
    if(!$usr) {
        getAlert('username หรือ รหัสผ่านไม่ถูกต้อง', 'danger');
    } else {
        $_SESSION['usr'] = $usr['usr_id'];
        $_SESSION['status'] = $usr['usr_status'];
        header('Location: /');die;
    }
}
?>

<title>เข้าสู่ระบบ - aden</title>
<main class="frame">
    <form class="bg-white rounded-md drop-shadow-md p-5 my-5 shadow-zinc-300 fill-none" method="post">
        <h3 class="text-center text-4xl  p-3">เข้าสู่ระบบ</h3>    
        <input name="usr_username" value="<?php echo $username ?? ""; ?>" class="input-text" placeholder="ชื่อผู้ใช้" maxlength="50" size="50" type="text" required>
        <input name="usr_password" class="input-text" type="password" placeholder="รหัสผ่าน" required>
        <div class="text-right">
            <button name="login" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-2 rounded-md ">เข้าสู่ระบบ</button>
        </div>
        <div class="text-center">
        ยังไม่มีบัญชี? <a class="text-blue-700 hover:underline" href="/register">สมัครสมาชิก</a>
        </div>
    </form>
</main>