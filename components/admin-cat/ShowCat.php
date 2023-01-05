<?php
$db = import('./Database/db');

if(isset($_POST['deleteCat'])) {
    $cat_id = (int) $_POST['cat_id'];
    $db->query("DELETE FROM cat WHERE cat_id = $cat_id LIMIT 1");
    header("Refresh:0");die;
}

$allCat = $db->query("SELECT * FROM cat ORDER BY cat_id DESC");

?>

<div class="relative overflow-x-auto border mx-3 mt-5 rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ชื่อ
                </th>
                <th scope="col" class="px-6 py-3">
                    path
                </th>
                <th scope="col" class="px-6 py-3">
                    ลบ
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while($cat = fetch($allCat)): ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo $cat['cat_name'] ?? ""; ?>
                </td>
                <td class="px-6 py-4">
                    <?php echo $cat['cat_path'] ?? ""; ?>
                </td>
                <td class="px-6 py-4">
                    <form method="post">
                        <input type="hidden" name="cat_id" value="<?php echo $cat['cat_id']; ?>">
                        <button name="deleteCat" class="btn btn-sm danger">ลบ</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>