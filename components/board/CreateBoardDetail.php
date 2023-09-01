<?php
$db = new Database;
$getParams = import('wisit-router/getParams');

$b_id = $getParams();
if (isset($_POST['createPollDetail'])) {
    $bd_name = $_POST['bd_name'] ?? '';

    if (!isset($_SESSION['usr']) || empty($_SESSION['usr'])) {
        getAlert('กรุณาเข้าสู่ระบบเพื่อใช้งาน', 'danger');
    } elseif (
        mb_strlen($bd_name) > 200 ||
        mb_strlen($bd_name) == 0
    ) {
        getAlert('ข้อความต้องมีความยาวไม่เกิน 200 ตัวอักษร', 'danger');
    } else {
        $bd_name = htmlchar($bd_name);
        $db->insertBoardDetail($b_id, $bd_name, $_SESSION['usr']);
        header("Refresh:0");
        die;
    }
}
?>

<form method="post" class="form-control-group p-2">
    <input type="text" name="bd_name" maxlength="200" size="200" id="" placeholder="พิมพ์ข้อความที่นี่" class="input-text m-0" required>
    <button name="createPollDetail" class="btn primary">ตอบกระทู้</button>
</form>