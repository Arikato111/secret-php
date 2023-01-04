<?php
$getParams = import('wisit-router/getParams');
$db = import('./Database/db');
$Post = import('./components/Post');
$ProfileCard = import('./components/ProfileCard');

$username = $getParams(0);
$usr_profile = fetch($db->query("SELECT * FROM usr WHERE usr_username = '$username'"));

if (!$usr_profile) return require('./pages/_error.php');
if (isset($_POST['editProfile'])) return import('./components/profile/EditProfile');
if (isset($_POST['editImg'])) return import('./components/profile/EditImg');
if (isset($_POST['editPassword'])) return import('./components/profile/EditPassword');
?>

<title><?php echo $username; ?> | โปรไฟล์</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/profile/Nav'); ?>
    </div>
    <div class="col-span-6 flex px-3 flex-col items-center">
        <!-- Content -->
        <?php $ProfileCard($username); ?>
        <!-- Content -->
        <div class="w-full">

            <?php
            $allPost = $db->query("SELECT * FROM post WHERE post_usr_id = {$usr_profile['usr_id']} ORDER BY post_id DESC LIMIT 100");
            if ($allPost->num_rows == 0) : ?>
                <div class="heading w-full block">
                    ยังไม่มีโพสต์
                </div>
            <?php
            endif;
            while ($post = fetch($allPost)) :
                $Post($post['post_id']);
            ?>
            <?php endwhile; ?>
        </div>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>