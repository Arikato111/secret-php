<?php
$db = new Database;

if (isset($_POST['deletePoll'])) {
    $d_poll_id = (int) ($_POST['poll_id'] ?? 0);

    $db->deletePoll_ByID($d_poll_id);
    $db->deleteAllPollDetail_ByPID($d_poll_id);
    $db->deleteAllPollLog_ByPID($d_poll_id);
    header("Refresh:0");
    die;
}

$allPoll = $db->getAllPoll(limit: 1000, desc: true);
?>

<div class="relative overflow-x-auto border mx-3 mt-5 rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    หัวข้อ
                </th>
                <th scope="col" class="px-6 py-3">
                    วันที่
                </th>
                <th scope="col" class="px-6 py-3">
                    ผลโหวต
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
            <?php foreach ($allPoll as $poll) : ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?php echo $poll['poll_name']; ?>
                    </th>
                    <td class="px-6 py-4">
                        <?php echo $poll['poll_date']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $db->Poll_TopVote($poll['poll_id'])['pd_name'] ?? "ยังไม่มีผลโหวต"; ?>
                    </td>
                    <td class="px-6 py-4">
                        <a class="btn btn-warning btn-sm" href="?p_id=<?php echo $poll['poll_id']; ?>">แก้ไข</a>
                    </td>
                    <td class="px-6 py-4">
                        <form method="post">
                            <input type="hidden" name="poll_id" value="<?php echo $poll['poll_id']; ?>">
                            <button name="deletePoll" class="btn btn-sm danger">ลบ</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>