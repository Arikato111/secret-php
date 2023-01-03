<?php
$db = import('./Database/db');
$usr_id = $_SESSION['usr'];

if(isset($_POST['saveEditProfile'])) {
    $db->query("UPDATE usr SET 
    usr_name = '{$_POST['usr_name']}',
    `usr_address` = '{$_POST['usr_address']}',
    `usr_date` = '{$_POST['usr_date']}',
    `usr_tel`='{$_POST['usr_tel']}'
    WHERE usr_id = $usr_id
    ");
}

$usr_profile = fetch($db->query("SELECT * FROM usr WHERE usr_id = $usr_id"));

?>

<title><?php echo $usr_profile['usr_username']; ?> | แก้ไขโปรไฟล์</title>
<main>
    <div class="row">
        <div class="col-span-3"></div>
        <div class="col-span-6 px-5">
            <div class="text-right">
                <a class="px-3 py-2 bg-gray-500 rounded-lg inline-block mt-3 text-white" href="/<?php echo $usr_profile['usr_username']; ?>">ย้อนกลับ</a>
            </div>
            <h3 class="heading">แก้ไขโปรไฟล์</h3>
            <form class="form-control" enctype="multipart/form-data" method="post">
                <input type="hidden" name="editProfile">

                <input class="input-text" type="text" name="usr_name" value="<?php echo $usr_profile['usr_name'] ?? ""; ?>" placeholder="ชื่อ - สกุล" required>
                <textarea class="input-text" name="usr_address" placeholder="ที่อยู่" required><?php echo $usr_profile['usr_address'] ?? ""; ?></textarea>
                <div class="flex">
                    <label class="input-label" for="">วันเกิด</label>
                    <input class="input-text" type="date" name="usr_date" value="<?php echo $usr_profile['usr_date'] ?? ""; ?>" id="" required>
                </div>
                <input class="input-text" type="email" name="usr_email" value="<?php echo $usr_profile['usr_email'] ?? ""; ?>" placeholder="อีเมล" required>
                <input class="input-text" type="tel" size="10" maxlength="10" name="usr_tel" value="<?php echo $usr_profile['usr_tel'] ?? ""; ?>" placeholder="เบอร์โทร" required>
                <div>
                    <button name="saveEditProfile" class="bg-blue-600 text-white py-2 px-3 rounded-lg w-full">บันทึก</button>
                </div>
                
            </form>
        </div>
        <div class="col-span-3"></div>
    </div>
    <br>
</main>

<!-- <div class="flex">
    <label class="input-label" for="">รูปโปรไฟล์</label>
    <input class="input-text" type="file" accept="image/*" name="usr_img" required>
</div> -->

<!-- <input class="input-text" type="password" name="usr_password" placeholder="รหัสผ่าน" required>
<input class="input-text" type="password" name="usr_password1" placeholder="ยืนยันรหัสผ่าน" required> -->