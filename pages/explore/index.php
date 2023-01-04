<?php
$db = import('./Database/db');
$Post = import('./components/Post');

$allPost = $db->query("SELECT * FROM post ORDER BY post_id DESC LIMIT 40");
?>

<title>explore | aden</title>
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