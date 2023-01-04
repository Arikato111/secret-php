<?php
$db = import('./Database/db');
$getParams = import('wisit-router/getParams');

if (isset($_POST['like'])) {
    if (!isset($_SESSION['usr'])) {
        header("Location: /login");
        die;
    }

    $db->query("INSERT INTO `post_like`
    (`pl_id`, `post_id`, `usr_id`) VALUES 
    (NULL, {$_POST['post_id']}, {$_SESSION['usr']})");
    header("Refresh:0");
    die;
}

$post_id = (int) $getParams(1);

$re_Post = $db->query("SELECT * FROM post WHERE post_id = $post_id");
$post = fetch($re_Post);
if (!$post) {
    return import('./pages/_error');
}

$usr_post = fetch($db->query("SELECT * FROM usr WHERE usr_id = {$post['post_usr_id']}")); ?>

<title>โพสต์ | <?php echo $usr_post['usr_name'] ?? ""; ?></title>
<main class="py-3">
    <div class="row">
        <div class="col-span-3">
            <?php import('./components/explore/Nav'); ?>
        </div>
        <div class="col-span-6">
            <div class="mt-5 mb-3 text-right px-3">
                <a class="inline-block bg-gray-500 px-3  py-2 text-white rounded-lg" href="/explore/">ย้อนกลับ</a>
            </div>
            <div class="mb-3 mx-3 bg-white rounded-lg shadow py-3">
                <div class="flex items-center px-3">
                    <div>
                        <img class="w-9 rounded-full inline-block" src="/public/profile/<?php echo $usr_post['usr_img'] ?? ""; ?>" alt="profile image">
                    </div>
                    <div class="px-3">
                        <span><?php echo $usr_post['usr_name'] ?? ""; ?></span>
                        <div class="text-gray-500 text-sm">โพสต์เมื่อ <?php echo $post['post_date'] ?? ""; ?></div>
                    </div>
                </div>
                <div class="my-3 px-3">
                    <?php echo $post['post_detail'] ?? ""; ?>
                </div>
                <div>
                    <img class="w-full" src="/public/posts/<?php echo $post['post_img'] ?>" alt="image post">
                </div>
                <div class="m-3">
                    <span><img class="inline-block w-6" src="/public/icons/f-heart.svg" alt="full heart icon">
                        <?php echo $db->query("SELECT * FROM post_like WHERE post_id = {$post['post_id']}")->num_rows ?? 0; ?>
                    </span>
                    <span class="float-right">
                        <?php echo $db->query("SELECT * FROM post_detail WHERE post_id = {$post['post_id']}")->num_rows ?? 0; ?>
                        ความคิดเห็น
                    </span>
                </div>
                <hr class="border">
                <div class="p-3 text-gray-600">
                    <form method="post">
                        <?php if (!isset($_SESSION['usr']) || $db->query("SELECT * FROM post_like WHERE post_id = {$post['post_id']} AND usr_id = {$_SESSION['usr']}")->num_rows == 0) : ?>
                            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                            <button name="like" class="py-1 px-3 hover:bg-gray-200 rounded-lg"><img class="inline-block w-6" src="/public/icons/heart.svg" alt="heart icon"> ถูกใจ</button>
                        <?php else : ?>
                            <span class="py-2 cursor-pointer px-3 text-rose-500 hover:bg-gray-200 rounded-lg"><img class="inline-block w-6" src="/public/icons/heart-red.svg" alt="heart icon"> ถูกใจแล้ว</span>
                        <?php endif; ?>
                        <a href="/post/1" class="py-2 px-3 hover:bg-gray-200 rounded-lg">
                            <img class="inline-block w-6" src="/public/icons/comment.svg" alt="comment icon">
                            ความคิดเห็น
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-span-3">
            <?php import('./components/NavContact'); ?>
        </div>
    </div>
</main>