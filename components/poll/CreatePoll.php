<?php
$db = import('./Database/db');

if(isset($_POST['createPoll'])) {
    $date = date('Y-m-d');
    $db->query("INSERT INTO `poll`
    (`poll_id`, `poll_name`, `poll_date`, `usr_id`, `poll_view`) VALUES 
    (NULL,'{$_POST['poll_name']}','$date','{$_SESSION['usr']}', 0)");
    header("Refresh:0");die;
}
?>

<form class="form-control-group" method="POST">
    <input type="text" name="poll_name" class="input-text m-0" placeholder="สร้างแบบประเมิน" required>
    <button name="createPoll" class="btn btn-dark ml-1">สร้าง</button>
</form>