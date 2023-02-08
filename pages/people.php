<?php
$ProfileBar = import('./components/ProfileBar');
$db = new Database;
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $allUser = $db->searchUser($search);
} else {
    $allUser = $db->getUser_All(desc: true);
}

?>


<title>ผู้คน | aden</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/people/SearchPeople'); ?>
    </div>
    <div class="col-span-6 text-zinc-800">
        <div class="mx-3">

            <?php
        foreach ($allUser as $usr) {
            $ProfileBar($usr);
        }
        if (sizeof($allUser) == 0) : ?>
            <div class="heading">ไม่พบผู้ใช้งาน</div>
            <?php endif; ?>
        </div>
            
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>