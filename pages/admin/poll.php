<?php
$db = new Database;


?>

<title>แบบประเมิน | admin</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/poll/CreatePoll'); ?>
    </div>
    <div class="col-span-6 text-zinc-800">
        <?php
        if (isset($_GET['p_id'])) {
            $p_id = (int) $_GET['p_id'];

            if ($db->getPoll_ByID($p_id)) {
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