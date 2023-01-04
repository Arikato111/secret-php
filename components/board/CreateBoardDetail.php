<?php
$db = import('./Database/db');
$getParams = import('wisit-router/getParams');

$b_id = $getParams();
if (isset($_POST['createPollDetail'])) {
    if (!isset($_SESSION['usr'])) {
        getAlert('กรุณาเข้าสู่ระบบเพื่อใช้งาน', 'danger');
    } else {

        $date = date('Y-m-d');
        $db->query("INSERT INTO `board_detail`
    (`bd_id`, `b_id`, `bd_name`, `bd_date`, `usr_id`) VALUES 
    (NULL, $b_id,'{$_POST['bd_name']}','$date', {$_SESSION['usr']})");
        header("Refresh:0");
        die;
    }
}
?>

<form method="post" class="form-control-group p-2">
    <input type="text" name="bd_name" maxlength="200" size="200" id="" class="input-text m-0" required>
    <button name="createPollDetail" class="btn primary">ตอบกระทู้</button>
</form>