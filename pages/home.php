<?php
if (!isset($_SESSION['usr']) || empty($_SESSION['usr'])) return import('./pages/_error');
$db = import('./Database/db');
$Post = import('./components/Post');
$db = new Database;
$feedPost = $db->myFeed($_SESSION['usr']);
?>

<title>หน้าหลัก | aden</title>
<div class="row">
    <div class="col-span-3">
        <div class="menu-aside">
            <aside class="menu-nav">
                <a class="menu-item" href="/create-post">สร้างโพสต์</a>
                <a class="menu-item" href="#top">ค้นพบ <?php echo sizeof($feedPost); ?> โพสต์</a>
            </aside>
        </div>
    </div>
    <div class="col-span-6">
        <div class="my-5">
            <?php foreach ($feedPost as $fp) :
                $Post($fp['post_id']); ?>
            <?php endforeach; ?>
        </div>
        <?php if (sizeof($feedPost) == 0) : ?>
            <h3 class="heading">คุณยังไม่มีการติดตาม</h3>
            <div class="form-control mx-3 ">
                <a class="btn primary text-xl" href="/people">ค้นหาผู้คนเพิ่มเติม</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>