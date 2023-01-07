<?php
$db = new Database;
$BoardCard = import('./components/BoardCard');
$getParams = import('wisit-router/getParams');


$cat = $getParams();
if ($cat) {
    $cate = $db->getCate_ByPath($cat);
    $allBoard = $db->getAllBoard(limit: 1000, desc: true, cat: $cate['cat_id']);
} else {
    $allBoard = $db->getAllBoard(desc: true);
}
foreach ($allBoard as $board) {
    $BoardCard($board['b_id']);
}
if (sizeof($allBoard) == 0) : ?>
    <div class="heading text-lg mx-3">ยังไม่มีกระทู้ในหมวดหมู่นี้</div>
    <div class="form-control">
        <a class="btn primary" href="/board/">ดูกระทู้ทั้งหมด</a>
    </div>
<?php endif; ?>