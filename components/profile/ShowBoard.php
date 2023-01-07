<?php
$db = new Database;
$BoardCard = import('./components/BoardCard');
$getParams = import('wisit-router/getParams');

$usrname = $getParams(0);
$usr = $db->getUser_ByUsername($usrname);
$allBoard = $db->getAllBoard_ByUsrID($usr['usr_id']);
foreach ($allBoard as $board) {
    $BoardCard($board['b_id']);
}
if (sizeof($allBoard) == 0) : ?>
    <div class="heading m-1">ยังไม่มีกระทู้</div>
<?php endif; ?>