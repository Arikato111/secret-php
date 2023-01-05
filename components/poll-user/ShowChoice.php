<?php
$db = import('./Database/db');
$getParams = import('wisit-router/getParams');
$p_id = (int) $getParams();

if(isset($_POST['vote'])) {
    if($db->query("SELECT * FROM poll_log WHERE
    `poll_id` = $p_id AND `usr_id` = {$_SESSION['usr']} LIMIT 1")->num_rows != 0) {
        header("Refresh:0");die;    
    } else {
        $db->query("INSERT INTO `poll_log`
        (`pl_id`, `poll_id`, `usr_id`) VALUES 
        (NULL,$p_id, {$_SESSION['usr']})");
        $db->query("UPDATE poll_detail SET `pd_count`=`pd_count`+1 WHERE pd_id = {$_POST['pd_id']} LIMIT 1");
        header("Refresh:0");die;
    }
}

$allPollDetail = fetch_all($db->query("SELECT * FROM poll_detail WHERE poll_id = $p_id"));
$total = 0;
foreach ($allPollDetail as $pd) {
    $total += (int) $pd['pd_count'];
}

if (isset($_SESSION['usr'])) {
    $isVote = $db->query("SELECT * FROM poll_log WHERE
    `poll_id` = $p_id AND `usr_id` = {$_SESSION['usr']} LIMIT 1")->num_rows == 0;
} else {
    $isVote = false;
}
?>

<?php if (!$isVote) : ?>
    <div class="heading text-lg mx-3">คุณได้ทำการโหวตแล้ว</div>
<?php endif; ?>

<div class="form-control mx-3">
    <?php foreach ($allPollDetail as $pd) :
        $total_count = $total == 0 ? 0 : (int)(($pd['pd_count']) / $total * 100); ?>
        <form method="POST" class="flex items-baseline justify-center">
            <input type="hidden" name="pd_id" value="<?php echo $pd['pd_id']; ?>">
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
    if(sizeof($allPollDetail) == 0): ?>
    <div class="text-center">ยังไม่มีตัวเลือก</div>
    <?php endif; ?>
</div>