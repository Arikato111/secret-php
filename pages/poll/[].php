<?php
$db = import('./Database/db');
$getParams = import('wisit-router/getParams');
$poll_id = (int) $getParams();
$getPoll = $db->query("SELECT * FROM poll WHERE poll_id = $poll_id LIMIT 1");
if ($getPoll->num_rows == 0) return import('./pages/_error');
?>

<title>แบบประเมิน | aden</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/poll-user/PollSearch'); ?>
    </div>
    <div class="col-span-6 text-zinc-800">
        <?php import('./components/poll-user/ShowPollDetail'); ?>
        <?php import('./components/poll-user/ShowChoice'); ?>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>