<?php
$db = new Database;
if (isset($_GET['logout'])) {
    $log = $db->getLog_ByToken($_COOKIE['token1'] ?? '', $_COOKIE['token2'] ?? '');
    if ($log)
        $db->deleteLog_ByID($log['log_id']);
    unset($_COOKIE['token1']);
    unset($_COOKIE['token2']);
    setcookie('token1', null, -1, "/");
    setcookie('token2', null, -1, "/");
    session_unset();
    header('Location: /login');
    die;
}

if (isset($_POST['login'])) {

    $username = $_POST['usr_username'] ?? "";
    $password = md5($_POST['usr_password'] ?? "");
    $usr = $db->getLogin($username, $password);
    if ($usr) {
        $_SESSION['usr'] = $usr['usr_id'];
        $_SESSION['status'] = $usr['usr_status'];
        $db->insertLog($usr['usr_id']);
        header('Location: /');
    } else {
        getAlert('username หรือ รหัสผ่านไม่ถูกต้อง', 'danger');
    }
}
?>

<title>เข้าสู่ระบบ - aden</title>
<?php if (isset($_SESSION['usr'])) :
    return (function () {
?>
        <main class="frame">
            <div class="heading">คุณเข้าสู่ระบบแล้ว</div>
        </main>
    <?php
    })() ?>
<?php endif; ?>
<main class="frame">
    <h3 class="heading">เข้าสู่ระบบ</h3>
    <div class="form-control">
        <form method="POST">
            <input name="usr_username" value="<?php echo $username ?? ""; ?>" class="input-text" placeholder="ชื่อผู้ใช้" maxlength="50" size="50" type="text" required>
            <input name="usr_password" class="input-text" type="password" placeholder="รหัสผ่าน" required>
            <div class="text-right">
                <button name="login" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-2 rounded-md ">เข้าสู่ระบบ</button>
            </div>
        </form>
        <div class="text-center">
            <div class="form-control inline-block w-max border hover:bg-slate-100/50">
                <button id="getLogin" class="flex justify-center items-center"><img class="w-7 mx-2" src="/public/default/google-logo.png" alt="google logo">เข้าสู่ระบบด้วย google</button>
            </div>
        </div>
        <div class="text-center">
            ยังไม่มีบัญชี? <a class="text-blue-700 hover:underline" href="/register">สมัครสมาชิก</a>
        </div>
    </div>
</main>

<script type="module" src="/public/google-login.js"></script>