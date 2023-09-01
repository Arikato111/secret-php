<?php
$db = new Database;
$p_id = (int) $_GET['p_id'];

if (isset($_POST['deleteChoice'])) {
    $pd_id = (int) $_POST['pd_id'];
    $db->deletePollDetail_ByID($pd_id);
    header("Refresh:0");
    die;
}
if (isset($_POST['updateChoice'])) {
    $pd_id = (int) $_POST['pd_id'];
    $pd_name = $_POST['pd_name'] ?? '';

    if (
        mb_strlen($pd_name) > 100 ||
        mb_strlen(($pd_name)) == 0
    ) {
        getAlert('ข้อความต้องมีขนาดไม่เกิน 100 ตัวอักษร', 'danger');
    } else {
        $pd_name = htmlchar($pd_name);
        $db->updatePollDetail($pd_id, $pd_name);
        header("Refresh:0");
        die;
    }
}

$allPollDetail = $db->getAllPollDetail_ByPID($p_id);
$total = 0;
foreach ($allPollDetail as $pd) {
    $total += (int) $pd['pd_count'];
}
?>

<div class="form-control mx-3">
    <?php foreach ($allPollDetail as $pd) :
        $total_count = $total == 0 ? 0 : (int)(($pd['pd_count']) / $total * 100); ?>
        <form method="POST" class="flex items-baseline justify-center">
            <input type="hidden" name="pd_id" value="<?php echo $pd['pd_id']; ?>">
            <input type="text" class="input-text" maxlength="100" name="pd_name" value="<?php echo $pd['pd_name']; ?>" required>
            <button name="updateChoice" class="btn btn-dark ml-1">บันทึก</button>
            <button name="deleteChoice" class="btn danger ml-1">ลบ</button>
        </form>
        <div class="mb-5">
            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                <div class="bg-black text-xs font-medium text-white text-center p-0.5 leading-none rounded-full" style="width: <?php echo $total_count; ?>%;min-width:2%;"> <?php echo $total_count; ?>%</div>
            </div>
        </div>
    <?php endforeach; ?>
</div>