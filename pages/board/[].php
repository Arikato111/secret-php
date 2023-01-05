<?php
$db = import('./Database/db');
$getParams = import('wisit-router/getParams');
$cat_path = $getParams(1);
$cat_path = str_replace("'", '', $cat_path);
$cate = fetch($db->query("SELECT * FROM cat WHERE cat_path = '$cat_path'"));
if (!$cate) {
    $cat_path = (int) $cat_path;
    $board = fetch($db->query("SELECT * FROM board WHERE b_id = {$cat_path}"));
    if ($board) return import('./components/board/BoardDetail');
    return import('./pages/_error');
}
?>

<title>กระดานสนทนา | aden</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/board/Nav'); ?>
    </div>
    <div class="col-span-6 text-zinc-800">
        <?php import('./components/board/CreateBoard'); ?>
        <?php import('./components/board/ShowBoard'); ?>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>