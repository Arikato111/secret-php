<?php
$db = import('./Database/db');

if(isset($_POST['createChoice'])) {
    $p_id = $_GET['p_id'];
    $db->query("INSERT INTO `poll_detail`
    (`pd_id`, `poll_id`, `pd_name`, `pd_count`) VALUES 
    (NULL, $p_id,'{$_POST['pd_name']}', 0)");
    header("Refresh:0");
    die;
}
?>

<form method="post" class="form-control-group">
    <input type="text" name="pd_name" class="input-text m-0" placeholder="เพิ่มตัวเลือก" required>
    <button name="createChoice" class="btn btn-dark ml-1">เพิ่มตัวเลือก</button>
</form>