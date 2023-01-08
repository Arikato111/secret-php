<?php
$export = function ($poll, $replybtn = false) {
    $db = new Database;
    $usr_post = $db->getUser_ByID($poll['usr_id']);
?>
    <div class="form-control mx-3">
        <div class="flex items-center px-3">
            <div>
                <img class="w-9 h-9 object-cover rounded-full inline-block" src="/public/default/admin.jpeg" onerror="this.onerror=null; this.src='/public/default/profile.png'" alt="profile image">
            </div>
            <div class="px-3">
                <div>administrator</div>
                <div class="text-gray-500 text-sm">โพสต์เมื่อ <?php echo $poll['poll_date'] ?? ""; ?></div>
            </div>
        </div>
        <div class="pt-3 px-3">
            <?php echo $poll['poll_name'] ?? ""; ?>
        </div>
        <?php if ($replybtn) : ?>
            <div class="text-right">
                <a href="/poll/<?php echo $poll['poll_id'] ?? ""; ?>" class="btn btn-sm primary">ตอบแบบประเมิน</a>
            </div>
            <?php else: ?>
            <div class="text-right">
                <?php echo $poll['poll_view'] ?? 0; ?> เข้าชม
            </div>
        <?php endif; ?>
    </div>

<?php } ?>