<?php if (isset($_SESSION['usr'])) :
    return (function () {
?>
        <main class="frame">
            <div class="heading">คุณเข้าสู่ระบบแล้ว</div>
        </main>
    <?php
    })(); ?>
<?php endif;

if (isset($_POST['regis'])) {
    [
        'usr_name' => $name,
        'usr_bio' => $bio,
        'usr_address' => $address,
        'usr_date' => $date,
        'usr_email' => $email,
        'usr_tel' => $tel,
        'usr_username' => $username,
        'usr_password' => $password,
        'usr_password1' => $password1,
    ] = $_POST;
    $db = new Database;

    $address = htmlspecialchars($address);
    $img_type = mime_content_type($_FILES['usr_img']['tmp_name']);
    // check size
    if (
        strlen($name) > 200 ||
        strlen($bio) > 200 ||
        strlen($address) > 250 ||
        strlen($email) > 100 ||
        strlen($tel) > 10 ||
        strlen($username) > 50 ||
        strlen($password) > 50 ||
        strlen($password1) > 50 ||
        !isset($_FILES['usr_img'])
    ) {
        getAlert('ข้อมูลไม่ถูกต้อง', 'danger');
    } elseif ($_FILES['usr_img']['size'] > 2048000) {
        getAlert('รูปต้องมีขนาดไม่เกิน 2mb', 'danger');
    } elseif (
        $img_type != 'image/jpeg' && $img_type != 'image/png'
    ) {
        getAlert('รูปภาพต้องเป็น jpeg, jpg, png เท่านั้น', 'danger');
    } elseif (
        preg_match('/[^a-zA-Zก-ฮ\s]/', $name)
    ) {
        getAlert('ชื่อ - สกุล ต้องเป็นภาษาไทยหรืออังกฤษเท่านั้น', 'danger');
    } elseif (preg_match('/[^a-zA-Zก-ฮ0-9\s]/', $bio)) {
        getAlert('คำอธิบาย ต้องเป็นภาษาไทย อังกฤษ หรือตัวเลขเท่านั้น', 'danger');
    } elseif (preg_match('/[^\d-]/', $date)) {
        getAlert('วันเกิด ไม่ถูกต้อง', 'danger');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        getAlert('อีเมล ไม่ถูกต้อง', 'danger');
    } elseif (preg_match('/\D/', $tel)) {
        getAlert('เบอร์โทรต้องเป็นตัวเลขเท่านั้น', 'danger');
    } elseif (preg_match('/\W/', $username)) {
        getAlert('ชื่อผู้ใช้ต้องเป็นภาษาอังกฤษและตัวเลขเท่านั้น', 'danger');
    } elseif ($password != $password1) {
        getAlert('รหัสผ่านไม่ตรงกัน', 'danger');
    } elseif ($db->getUser_ByUsername($username)) {
        getAlert('username นี้ถูกใช้แล้ว', 'danger');
    } else {
        $img_name = md5($_FILES['usr_img']['name'] . rand()) . '.jpg';
        move_uploaded_file($_FILES['usr_img']['tmp_name'], "./public/profile/$img_name");
        $regisDate = date('Y-m-d');
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
        getAlert('สมัครบัญชีสำเร็จ กรุณาเข้าสู่ระบบเพื่อใช้งาน', 'success');
    }
}
?>

<title>สมัครสมาชิก - aden</title>
<main class="frame">
    <h3 class="heading">สมัครสมาชิก</h3>
    <form class="form-control" enctype="multipart/form-data" method="post">
        <input class="input-text" type="text" pattern="[ก-์a-zA-Z\s]{1,50}" name="usr_name" maxlength="50" value="<?php echo $name ?? ""; ?>" placeholder="ชื่อ - สกุล" required>
        <textarea class="input-text" name="usr_bio" maxlength="200" placeholder="คำอธิบายตัวคุณ" required><?php echo $address ?? ""; ?></textarea>
        <textarea class="input-text" name="usr_address" maxlength="200" placeholder="ที่อยู่" required><?php echo $address ?? ""; ?></textarea>
        <div class="flex">
            <label class="input-label" for="">วันเกิด</label>
            <input class="input-text" type="date" name="usr_date" value="<?php echo $date ?? ""; ?>" id="" required>
        </div>
        <input class="input-text" type="email" maxlength="100" name="usr_email" value="<?php echo $email ?? ""; ?>" placeholder="อีเมล" required>
        <input class="input-text" type="tel" maxlength="10" name="usr_tel" value="<?php echo $tel ?? ""; ?>" placeholder="เบอร์โทร" required>
        <div class="text-red-600 ml-5">*username ต้องเป็นตัวอักษรภาษาอังกฤษตัวพิมพ์เล็กและตัวเลขเท่านั้น</div>
        <input class="input-text" type="text" maxlength="50" name="usr_username" value="<?php echo $username ?? ""; ?>" placeholder="username" required>
        <input class="input-text" type="password" maxlength="50" name="usr_password" placeholder="รหัสผ่าน" required>
        <input class="input-text" type="password" maxlength="50" name="usr_password1" placeholder="ยืนยันรหัสผ่าน" required>

        <div class="flex">
            <label class="input-label" for="">รูปโปรไฟล์</label>
            <input class="input-text" type="file" accept="image/jpeg, image/png" name="usr_img" required>
        </div>
        <div>
            <button name="regis" class="bg-blue-600 text-white py-2 px-3 rounded-lg w-full">สมัคร</button>
        </div>

        <div class="text-center mt-3">มีบัญชีแล้ว <a class="hover:underline text-blue-700" href="/login">เข้าสู่ระบบ</a></div>
    </form>
    <br>
</main>