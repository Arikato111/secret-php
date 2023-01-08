<?php
if (!isset($_SESSION['usr'])) return require('./pages/_error.php');

$db = new Database;

if (isset($_POST['createPost']) && isset($_SESSION['usr'])) {
    $post_detail = $_POST['post_detail'] ?? "";
    $cat_id = $_POST['post_cat_id'] ?? 0;
    $img_name = md5($_FILES['post_img']['name'] . rand()) . '.jpg';
    $img_type = mime_content_type($_FILES['post_img']['tmp_name']);
    $img_size = $_FILES['post_img']['size'] ?? 0;
    if (
        strlen($post_detail) > 1300 ||
        strlen($post_detail) == 0
    ) {
        getAlert('ข้อความมีขนาดยาวเกินไป', 'danger');
    } elseif (!($db->getCate_ByID($cat_id))) {
        getAlert('หมวดหมูไม่ถูกต้อง กรุณาเลือกใหม่อีกครั้ง', 'danger');
    } elseif ($img_type !== 'image/jpeg' && $img_type != 'image/png') {
        getAlert('รูปภาพต้องเป็น jpg, jpeg หรือ png เท่านั้น', 'danger');
    } elseif ($img_size > 2048000) {
        getAlert('รูปภาพต้องมีขนาดไม่เกิน 2mb', 'danger');
    } else {
        move_uploaded_file($_FILES['post_img']['tmp_name'], './public/posts/' . $img_name);
        $post_detail = htmlchar($post_detail);
        $db->insertPost($post_detail, $_SESSION['usr'], $cat_id, $img_name);
        getAlert('สร้างโพสต์สำเร็จ', 'success');
    }
}
$allCat = $db->getAllCategory();
?>

<title>สร้างโพสต์ | aden</title>
<div class="row">
    <div class="col-span-3">
        <div class="text-end mt-5 mx-3">
            <button class="px-3 py-2 bg-gray-500 rounded-lg inline-block mt-3 text-white" onclick="window.history.back(-1)">ย้อนกลับ</button>
        </div>
    </div>
    <div class="col-span-6 px-3">
        <h3 class="heading">สร้างโพสต์</h3>
        <form method="post" class="form-control" enctype="multipart/form-data">
            <textarea name="post_detail" maxlength="1300" class="input-text" rows="7" placeholder="ข้อความโพสต์" required></textarea>

            <div class="mb-3">

                <label for="categories" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เลือกหมวดหมู่</label>
                <select id="categories" name="post_cat_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <?php foreach ($allCat as $cat) : ?>
                        <option value="<?php echo $cat['cat_id']; ?>"><?php echo $cat['cat_name']; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>

            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center  overflow-hidden justify-center pt-5 pb-6">
                        <img style="display: none;" id="blah" class="w-fit h-fit object-cover" src="" alt="">
                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">รูปภาพของโพสต์</span></p>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">คลิกเพื่ออัพโหลด</span>หรือ ลากไฟล์วางลงที่นี่</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG</p>
                    </div>
                    <input id="dropzone-file" type="file" name="post_img" accept="image/jpeg,image/png" class="hidden" required />
                    <script>
                        const input_img = document.getElementById("dropzone-file")
                        input_img.onchange = evt => {
                            const [file] = input_img.files
                            if (file) {
                                const img_tag = document.getElementById("blah");
                                img_tag.src = URL.createObjectURL(file)
                                img_tag.style.display = 'block'
                            }
                        }
                    </script>
                </label>
            </div>
            <button name="createPost" class="btn primary mt-3">โพสต์</button>
        </form>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>