<?php
$db = import('./Database/db');
$usr_id = $_SESSION['usr'];

if(isset($_POST['saveEditPassword'])) {
    if($_POST['usr_password'] != $_POST['usr_password1']) {
        getAlert('รหัสผ่านไม่ตรงกัน', 'danger');
    } else {
        $db->query("UPDATE usr SET usr_password = MD5('{$_POST['usr_password']}') WHERE usr_id = $usr_id");
        getAlert('เปลี่ยนรหัสผ่านสำเร็จ', 'success');
    }
}
$usr_profile = fetch($db->query("SELECT * FROM usr WHERE usr_id = $usr_id"));

?>

<title><?php echo $usr_profile['usr_username']; ?> | เปลี่ยนรหัสผ่าน</title>
<main>
    <div class="row">
        <div class="col-span-3"></div>
        <div class="col-span-6 px-5">
            <div class="text-right">
                <a class="px-3 py-2 bg-gray-500 rounded-lg inline-block mt-3 text-white" href="/<?php echo $usr_profile['usr_username']; ?>">ย้อนกลับ</a>
            </div>
            <form class="form-control" enctype="multipart/form-data" method="post">
                <input type="hidden" name="editPassword">
                <input class="input-text" type="password" name="usr_password" placeholder="รหัสผ่าน" required>
                <input class="input-text" type="password" name="usr_password1" placeholder="ยืนยันรหัสผ่าน" required>
                <div>
                    <button name="saveEditPassword" class="bg-blue-600 text-white py-2 px-3 rounded-lg w-full">บันทึก</button>
                </div>

            </form>
        </div>
        <div class="col-span-3"></div>
    </div>
    <br>
</main>