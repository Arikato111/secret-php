<?php
$db = new Database;
$usr_id = $_SESSION['usr'] ?? 0;
$usr_profile = $db->getUser_ByID($usr_id);
if (isset($_POST['deleteLog'])) {
    $token1 = $_POST['token'] ?? '';
    $log = $db->getLog_ByTokenOne($token1);
    if ($log) {
        $db->deleteLog_ByID($log['log_id']);
        getAlert('ลบสำเร็จ', 'danger');
    } else {
        getAlert('ไม่พบโทเคนที่ต้องการ', 'danger');
    }
}
$allLog = $db->getLog_ByUsrID($_SESSION['usr'] ?? 0);
if (!$usr_profile) {
    header('Refresh:0');
    die;
};

?>


<div class="form-control w-full">
    <h3 class="text-lg text-center">ประวัติการเข้าสู่ระบบ</h3>
    <div class="relative overflow-x-auto border mx-3 mt-5 rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        token
                    </th>
                    <th scope="col" class="px-6 py-3">
                        เวลา
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ลบ
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allLog as $log) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td scope="row" class="<?php echo $_COOKIE['token1'] == $log['token1'] ? 'bg-zinc-300' : ''; ?> px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?php echo $log['token1'] ?? ""; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo $log['log_date'] ?? ""; ?>
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST">
                                <input type="hidden" name="log">
                                <input type="hidden" name="token" value="<?php echo $log['token1'] ?? ""; ?>">
                                <button name="deleteLog" class="btn btn-sm danger">ลบ</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>