<?php
$db = import('./Database/db');

if(isset($_POST['deleteMember'])) {
    $db->query("DELETE FROM usr WHERE usr_id = {$_POST['usr_id']}");
    header("Refresh:0");die;
}

if(isset($_POST['updateStatus'])) {
    $db->query("UPDATE usr SET `usr_status`= '{$_POST['usr_status']}' WHERE usr_id = {$_POST['usr_id']}");
    header("Refresh:0");die;
}

if (isset($_GET['search'])) {
    $search = str_replace("'", '', $_GET['search']);
    $allMember = $db->query("SELECT * FROM usr WHERE 
    `usr_username` LIKE '%$search%' OR
    `usr_name` LIKE '%$search%' ORDER BY usr_id DESC ");
} else {
    $allMember = $db->query("SELECT * FROM usr ORDER BY usr_id DESC");
}
?>

<div class="relative overflow-x-auto border mx-3 mt-5 rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    username
                </th>
                <th scope="col" class="px-6 py-3">
                    ชื่อ - สกุล
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($usr = fetch($allMember)) : ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <a class="hover:underline" href="/<?php echo $usr['usr_username']; ?>">
                            <?php echo $usr['usr_username']; ?>
                        </a>
                    </th>
                    <td class="px-6 py-4">
                        <a class="hover:underline" href="/<?php echo $usr['usr_username']; ?>">
                        <?php echo $usr['usr_name']; ?>
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <form method="post">
                            <input type="hidden" name="usr_id" value="<?php echo $usr['usr_id']; ?>">
                            <select name="usr_status" id="">
                                <option value="admin" <?php echo $usr['usr_status'] == 'admin' ? "selected" : ""; ?>>admin</option>
                                <option value="user" <?php echo $usr['usr_status'] != 'admin' ? "selected" : ""; ?>>user</option>
                            </select>
                            <button name="updateStatus" class="btn-sm btn btn-dark">บันทึก</button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <form method="post">
                            <input type="hidden" name="usr_id" value="<?php echo $usr['usr_id']; ?>">
                            <button name="deleteMember" class="btn btn-sm danger">ลบ</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>