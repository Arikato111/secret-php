<?php
$db = import('./Database/db');
$getParams = import('wisit-router/getParams');
$p_id = (int) $getParams();

$db->query("UPDATE poll SET `poll_view`=`poll_view`+1 WHERE poll_id = $p_id LIMIT 1");

$allPoll = $db->query("SELECT * FROM poll WHERE poll_id = $p_id LIMIT 1");
$poll = fetch($allPoll);
$usr_post = fetch($db->query("SELECT * FROM usr WHERE usr_id = {$poll['usr_id']} LIMIT 1"));
?>
<div class="form-control">
    <div class="flex items-center px-3">
        <div>
            <img class="w-9 rounded-full inline-block" src="/public/profile/<?php echo $usr_post['usr_img'] ?? ""; ?>" alt="profile image">
        </div>
        <div class="px-3">
            <a class="hover:underline" href="/<?php echo $usr_post['usr_username']; ?>"><?php echo $usr_post['usr_name'] ?? ""; ?></a>
            <div class="text-gray-500 text-sm">โพสต์เมื่อ <?php echo $poll['poll_date'] ?? ""; ?></div>
        </div>
    </div>
    <div class="pt-3 px-3">
        <?php echo $poll['poll_name'] ?? ""; ?>
    </div>
    <div class="text-right">
        <?php echo $poll['poll_view'] ?? 0; ?> เข้าชม
    </div>
</div>