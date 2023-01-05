<?php
$getParams = import('wisit-router/getParams');
$db = import('./Database/db');
$ProfileCard = import('./components/ProfileCard');
$username = $getParams(0);
$usr_profile = fetch($db->query("SELECT * FROM usr WHERE usr_username = '$username'"));

if (!$usr_profile) return require('./pages/_error.php');
if (isset($_POST['editProfile'])) return import('./components/profile/EditProfile');
if (isset($_POST['editImg'])) return import('./components/profile/EditImg');
if (isset($_POST['editPassword'])) return import('./components/profile/EditPassword');

$AllFollower = $db->query("SELECT * FROM follow WHERE fol_def = {$usr_profile['usr_id']} LIMIT 100");
?>

<title><?php echo $username; ?> | ผู้ติดตาม</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/profile/Nav'); ?>
    </div>
    <div class="col-span-6 flex px-3 flex-col items-center">
        <!-- Content -->
        <?php $ProfileCard($username); ?>
        <h3 class="heading w-full">มีผู้ติดตาม
            <?php echo $AllFollower->num_rows ?? 0; ?>
            คน
        </h3>
        <div class="w-full mx-3">
            <?php while ($fol = fetch($AllFollower)) :
                $usr = fetch($db->query("SELECT * FROM usr WHERE usr_id = {$fol['fol_atk']} LIMIT 1")); ?>
                <div class="form-control w-full text-zinc-800">
                    <a href="/<?php echo $usr['usr_username'] ?? ""; ?>" class="flex items-center px-3">
                        <div>
                            <img class="w-9 h-9 rounded-full inline-block object-cover" src="/public/profile/<?php echo $usr['usr_img'] ?? ""; ?>" alt="profile image">
                        </div>
                        <div class="px-3">
                            <div><?php echo $usr['usr_name'] ?? ""; ?></div>
                            <div class="text-gray-500 text-sm">@<?php echo $usr['usr_username']; ?></div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
        <?php if ($AllFollower->num_rows == 0) : ?>
            <div class="heading">ไม่พบผู้ติดตาม</div>
        <?php endif; ?>
        <!-- Content -->
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>