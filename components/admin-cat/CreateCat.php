<?php
$db = new Database;
if (isset($_POST['createCat'])) {
    $cat_name = $_POST['cat_name'] ?? '';
    $cat_path = $_POST['cat_path'] ?? '';

    $img_name = md5(($_FILES['cat_img']['name'] ?? '') . rand()) . '.svg';
    $img_type = isset($_FILES['cat_img']['tmp_name']) ? mime_content_type($_FILES['cat_img']['tmp_name']) : '';

    if (
        strlen($cat_name) > 50 ||
        strlen($cat_name) == 0 ||
        strlen($cat_path)  > 50 ||
        strlen($cat_path) == 0
    ) {
        getAlert('ข้อความต้องมีความยาวไม่เกิน 50 ตัวอักษร', 'danger');
    } elseif (preg_match('/[^ก-ฮเa-zA-Z]/', $cat_name)) {
        getAlert('ชื่อหมวดหมู่ต้องเป็นภาษาไีทยหรือภาษาอังกฤษเท่านั้น ห้ามเว้นวรรค หรือ ขึ้นบรรทัดใหม่', 'danger');
    } elseif (preg_match('/[^a-z]/', $cat_path)) {
        getAlert('path directory ต้องเป็นภาษาอังกฤษตัวพิมเล็กเท่านั้น', 'danger');
    } elseif ($db->Cate_check($cat_name, $cat_path)) {
        getAlert('มีชื่อหมวดหมู่หรือ path directory นี้แล้ว', 'danger');
    } elseif ($img_type != 'image/svg+xml') {
        getAlert('ไอคอนต้องเป็น svg เท่านั้น', 'danger');
    } elseif (!isset($_FILES['cat_img']['size']) || $_FILES['cat_img']['size'] > 1024000) {
        getAlert('รูปภาพต้องมีขนาดไม่เกิน 1mb', 'danger');
    } else {
        move_uploaded_file($_FILES['cat_img']['tmp_name'], './public/cat/' . $img_name);
        $db->insertCategory($cat_name, $cat_path, $img_name);
        header("Refresh:0");
        die;
    }
}
?>

<form method="post" enctype="multipart/form-data" class="form-control sm:sticky sm:top-16 mx-3">
    <div>
        <div class="p-3 text-center"><img id="blah" class="hidden w-12 h-12 object-cover rounded-full" alt=""></div>
    </div>
    <input type="text" name="cat_name" maxlength="50" value="<?php echo $_POST['cat_name'] ?? ''; ?>" pattern="[a-zก-์]{1,50}" placeholder="ชื่อหมวดหมู่" id="" class="input-text" required>
    <input type="text" name="cat_path" maxlength="50" value="<?php echo $_POST['cat_path'] ?? ''; ?>" pattern="[a-z]{1,50}" placeholder="path directory" id="" class="input-text" reauired>
    <input id="dropzone-file" class="input-text block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold  mb-1 file:bg-blue-50 file:text-blue-700       hover:file:bg-violet-100" type="file" accept="image/svg+xml" name="cat_img" required>
    <p class="mb-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG</p>
    <div class="text-right">
        <button name="createCat" class="btn btn-dark">สร้างหมวดหมู่</button>
    </div>
</form>

<script>
    const input_img = document.getElementById("dropzone-file")
    input_img.onchange = evt => {
        const [file] = input_img.files
        if (file) {
            const img_tag = document.getElementById("blah");
            img_tag.src = URL.createObjectURL(file)
            img_tag.style.display = "inline-block";
        }
    }
</script>