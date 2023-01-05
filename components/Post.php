<?php
$Post = function ($post_id) {
    $db = import('./Database/db');
    $db->query("UPDATE post SET `post_view`=`post_view`+1 WHERE post_id = $post_id");
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

    if (isset($_POST['deletePost'])) {
        $getPost = fetch($db->query("SELECT * FROM post WHERE post_id = {$_POST['post_id']}"));
        unlink('./public/posts/' . $getPost['post_img']);
        $db->query("DELETE FROM post WHERE post_id = {$_POST['post_id']}");
        header("Refresh:0");
        die;
    }

    $allPost = $db->query("SELECT * FROM post WHERE post_id = $post_id");
    $post = fetch($allPost);
    $usr_post = fetch($db->query("SELECT * FROM usr WHERE usr_id = {$post['post_usr_id']}"));
    $cat = fetch($db->query("SELECT * FROM cat WHERE cat_id = {$post['post_cat_id']}"));
?>


    <div class="mb-3 mx-3 bg-white rounded-lg shadow py-3">

        <?php if (
            isset($_SESSION['usr']) && $_SESSION['usr'] == $usr_post['usr_id']
            || (isset($_SESSION['status']) && $_SESSION['status'] == 'admin')
        ) : ?>
            <!-- Dropdown menu -->
            <div class="text-end px-3">
                <button id="dropdownPost" data-dropdown-toggle="dropdownpost" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                </button>
            </div>
            <div id="dropdownpost" class="z-30 hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
                <form method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <ul class="py-1" aria-labelledby="dropdownPost">
                        <li>
                            <button name="deletePost" class="text-rose-600 block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">ลบ</button>
                        </li>
                    </ul>
                </form>
            </div>
            <!-- Dropdown menu -->
        <?php endif; ?>

        <div class="flex items-center px-3">
            <div>
                <img class="w-9 rounded-full inline-block" src="/public/profile/<?php echo $usr_post['usr_img'] ?? ""; ?>" alt="profile image">
            </div>
            <div class="px-3">
                <a class="hover:underline" href="/<?php echo $usr_post['usr_username'] ?? ""; ?>"><?php echo $usr_post['usr_name'] ?? ""; ?></a>
                <div class="text-gray-500 text-sm">โพสต์เมื่อ <?php echo $post['post_date'] ?? ""; ?> ⦁ <?php echo $cat['cat_name'] ?? ""; ?></div>
            </div>
        </div>
        <div class="my-3 px-3">
            <?php echo $post['post_detail'] ?? ""; ?>
        </div>
        <div>
            <img class="w-full" src="/public/posts/<?php echo $post['post_img'] ?? ""; ?>" alt="image post">
        </div>
        <div class="m-3">
            <span><img class="inline-block w-6" src="/public/icons/f-heart.svg" alt="full heart icon">
                <?php echo $db->query("SELECT * FROM post_like WHERE post_id = {$post['post_id']}")->num_rows ?? 0; ?>
            </span>
            <span class="float-right">
                <?php echo $db->query("SELECT * FROM post_detail WHERE post_id = {$post['post_id']}")->num_rows ?? 0; ?>
                ความคิดเห็น
                <span class="mx-3">
                    <?php echo $post['post_view'] ?? 0; ?> รับชม
                </span>
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
                <a href="/post/<?php echo $post['post_id'] ?? ""; ?>" class="py-2 px-3 hover:bg-gray-200 rounded-lg">
                    <img class="inline-block w-6" src="/public/icons/comment.svg" alt="comment icon">
                    ความคิดเห็น
                </a>
            </form>
        </div>
    </div>

<?php };
$export = $Post;
