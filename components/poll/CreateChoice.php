<?php
$db = new Database;

if (isset($_POST['createChoice'])) {
    $p_id = $_GET['p_id'];
    $pd_name = $_POST['pd_name'] ?? '';

    if (
        strlen($pd_name) > 100 ||
        strlen($pd_name) == 0
    ) {
        getAlert('ข้อความต้องมีขนาดไม่เกิน 100 ตัวอักษร', 'danger');
    } else {
        $pd_name = htmlchar($pd_name);
        $db->insertPollDetail($p_id, $pd_name);
        header("Refresh:0");
        die;
    }
}
?>

<form method="post" class="form-control-group">
    <input type="text" name="pd_name" class="input-text m-0" maxlength="100" placeholder="เพิ่มตัวเลือก" required>
    <button name="createChoice" class="btn btn-dark ml-1">เพิ่มตัวเลือก</button>
</form>