<?php
$db = new Database;

if (isset($_POST['deleteLog'])) {
    $log_id = (int) ($_POST['token'] ?? 0);
    $db->deleteLog_ByID($log_id);
    header('Refresh:0;');
}

$limit = (int) ($_GET['limit'] ?? 0);
if ($limit < 0) $limit  = $limit * -1;
if ($_GET['q'] ?? false) {
    $usr_id = (int)$_GET['q'];
    $allLog = $db->getAllLog_ByUsrID($usr_id, limit: $limit, desc: true);
} else {
    $allLog = $db->getAllLog(desc: true, limit: $limit);
}
?>


<title>การเข้าสู่ระบบ | admin</title>
<div class="row">
    <div class="col-span-3">
        <form class="form-control-group sm:sticky sm:top-16">
            <input type="text" name="q" class="input-text m-0" placeholder="ค้นหาด้วยไอดี">
            <button class="btn btn-dark ml-1">ค้นหา</button>
        </form>
    </div>
    <div class="col-span-6">
        <div>
            <div class="relative overflow-x-auto border mx-3 mt-5 rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ผู้ใช้
                            </th>
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
                        <?php foreach ($allLog as $log) :
                            $usr_log = $db->getUser_ByID($log['usr_id']); ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a class="hover:underline" href="/<?php echo $usr_log['usr_username'] ?? ""; ?>">
                                        <?php echo $usr_log['usr_id'] ?? 0; ?>@<?php echo $usr_log['usr_username'] ?? ""; ?>
                                    </a>
                                </td>
                                <td scope="row" class="max-w-xs px-6 py-4 overflow-hidden font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?php echo $log['token1'] ?? ""; ?>
                                </td>
                                <td class="px-6 py-4 ">
                                    <?php echo $log['log_date'] ?? ""; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST">
                                        <input type="hidden" name="log">
                                        <input type="hidden" name="token" value="<?php echo $log['log_id'] ?? ""; ?>">
                                        <button name="deleteLog" class="btn btn-sm danger">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>