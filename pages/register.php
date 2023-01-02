<?php
$db = import('./Database/db');

if (isset($_POST['regis'])) {
    [
        'usr_name' => $name,
        'usr_address' => $address,
        'usr_date' => $date,
        'usr_email' => $email,
        'usr_tel' => $tel,
        'usr_username' => $username,
        'usr_password' => $password,
        'usr_password1' => $password1,
    ] = $_POST;
    if (preg_match('/[^a-z0-9]+/', $username) != 0) {
        getAlert('username ไม่ถูกต้อง', 'danger');
    } elseif ($password != $password1) {
        getAlert('รหัสผ่านไม่ตรงกัน', 'danger');
    } elseif ($db->query("SELECT * FROM usr WHERE usr_username = '$username'")->num_rows != 0) {
        getAlert('username นี้ถูกใช้แล้ว', 'danger');
    } else {
        $img_name = md5($_FILES['usr_img']['name'] . rand()) . '.jpg';
        move_uploaded_file($_FILES['usr_img']['tmp_name'], "./public/profile/$img_name");
        $regisDate = date('Y-m-d');
        $password = md5($password);
        $db->query("INSERT INTO `usr`
        (`usr_id`, `usr_name`, `usr_address`, `usr_date`, `usr_email`, `usr_tel`, `usr_username`, `usr_password`, `usr_status`, `usr_view`, `usr_regis_date`, `usr_img`) VALUES 
        (NULL,'$name','$address','$date','$email','$tel','$username','$password','user', 0,'$regisDate', '$img_name')");
        getAlert('สมัครบัญชีสำเร็จ กรุณาเข้าสู่ระบบเพื่อใช้งาน', 'success');
    }
}
?>

<title>สมัครสมาชิก - aden</title>
<main class="frame">
    <form class="form-control" enctype="multipart/form-data" method="post">
        <h3 class="text-4xl text-center p-3">สมัครสมาชิก</h3>
        <input class="input-text" type="text" name="usr_name" value="<?php echo $name ?? ""; ?>" placeholder="ชื่อ - สกุล" required>
        <textarea class="input-text" name="usr_address" placeholder="ที่อยู่" required><?php echo $address ?? ""; ?></textarea>
        <div class="flex">
            <label class="input-label" for="">วันเกิด</label>
            <input class="input-text" type="date" name="usr_date" value="<?php echo $date ?? ""; ?>" id="" required>
        </div>
        <input class="input-text" type="email" name="usr_email" value="<?php echo $email ?? ""; ?>" placeholder="อีเมล" required>
        <input class="input-text" type="tel" size="10" maxlength="10" name="usr_tel" value="<?php echo $tel ?? ""; ?>" placeholder="เบอร์โทร" required>
        <div class="text-red-600 ml-5">username ตัวอักษรภาษาอังกฤษตัวพิมพ์เล็กและตัวเลขเท่านั้น</div>
        <input class="input-text" type="text" size="50" maxlength="50" name="usr_username" value="<?php echo $username ?? ""; ?>" placeholder="username" required>
        <input class="input-text" type="password" name="usr_password" placeholder="รหัสผ่าน" required>
        <input class="input-text" type="password" name="usr_password1" placeholder="ยืนยันรหัสผ่าน" required>

        <div class="flex">
            <label class="input-label" for="">รูปโปรไฟล์</label>
            <input class="input-text" type="file" accept="image/*" name="usr_img" required>
        </div>
        <div>
            <button name="regis" class="bg-blue-600 text-white py-2 px-3 rounded-lg w-full">สมัคร</button>
        </div>
        
        <div class="text-center mt-3">มีบัญชีแล้ว <a class="hover:underline text-blue-700" href="/login">เข้าสู่ระบบ</a></div>    
    </form>
    <br>
</main>