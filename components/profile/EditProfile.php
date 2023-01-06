<?php
$usr_id = $_SESSION['usr'];
$db = new Database;
if (isset($_POST['saveEditProfile'])) {
    [
        'usr_name' => $name,
        'usr_bio' => $bio,
        'usr_address' => $address,
        'usr_date' => $date,
        'usr_email' => $email,
        'usr_tel' => $tel,
    ] = $_POST;

    $address = htmlspecialchars($address);
    // check size
    if (
        strlen($name) > 200 ||
        strlen($bio) > 200 ||
        strlen($address) > 250 ||
        strlen($email) > 100 ||
        strlen($tel) > 10
    ) {
        getAlert('ข้อมูลไม่ถูกต้อง', 'danger');
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
    } else {
        $db->updateProfileDetail(
            $usr_id,
            $name,
            $bio,
            $address,
            $date,
            $email,
            $tel,
        );
        getAlert('บันทึกข้อมูลสำเร็จ', 'success');
    }
}


$usr_profile = $db->getUser_ByID($usr_id);

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

                <input class="input-text" type="text" pattern="[ก-์a-zA-Z\s]{1,50}" name="usr_name" maxlength="50" value="<?php echo $usr_profile['usr_name'] ?? ""; ?>" placeholder="ชื่อ - สกุล" required>
                <textarea class="input-text" name="usr_bio" maxlength="200" placeholder="คำอธิบายตัวคุณ" rows="5" required><?php echo $usr_profile['usr_bio'] ?? ""; ?></textarea>
                <textarea class="input-text" name="usr_address" maxlength="200" placeholder="ที่อยู่" rows="3" required><?php echo $usr_profile['usr_address'] ?? ""; ?></textarea>
                <div class="flex">
                    <label class="input-label" for="">วันเกิด</label>
                    <input class="input-text" type="date" name="usr_date" value="<?php echo $usr_profile['usr_date'] ?? ""; ?>" id="" required>
                </div>
                <input class="input-text" type="email" maxlength="100" name="usr_email" value="<?php echo $usr_profile['usr_email'] ?? ""; ?>" placeholder="อีเมล" required>
                <input class="input-text" type="tel" maxlength="10" name="usr_tel" value="<?php echo $usr_profile['usr_tel'] ?? ""; ?>" placeholder="เบอร์โทร" required>

                <div>
                    <button name="saveEditProfile" class="bg-blue-600 text-white py-2 px-3 rounded-lg w-full">บันทึก</button>
                </div>

            </form>
        </div>
        <div class="col-span-3"></div>
    </div>
    <br>
</main>