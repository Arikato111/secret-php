<?php
$db = new Database;
$usr_id = $_SESSION['usr'];
$usr_profile = $db->getUser_ByID($usr_id);

if (isset($_POST['saveEditImg'])) {
    $img_type = mime_content_type($_FILES['usr_img']['tmp_name']) ?? "";
    if (!($_FILES['usr_img'] ?? false)) {
        getAlert('ไม่พบรูปภาพ กรุณาอัพโหลดใหม่อีกครั้ง', 'danger');
    } elseif ($_FILES['usr_img']['size'] > 2048000) {
        getAlert('รูปภาพต้องมีขนาดไม่เกิน 2mb', 'danger');
    } elseif ($img_type != 'image/jpeg' && $img_type != 'image/png') {
        getAlert('รูปภาพต้องเป็น jpeg, png เท่านั้น', 'danger');
    } else {
        $img_name = md5($_FILES['usr_img']['name'] . rand()) . '.jpg';
        move_uploaded_file($_FILES['usr_img']['tmp_name'], './public/profile/' . $img_name);
        if (file_exists('./public/profile/' . $usr_profile['usr_img']))
            unlink('./public/profile/' . $usr_profile['usr_img']);
        $db->updateImgProfile($usr_profile['usr_id'], $img_name);
        header("Refresh:0");
        die;
    }
}
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
                    <div class="p-3 text-center"><img id="blah" class="w-24 h-24 object-cover rounded-full inline-block" src="/public/profile/<?php echo $usr_profile['usr_img']; ?>" alt=""></div>
                </div>

                <div class="flex">
                    <label class="input-label text-zinc-800" for="">รูปโปรไฟล์</label>
                    <input id="dropzone-file" class="input-text" type="file" accept="image/jpeg,image/png" name="usr_img" required>
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

<script>
    const input_img = document.getElementById("dropzone-file")
    input_img.onchange = evt => {
        const [file] = input_img.files
        if (file) {
            const img_tag = document.getElementById("blah");
            img_tag.src = URL.createObjectURL(file)
        }
    }
</script>