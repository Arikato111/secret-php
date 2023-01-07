<?php
$db = new Database;
$usr_id = $_SESSION['usr'];

if (isset($_POST['saveEditPassword'])) {
    $old_password = md5($_POST['old_password'] ?? "z");
    $password = md5($_POST['usr_password'] ?? "a");
    $password1 = md5($_POST['usr_password1'] ?? "b");
    if ($password != $password1) {
        getAlert('รหัสผ่านไม่ตรงกัน', 'danger');
    } elseif (!$db->checkMachPassword($usr_id, $old_password)) {
        getAlert('รหัสผ่านเก่าไม่ถูกต้อง', 'danger');
    } else {
        $db->changePassword($usr_id, $password);
        getAlert('เปลี่ยนรหัสผ่านสำเร็จ', 'success');
    }
}
$usr_profile = $db->getUser_ByID($usr_id);

?>

<title><?php echo $usr_profile['usr_username']; ?> | เปลี่ยนรหัสผ่าน</title>
<main>
    <div class="row">
        <div class="col-span-3"></div>
        <div class="col-span-6 px-5">
            <div class="text-right">
                <a class="px-3 py-2 bg-gray-500 rounded-lg inline-block mt-3 text-white" href="/<?php echo $usr_profile['usr_username']; ?>">ย้อนกลับ</a>
            </div>
            <form method="post">
                <div class="form-control">
                    <input class="input-text m-0" type="password" name="old_password" placeholder="รหัสผ่านเก่า" required>
                </div>
                <div class="form-control">
                    <input type="hidden" name="editPassword">
                    <input class="input-text" type="password" name="usr_password" placeholder="รหัสผ่านใหม่" required>
                    <input class="input-text" type="password" name="usr_password1" placeholder="ยืนยันรหัสผ่าน" required>
                    <div>
                        <button name="saveEditPassword" class="bg-blue-600 text-white py-2 px-3 rounded-lg w-full">บันทึก</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-span-3"></div>
    </div>
    <br>
</main>