<?php
$db = new Database;
$p_id = (int) $_GET['p_id'];
$poll = $db->getPoll_ByID($p_id);
if (isset($_POST['updatePollName'])) {
    $poll_name = $_POST['poll_name'] ?? "";

    if (mb_strlen($poll_name) > 200 || mb_strlen($poll_name) == 0) {
        getAlert('ข้อความต้องมีความยาวไม่เกิน 200 ตัวอักษร', 'danger');
    } else {
        $poll_name = htmlchar($poll_name);
        $db->updatePoll($p_id, $poll_name);
        header("Refresh:0");
        die;
    }
}

?>

<form class="form-control" method="post">
    <h4 class="p-1 text-lg">แก้ไขหัวข้อแบบประเมิน</h4>
    <input type="text" name="poll_name" value="<?php echo $poll['poll_name']; ?>" class="input-text" required>
    <div class="text-right">
        <button name="updatePollName" class="btn btn-dark">บันทึก</button>
    </div>
</form>

<?php import('./components/poll/CreateChoice'); ?>
<?php import('./components/poll/ShowChoice'); ?>