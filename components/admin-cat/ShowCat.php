<?php
$db = new Database;

if (isset($_POST['deleteCat'])) {
    $cat_id = (int) ($_POST['cat_id'] ?? 0);
    $cat = $db->getCate_ByID($cat_id);
    if (!$cat) {
        getAlert('ไม่พบหมวดหมู่ที่ต้องการ', 'danger');
    } else {
        if (file_exists('./public/cat/' . $cat['cat_img']))
            unlink('./public/cat/' . $cat['cat_img']);
        $db->deleteCate_ByID($cat_id);
        header('Refresh:0');
        die;
    }
}

$allCat = $db->getAllCategory(desc: true);

?>

<div class="relative overflow-x-auto border mx-3 mt-5 rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    icon
                </th>
                <th scope="col" class="px-6 py-3">
                    ชื่อ
                </th>
                <th scope="col" class="px-6 py-3">
                    path
                </th>
                <th scope="col" class="px-6 py-3">
                    แก้ไข
                </th>
                <th scope="col" class="px-6 py-3">
                    ลบ
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allCat as $cat) : ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <img src="/public/cat/<?php echo $cat['cat_img'] ?? "" ?>" alt="">
                    </td>
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?php echo $cat['cat_name'] ?? ""; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $cat['cat_path'] ?? ""; ?>
                    </td>
                    <td class="px-6 py-4">
                        <a href="?cat=<?php echo $cat['cat_id'] ?? ""; ?>" class="btn btn-sm btn-dark">แก้ไข</a>
                    </td>
                    <td class="px-6 py-4">
                        <form method="POST" onsubmit="return confirm('ยืนยันการลบหมวดหมู่ <?php echo $cat['cat_name'] ?? ''; ?>')">
                            <input type="hidden" name="cat_id" value="<?php echo $cat['cat_id'] ?? 0; ?>">
                            <button name="deleteCat" class="btn btn-sm danger">ลบ</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>