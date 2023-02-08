<?php
$getParams = import('wisit-router/getParams');
$db = new Database;
$ProfileCard = import('./components/ProfileCard');
$ProfileBar = import('./components/ProfileBar');
$username = $getParams(0);
$usr_profile = $db->getUser_ByUsername($username);
if (!$usr_profile) return require('./pages/_error.php');

$AllFollower = $db->findFollow(def: $usr_profile['usr_id']);
?>

<title>ผู้ติดตาม | <?php echo $username; ?> | ผู้ติดตาม</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/profile/Nav'); ?>
    </div>
    <div class="col-span-6 flex px-3 flex-col items-center">
        <!-- Content -->
        <?php $ProfileCard($usr_profile); ?>
        <h3 class="heading w-full">มีผู้ติดตาม
            <?php echo sizeof($AllFollower) ?? 0; ?>
            คน
        </h3>
        <div class="w-full mx-3">
            <?php foreach ($AllFollower as $fol) {
                $usr_fol = $db->getUser_ByID($fol['fol_atk']);
                $ProfileBar($usr_fol);
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