<?php
$db = import('./Database/db');
$usr_id = $_SESSION['usr'];

if(isset($_POST['saveEditImg'])) {
    $usr_profile = fetch($db->query("SELECT * FROM usr WHERE usr_id = $usr_id"));

    $img_name = md5($_FILES['usr_img']['name'] . rand()) . '.jpg';
    move_uploaded_file($_FILES['usr_img']['tmp_name'], './public/profile/' . $img_name);
    unlink('./public/profile/' . $usr_profile['usr_img']);
    $db->query("UPDATE usr SET usr_img = '$img_name' WHERE usr_id = $usr_id");
    header("Refresh:0");die;
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
                <input type="hidden" name="editImg">
                <div>
                    <div class="p-3 text-center"><img class="w-24 h-24 object-cover rounded-full inline-block" src="/public/profile/<?php echo $usr_profile['usr_img']; ?>" alt=""></div>
                </div>

                <div class="flex">
                    <label class="input-label" for="">รูปโปรไฟล์</label>
                    <input class="input-text" type="file" accept="image/*" name="usr_img" required>
                </div>
                <div>
                    <button name="saveEditImg" class="bg-blue-600 text-white py-2 px-3 rounded-lg w-full">บันทึก</button>
                </div>
                
            </form>
        </div>
        <div class="col-span-3"></div>
    </div>
    <br>
</main>


<!-- <input class="input-text" type="password" name="usr_password" placeholder="รหัสผ่าน" required>
<input class="input-text" type="password" name="usr_password1" placeholder="ยืนยันรหัสผ่าน" required> -->