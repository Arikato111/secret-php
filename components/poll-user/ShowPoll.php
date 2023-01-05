<?php
$db = import('./Database/db');

if (isset($_GET['search'])) {
    $search = str_replace("'", '', $_GET['search']);
    $allPoll = $db->query("SELECT * FROM poll
    WHERE `poll_name` LIKE '%$search%' ORDER BY poll_id DESC LIMIT 30");
} else {
    $allPoll = $db->query("SELECT * FROM poll ORDER BY poll_id DESC LIMIT 30");
}
while ($poll = fetch($allPoll)) :
    $usr_post = fetch($db->query("SELECT * FROM usr WHERE usr_id = {$poll['usr_id']} LIMIT 1"));
?>
    <div class="form-control mx-3">
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
            <a href="/poll/<?php echo $poll['poll_id'] ?? ""; ?>" class="btn btn-sm primary">ตอบแบบประเมิน</a>
        </div>
    </div>

<?php endwhile;
if($allPoll->num_rows == 0): ?>
<div class="heading">ไม่พบแบบประเมิน</div>
<?php endif; ?>