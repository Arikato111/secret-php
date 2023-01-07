<?php
$db = new Database;
$getParams = import('wisit-router/getParams');
$cat_path = $getParams(1);
$cate = $db->getCate_ByPath($cat_path);
if (!$cate) {
    $b_id = (int) $cat_path;
    $board = $db->getBoard_ByID($b_id);
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