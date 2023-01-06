<?php
$db = import('./Database/db');
$getParams = import('wisit-router/getParams');
$Post = import('./components/Post');


$post_id = (int) $getParams(1);


$re_Post = $db->query("SELECT * FROM post WHERE post_id = $post_id");
$post = fetch($re_Post);
if (!$post) {
    return import('./pages/_error');
}

if (isset($_POST['createComment'])) {
    $date = date('Y-m-d');
    $db->query("INSERT INTO `post_detail`
    (`pd_id`, `post_id`, `pd_name`, `pd_date`, `usr_id`) VALUES
    (NULL, $post_id,'{$_POST['pd_name']}','$date', {$_SESSION['usr']})");
    header("Refresh:0");
    die;
}

$usr_post = fetch($db->query("SELECT * FROM usr WHERE usr_id = {$post['post_usr_id']}")); ?>

<title>โพสต์ | <?php echo $usr_post['usr_name'] ?? ""; ?></title>
<main class="py-3">
    <div class="row">
        <div class="col-span-3">
            <?php import('./components/explore/Nav'); ?>
        </div>
        <div class="col-span-6 text-zinc-800">
            <div class="mt-5 mb-3 text-right px-3">
                <a class="inline-block bg-gray-500 px-3  py-2 text-white rounded-lg" onclick="window.history.back()" href="#">ย้อนกลับ</a>
            </div>
            <?php $Post($post_id); ?>
            <form class="form-control-group" method="post">
                <input class="input-text m-0" type="text" name="pd_name" id="" required>
                <button name="createComment" class="btn primary">แสดงความคิดเห็น</button>
            </form>
            <div class="mx-3">
                <?php import('./components/post/ShowComment'); ?>
            </div>
        </div>
        <div class="col-span-3">
            <?php import('./components/NavContact'); ?>
        </div>
    </div>
</main>