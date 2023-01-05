<?php
$getParams = import('wisit-router/getParams');
$path = $getParams(0);
?>
<div class="overflow-x-auto mt-3 sm:mt-0">

    <aside class="menu-nav">
        <a href="/<?php echo $path; ?>/post" class="menu-item"><img class="inline-block w-7" src="/public/icons/post.svg" alt=""> post</a>
        <a href="/<?php echo $path; ?>/board" class="menu-item"><img class="inline-block w-7" src="/public/icons/question.svg" alt=""> board</a>
        <a href="/<?php echo $path; ?>/follower" class="menu-item"><img class="inline-block w-7" src="/public/icons/follower.svg" alt=""> follower</a>
        <a href="/<?php echo $path; ?>/following" class="menu-item"><img class="inline-block w-7" src="/public/icons/following.svg" alt=""> following</a>
    </aside>
</div>