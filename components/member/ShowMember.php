<?php
$db = new Database;

if (isset($_POST['deleteMember'])) {
    $usr_id = (int)($_POST['usr_id'] ?? 0);
    deleteUser($usr_id);
    header("Refresh:0");
    die;
}

if (isset($_POST['updateStatus'])) {
    $status = $_POST['usr_status'] ?? "";
    $usr_id = (int) ($_POST['usr_id'] ?? 0);
    $usr_check = $db->getUser_ByID($usr_id);
    if ($status != 'admin' && $status != 'user') {
        getAlert('สิทธิ์ไม่ถูกต้อง', 'danger');
    } elseif (!$usr_check) {
        getAlert('ผู้ใช้งานไม่ถูกต้อง', 'danger');
    } else {
        $db->updateStatusUser($usr_id, $status);
        header("Refresh:0");
        die;
    }
}

if (isset($_GET['search'])) {
    $search = $_GET['search'] ?? "";
    $allMember = $db->searchUser($search);
} else {
    $allMember = $db->getUser_All(desc: true, limit: 399);
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
            <?php foreach ($allMember as $usr) : ?>
                <tr class="bg-white border-b ">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <a class="hover:underline" href="/<?php echo $usr['usr_username'] ?? ""; ?>">
                            <?php echo $usr['usr_username'] ?? "ไม่พบชื่อผู้ใช้งาน"; ?>
                        </a>
                    </th>
                    <td class="px-6 py-4">
                        <a class="hover:underline" href="/<?php echo $usr['usr_username'] ?? ""; ?>">
                            <?php echo $usr['usr_name'] ?? "ไม่พบชื่อ - สกุล ผู้ใช้งาน"; ?>
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <form method="post">
                            <input type="hidden" name="usr_id" value="<?php echo $usr['usr_id']; ?>">
                            <select class="bg-white" name="usr_status" id="">
                                <option value="admin" <?php echo $usr['usr_status'] == 'admin' ? "selected" : ""; ?>>admin</option>
                                <option value="user" <?php echo $usr['usr_status'] != 'admin' ? "selected" : ""; ?>>user</option>
                            </select>
                            <button name="updateStatus" class="btn-sm btn btn-dark">บันทึก</button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <form method="post" onsubmit="return confirm('ยืนยันการลบ\nหากทำการลบข้อมูลทั้งหมดที่เกี่ยวกับผู้ใช้งานนี้ทังหมดจะถูกลบไปด้วย ')">
                            <input type="hidden" name="usr_id" value="<?php echo $usr['usr_id']; ?>">
                            <button name="deleteMember" class="btn btn-sm danger">ลบ</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>