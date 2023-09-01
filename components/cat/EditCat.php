<?php
$db = new Database;
$cat_id = (int)($_GET['cat'] ?? 0);
$cat = $db->getCate_ByID($cat_id);
if (!$cat) return import('./pages/_error');

if (isset($_POST['updateCatImg'])) {
    $img_name = md5(($_FILES['cat_img']['name'] ?? '') . rand()) . '.svg';
    $img_type = isset($_FILES['cat_img']['tmp_name']) ?
        mime_content_type($_FILES['cat_img']['tmp_name']) : '';

    if ($img_type != 'image/svg+xml') {
        getAlert('ไอคอนต้องเป็น svg เท่านั้น', 'danger');
    } elseif (!isset($_FILES['cat_img']['size']) || $_FILES['cat_img']['size'] > 1024000) {
        getAlert('รูปภาพต้องมีขนาดไม่เกิน 1mb', 'danger');
    } else {
        if (file_exists('./public/cat/' . $cat['cat_img']))
            unlink('./public/cat/' . $cat['cat_img']);
        move_uploaded_file($_FILES['cat_img']['tmp_name'], './public/cat/' . $img_name);
        $db->updateCate_Img($cat['cat_id'], $img_name);
        header("Refresh:0");
        die;
    }
}

if (isset($_POST['updateCate'])) {
    $cat_name = $_POST['cat_name'] ?? '';
    $cat_path = $_POST['cat_path'] ?? '';

    if (
        mb_strlen($cat_name) > 50 ||
        mb_strlen($cat_name) == 0 ||
        mb_strlen($cat_path)  > 50 ||
        mb_strlen($cat_path) == 0
    ) {
        getAlert('ข้อความต้องมีความยาวไม่เกิน 50 ตัวอักษร', 'danger');
    } elseif (preg_match('/[^ก-ฮเa-zA-Z]/', $cat_name)) {
        getAlert('ชื่อหมวดหมู่ต้องเป็นภาษาไีทยหรือภาษาอังกฤษเท่านั้น ห้ามเว้นวรรค หรือ ขึ้นบรรทัดใหม่', 'danger');
    } elseif (preg_match('/[^a-z]/', $cat_path)) {
        getAlert('path directory ต้องเป็นภาษาอังกฤษตัวพิมเล็กเท่านั้น', 'danger');
    } elseif ($db->Cate_check($cat_name, $cat_path, $cat['cat_id'])) {
        getAlert('มีชื่อหมวดหมู่หรือ path directory นี้แล้ว', 'danger');
    } else {
        $db->updateCate($cat['cat_id'], $cat_name, $cat_path);
        header("Refresh:0");
        die;
    }
}
?>

<title>แก้ไขหมวดหมู่ | admin </title>
<div class="row">
    <div class="col-span-3">
    </div>
    <div class="col-span-6">
        <div class="text-right mx-3 mt-3">
            <a class="px-3 py-2 bg-gray-500 rounded-lg inline-block mt-3 text-white" href="/admin/category">ย้อนกลับ</a>
        </div>



        <form method="post" enctype="multipart/form-data" class="form-control mx-3">
            <input type="text" name="cat_name" value="<?php echo $cat['cat_name'] ?? ""; ?>" maxlength="50" pattern="[a-zก-์]{1,50}" placeholder="ชื่อหมวดหมู่" id="" class="input-text" required>
            <input type="text" name="cat_path" value="<?php echo $cat['cat_path'] ?? ""; ?>" maxlength="50" pattern="[a-z]{1,50}" placeholder="path directory" id="" class="input-text" required>
            <div class="text-right">
                <button name="updateCate" class="btn btn-dark">แก้ไขหมวดหมู่</button>
            </div>
        </form>

        <form method="POST" class="form-control mx-3" enctype="multipart/form-data">
            <div>
                <div class="p-3 text-center"><img id="blah" src="/public/cat/<?php echo $cat['cat_img'] ?? ""; ?>" class="w-24 h-24 object-cover rounded-full inline-block" alt=""></div>
            </div>
            <input id="dropzone-file" class="input-text block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold  mb-1 file:bg-blue-50 file:text-blue-700 hover:file:bg-violet-100" type="file" accept="image/svg+xml" name="cat_img" required>
            <p class="mb-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG</p>
            <div class="text-right">
                <button name="updateCatImg" class="btn btn-dakr">เปลี่ยนไอคอน</button>
            </div>
        </form>

    </div>
    <div class="col-span-3"></div>
</div>

<script>
    const input_img = document.getElementById("dropzone-file")
    input_img.onchange = evt => {
        const [file] = input_img.files
        if (file) {
            const img_tag = document.getElementById("blah");
            // console.log(img_tag.src);
            img_tag.src = URL.createObjectURL(file)

        }
    }
</script>