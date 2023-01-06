<?php
$db = import('./Database/db');
$allMember = $db->query("SELECT * FROM usr ORDER BY usr_id DESC");
$members = fetch_all($allMember);

echo json_encode($members);