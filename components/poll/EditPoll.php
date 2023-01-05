<?php
$db = import('./Database/db');
$p_id = (int) $_GET['p_id'];

if (isset($_POST['updatePollName'])) {
    $db->query("UPDATE poll SET `poll_name`='{$_POST['poll_name']}' WHERE poll_id = $p_id");
    header("Refresh:0");
    die;
}

$poll = fetch($db->query("SELECT * FROM poll WHERE poll_id = $p_id LIMIT 1"));
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