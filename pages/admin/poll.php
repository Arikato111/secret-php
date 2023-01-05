<?php
$db = import('./Database/db');


?>

<title>แบบประเมิน | admin</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/poll/CreatePoll'); ?>
    </div>
    <div class="col-span-6">
        <?php
        if (isset($_GET['p_id'])) {
            $p_id = (int) $_GET['p_id'];
            if ($db->query("SELECT * FROM poll WHERE poll_id = $p_id")->num_rows != 0) {
                import('./components/poll/EditPoll');
            } else {
                import('./components/poll/ShowPoll');
            }
        } else {
            import('./components/poll/ShowPoll');
        }
        ?>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>