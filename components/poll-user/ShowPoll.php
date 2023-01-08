<?php
$db = new Database;
$PollCard = import('./components/PollCard');

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $allPoll = $db->searchPoll($_GET['search'], limit: 50, desc: true);
} else {
    $allPoll = $db->getAllPoll(limit: 50, desc: true);
}
foreach ($allPoll as $poll) {
    $PollCard($poll, replybtn: true);
}
if (sizeof($allPoll) == 0) : ?>
    <div class="heading">ไม่พบแบบประเมิน</div>
<?php endif; ?>