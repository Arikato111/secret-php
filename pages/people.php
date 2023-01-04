<?php
$db = import('./Database/db');
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $allUser = $db->query("SELECT * FROM usr WHERE 
    usr_username LIKE '%$search%' OR
    usr_name LIKE '%$search%' 
    ORDER BY usr_id DESC LIMIT 100
    ");
} else {
    $allUser = $db->query("SELECT * FROM usr ORDER BY usr_id DESC LIMIT 100");
}

?>


<title>ผู้คน | aden</title>
<div class="row">
    <div class="col-span-3"></div>
    <div class="col-span-6">
        <?php import('./components/people/SearchPeople'); ?>

        <?php
        while ($usr = fetch($allUser)) : ?>
            <div class="form-control mx-3">
                <a href="/<?php echo $usr['usr_username'] ?? ""; ?>" class="flex items-center px-3">
                    <div>
                        <img class="w-9 rounded-full inline-block" src="/public/profile/<?php echo $usr['usr_img'] ?? ""; ?>" alt="profile image">
                    </div>
                    <div class="px-3">
                        <div><?php echo $usr['usr_name'] ?? ""; ?></div>
                        <div class="text-gray-500 text-sm">@<?php echo $usr['usr_username']; ?></div>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>