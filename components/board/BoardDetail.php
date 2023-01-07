<?php
$db = new Database;
$getParams = import('wisit-router/getParams');
$b_id = (int) $getParams();
$BoardCard = import('./components/BoardCard');

$db->Board_ViewUp($b_id);

?>
<title>กระทู้ | aden</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/board/Nav'); ?>
    </div>
    <div class="col-span-6 text-zinc-800">

        <?php
        $BoardCard($b_id, false);
        import('./components/board/CreateBoardDetail'); ?>
        <?php import('./components/board/ShowBoardDetail'); ?>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>