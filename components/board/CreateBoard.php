<?php $db = new Database;

if (isset($_POST['createBoard'])) {
    $board_name = $_POST['b_name'] ?? "";
    $cat_id = (int)($_POST['cat_id'] ?? 0);
    $cat_check = $db->getCate_ByID($cat_id);

    if (!isset($_SESSION['usr']) || empty($_SESSION['usr'])) {
        getAlert('กรุณาเข้าสู่ระบบเพื่อใช้งาน', 'danger');
    } elseif (
        mb_strlen($board_name) > 200 ||
        mb_strlen($board_name) == 0
    ) {
        getAlert("ข้อความต้องไม่เกิน 200 ตัวอักษร", 'danger');
    } elseif (!$cat_check) {
        getAlert('กรุณาเลือกหมวดหมู่', 'danger');
    } else {
        $b_name = htmlchar($board_name);
        $db->insertBoard($b_name, $_SESSION['usr'], $cat_id);
        header("Refresh:0");
        die;
    }
}
$allCat = $db->getAllCategory();
?>

<form method="POST" class="mt-5 z-10 relative p-2 mx-3 form-control">
    <input type="hidden" name="cat_id" id="catid" required>
    <div class="flex">
        <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your Email</label>
        <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button"><span id="cate">หมวดหมู่</span> <svg aria-hidden="true" class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg></button>
        <div id="dropdown" class=" hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(897px, 5637px, 0px);">
            <ul class=" py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                <?php foreach ($allCat as $cat) : ?>
                    <li>
                        <button type="button" onclick="setCatId(<?php echo $cat['cat_id'] ?? ''; ?>, '<?php echo $cat['cat_name'] ?? ''; ?>')" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><?php echo $cat['cat_name'] ?? ""; ?></button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="relative w-full">
            <input type="text" name="b_name" maxlength="200" id="search-dropdown" class="focus:outline-none block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="พิมพ์คำถามลงที่นี่" required>
            <button type="submit" name="createBoard" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <span class="">สร้างกระทู้</span>
            </button>
        </div>
    </div>
</form>

<script>
    function setCatId(id, name) {
        document.getElementById("catid").value = id;
        document.getElementById("cate").innerText = name;
    }
</script>