<?php
if (!isset($_SESSION['usr']) || empty($_SESSION['usr'])) return import('./pages/_error');
$Post = import('./components/Post');
$db = new Database;
$feedPost = $db->myFeed($_SESSION['usr']);
?>

<title>หน้าหลัก | aden</title>
<div class="row">
    <div class="col-span-3">
        <div class="menu-aside">
            <aside class="menu-nav">
                <a class="menu-item text-blue-600" href="/create-post">
                    <img class="inline-block w-7 h-7" onerror="this.onerror=null;this.style.display='none'" src="/public/default/create-post.svg" alt="">
                    สร้างโพสต์</a>
                <a class="menu-item" href="#top">ค้นพบ <?php echo sizeof($feedPost); ?> โพสต์</a>
            </aside>
        </div>
    </div>
    <div class="col-span-6">
        <div class="my-5">
            <?php foreach ($feedPost as $fp) :
                $Post($fp); ?>
            <?php endforeach; ?>
        </div>
        <?php if (sizeof($feedPost) == 0) : ?>
            <h3 class="heading mx-3">ยังไม่มีโพสต์ใหม่</h3>
            <div class="form-control mx-3 ">
                <a class="btn primary text-xl" href="/people">ค้นหาผู้คนเพิ่มเติม</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>