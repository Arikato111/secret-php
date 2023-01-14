<?php
$db = new Database;
$getParams = import('wisit-router/getParams');
$p_id = (int) $getParams();

if (isset($_POST['vote'])) {
    $pd_id = (int) ($_POST['pd_id'] ?? 0);
    $pollDetail = $db->getPollDetail_ByID($pd_id);

    if (!$pollDetail) {
        getAlert('ตัวเลือกไม่ถูกต้อง', 'danger');
    } elseif (!isset($_SESSION['usr'])) {
        getAlert('กรุณาเข้าสู่ระบบเพื่อใช้งาน', 'danger');
    } elseif ($db->isVoted($p_id, $_SESSION['usr'])) {
        getAlert('คุณได้ทำการโหวตแบบประเมินนี้แล้ว', 'danger');
    } else {
        $db->insertVote($p_id, $_SESSION['usr']);
        $db->PollDetailCount_Up($pd_id);
        header("Refresh:0");
        die;
    }
}

$allPollDetail = $db->getAllPollDetail_ByPID($p_id);
$total = 0;
foreach ($allPollDetail as $pd) {
    $total += (int) $pd['pd_count'];
}
if (isset($_SESSION['usr'])) {
    $isVote = !$db->isVoted($p_id, $_SESSION['usr']);
} else {
    $isVote = false;
}
?>

<?php if (!$isVote && isset($_SESSION['usr'])) : ?>
    <div class="heading text-lg mx-3">คุณได้ทำการโหวตแล้ว</div>
<?php endif; ?>

<div class="form-control mx-3">
    <?php foreach ($allPollDetail as $pd) :
        $total_count = $total == 0 ? 0 : (int)(($pd['pd_count']) / $total * 100); ?>
        <form method="POST" class="flex items-baseline justify-center">
            <input type="hidden" name="pd_id" value="<?php echo $pd['pd_id'] ?? 0; ?>">
            <div class="input-text">
                <?php echo $pd['pd_name'] ?? ""; ?>
            </div>

            <?php if ($isVote) : ?>
                <button name="vote" class="btn primary ml-1">เลือก</button>
            <?php endif; ?>
        </form>
        <div class="mb-5">
            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                <div class="bg-blue-600 text-xs font-medium text-white text-center p-0.5 leading-none rounded-full" style="width: <?php echo $total_count; ?>%;min-width:2%;"> <?php echo $total_count; ?>%</div>
            </div>
        </div>
    <?php endforeach;
    if (sizeof($allPollDetail) == 0) : ?>
        <div class="text-center">ยังไม่มีตัวเลือก</div>
    <?php endif; ?>
</div>