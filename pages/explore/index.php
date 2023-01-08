<?php
$db = new Database;
$Post = import('./components/Post');

$allPost = $db->getAllPost(limit: 100, desc: true);
?>

<title>สำรวจ | aden</title>
<main class="py-3">
    <div class="row">
        <div class="col-span-3">
            <?php import('./components/explore/Nav'); ?>
        </div>
        <div class="col-span-6 mt-5">
            <?php
            foreach ($allPost as $post) {
                $Post($post);
            } ?>
        </div>
        <div class="col-span-3">
            <?php import('./components/NavContact'); ?>
        </div>
    </div>
</main>