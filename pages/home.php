<?php
if (!isset($_SESSION['usr'])) return import('./pages/_error');
$db = import('./Database/db');
$Post = import('./components/Post');

$feedPost = [];
$your_follow = $db->query("SELECT * FROM follow WHERE fol_atk = {$_SESSION['usr']}");
$post_size = $your_follow->num_rows == 0 ? 0 : 50 / $your_follow->num_rows;
while ($fol = fetch($your_follow)) {
    $getPost = $db->query("SELECT * FROM post WHERE post_usr_id = {$fol['fol_def']} LIMIT $post_size");
    while ($p = fetch($getPost)) {
        array_push($feedPost, $p);
    }
}
array_multisort(array_column($feedPost, 'post_id'), SORT_DESC, $feedPost);
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
        <?php if ($your_follow->num_rows == 0) : ?>
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