<?php
$db = new Database;

if (isset($_POST['createPoll'])) {
    $poll_name = $_POST['poll_name'] ?? '';

    if (
        mb_strlen($poll_name) > 200 ||
        mb_strlen($poll_name) == 0
    ) {
        getAlert('ข้อความต้องไม่เกิน 200 ตัวอักษร', 'danger');
    } else {
        $poll_name = htmlchar($poll_name);
        $db->insertPoll($poll_name, $_SESSION['usr']);
        header("Refresh:0");
        die;
    }
}
?>

<form class="form-control-group sm:sticky sm:top-16" method="POST">
    <input type="text" name="poll_name" class="input-text m-0" maxlength="200" placeholder="สร้างแบบประเมิน" required>
    <button name="createPoll" class="btn btn-dark ml-1">สร้าง</button>
</form>