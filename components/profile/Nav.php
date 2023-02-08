<?php
$getParams = import('wisit-router/getParams');
$path = $getParams(0);
?>
<div class="menu-aside">

    <aside class="menu-nav">
        <a href="/<?php echo $path; ?>/post" class="menu-item"><img class="inline-block w-7" src="/public/icons/post.svg" alt=""> โพสต์</a>
        <a href="/<?php echo $path; ?>/board" class="menu-item"><img class="inline-block w-7" src="/public/icons/question.svg" alt=""> กระทู้</a>
        <a href="/<?php echo $path; ?>/follower" class="menu-item"><img class="inline-block w-7" src="/public/icons/follower.svg" alt=""> ผู้ติดตาม</a>
        <a href="/<?php echo $path; ?>/following" class="menu-item"><img class="inline-block w-7" src="/public/icons/following.svg" alt=""> กำลังติดตาม</a>
    </aside>
</div>