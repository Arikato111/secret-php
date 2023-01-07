<?php
$getParams = import('wisit-router/getParams');
$db = new Database;
$ProfileBar = import('./components/ProfileBar');
$ProfileCard = import('./components/ProfileCard');
$username = $getParams(0);
$usr_profile = $db->getUser_ByUsername($username);

if (!$usr_profile) return require('./pages/_error.php');
if (isset($_POST['editProfile'])) return import('./components/profile/EditProfile');
if (isset($_POST['editImg'])) return import('./components/profile/EditImg');
if (isset($_POST['editPassword'])) return import('./components/profile/EditPassword');

$AllFollowing = $db->findFollow(atk: $usr_profile['usr_id']);
?>

<title><?php echo $username; ?> | กำลังติดตาม</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/profile/Nav'); ?>
    </div>
    <div class="col-span-6 flex px-3 flex-col items-center">
        <!-- Content -->
        <?php $ProfileCard($username); ?>
        <h3 class="heading w-full">
            กำลังติดตาม
            <?php echo sizeof($AllFollowing) ?? 0; ?>
            คน
        </h3>
        <div class="w-full mx-3">
            <?php foreach ($AllFollowing as $fol) {
                $ProfileBar($fol['fol_def']);
            } ?>
        </div>
        <?php if (sizeof($AllFollowing) == 0) : ?>
            <div class="heading text-lg w-full mb-5"><?php echo $usr_profile['usr_name'] ?? ""; ?> ยังไม่ได้ติดตามใคร</div>
        <?php endif; ?>
        <!-- Content -->
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>