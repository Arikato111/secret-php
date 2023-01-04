<?php
$db = import('./Database/db');
$getParams = import('wisit-router/getParams');
$Post = import('./components/Post');

$cat_path = $getParams(1);

$cate = fetch($db->query("SELECT * FROM cat WHERE cat_path = '$cat_path'"));
if(!$cate) return import('./pages/_error');

$allPost = $db->query("SELECT * FROM post WHERE post_cat_id = {$cate['cat_id']} ORDER BY post_id DESC LIMIT 40");
?>

<title>สำรวจ | aden</title>
<main class="py-3">
    <div class="row">
        <div class="col-span-3">
            <?php import('./components/explore/Nav'); ?>
        </div>
        <div class="col-span-6 mt-5">
        <?php 
        while($post =fetch($allPost)):
        $Post($post['post_id']); ?>
        <?php endwhile; ?>
        </div>
        <div class="col-span-3">
            <?php import('./components/NavContact'); ?>
        </div>
    </div>
</main>

