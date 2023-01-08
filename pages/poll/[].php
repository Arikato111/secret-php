<?php
$db = new Database;
$PollCard = import('./components/PollCard');
$getParams = import('wisit-router/getParams');
$poll_id = (int) $getParams();
$getPoll = $db->getPoll_ByID($poll_id);
if (!$getPoll) return import('./pages/_error');


$db->PollView_Up($poll_id);
?>

<title>แบบประเมิน | aden</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/poll-user/PollSearch'); ?>
    </div>
    <div class="col-span-6 text-zinc-800">
        <?php $PollCard($getPoll); ?>
        <?php import('./components/poll-user/ShowChoice'); ?>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>