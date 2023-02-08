<?php
$db = new Database;
$getParams = import('wisit-router/getParams');
$Post = import('./components/Post');

$cat_path = $getParams(1) ?? "";

$cate = $db->getCate_ByPath($cat_path);
if (!$cate) return import('./pages/_error');

$allPost = $db->getAllPost(limit: 100, desc: true, cat_id: $cate['cat_id']);
?>

<title>สำรวจ | <?php echo $cate['cat_name'] ?? ""; ?> | aden</title>
<main class="py-3">
    <div class="row">
        <div class="col-span-3">
            <?php import('./components/explore/Nav'); ?>
        </div>
        <div class="col-span-6">
            <div class="mt-5">
                <?php if (sizeof($allPost) == 0) : ?>
                    <div class="mx-3">
                        <div class="heading">ยังไม่มีโพสต์ในหมวดหมู่นี้</div>
                        <div class="form-control">
                            <a href="/explore/" class="btn primary text-lg">ดูโพสต์ทั้งหมด</a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                foreach ($allPost as $post) {

                    $Post($post);
                }
                ?>
            </div>
        </div>
        <div class="col-span-3">
            <?php import('./components/NavContact'); ?>
        </div>
    </div>
</main>