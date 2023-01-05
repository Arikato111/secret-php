<?php
$db = import('./Database/db');
$getParams = import('wisit-router/getParams');
$Post = import('./components/Post');

$cat_path = $getParams(1);

$cate = fetch($db->query("SELECT * FROM cat WHERE cat_path = '$cat_path'"));
if (!$cate) return import('./pages/_error');

$allPost = $db->query("SELECT * FROM post WHERE post_cat_id = {$cate['cat_id']} ORDER BY post_id DESC LIMIT 40");
?>

<title>สำรวจ | aden</title>
<main class="py-3">
    <div class="row">
        <div class="col-span-3">
            <?php import('./components/explore/Nav'); ?>
        </div>
        <div class="col-span-6">
            <div class="mt-5">
                <?php if ($allPost->num_rows == 0) : ?>
                    <div class="mx-3">
                        <div class="heading">ยังไม่มีโพสต์ในหมวดหมู่นี้</div>
                        <div class="form-control">
                            <a href="/explore/" class="btn primary text-lg">ดูโพสต์ทั้งหมด</a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                while ($post = fetch($allPost)) :
                    $Post($post['post_id']); ?>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="col-span-3">
            <?php import('./components/NavContact'); ?>
        </div>
    </div>
</main>