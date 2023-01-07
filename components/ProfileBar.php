<?php
$export = function ($id) {
    $db = new Database;
    $usr = $db->getUser_ByID($id);
     ?>

    <div class="form-control w-full text-zinc-800">
        <a href="/<?php echo $usr['usr_username'] ?? ""; ?>" class="flex items-center px-3">
            <div>
                <img class="w-9 h-9 rounded-full inline-block object-cover" src="/public/profile/<?php echo $usr['usr_img'] ?? ""; ?>" onerror="this.onerror=null;this.src='/public/default/profile.png'"  alt="profile image">
            </div>
            <div class="px-3">
                <div><?php echo $usr['usr_name'] ?? "ไม่พบฝู้ใช้นี้"; ?></div>
                <div class="text-gray-500 text-sm">@<?php echo $usr['usr_username'] ?? "ไม่พบผู้ใช้นี้"; ?></div>
            </div>
        </a>
    </div>
<?php }; ?>