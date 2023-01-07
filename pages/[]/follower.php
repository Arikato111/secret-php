<?php
$getParams = import('wisit-router/getParams');
$db = new Database;
$ProfileCard = import('./components/ProfileCard');
$ProfileBar = import('./components/ProfileBar');
$username = $getParams(0);
$usr_profile = $db->getUser_ByUsername($username);
if (!$usr_profile) return require('./pages/_error.php');
if (isset($_POST['editProfile'])) return import('./components/profile/EditProfile');
if (isset($_POST['editImg'])) return import('./components/profile/EditImg');
if (isset($_POST['editPassword'])) return import('./components/profile/EditPassword');

$AllFollower = $db->findFollow(def: $usr_profile['usr_id']);
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
            <?php echo sizeof($AllFollower) ?? 0; ?>
            คน
        </h3>
        <div class="w-full mx-3">
            <?php foreach ($AllFollower as $fol) {
                $ProfileBar($fol['fol_atk']);
            } ?>
        </div>
        <?php if (sizeof($AllFollower) == 0) : ?>
            <div class="w-full">
                <div class="heading">ไม่พบผู้ติดตาม</div>
            </div>
        <?php endif; ?>
        <!-- Content -->
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>