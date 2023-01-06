<?php
$db = import('./Database/db');
$allMember = $db->query("SELECT 
`usr_name`, `usr_address`,
`usr_date`, `usr_email`,
`usr_tel`, `usr_username`,
`usr_regis_date`, `usr_img`
 FROM `usr` ORDER BY usr_id DESC");
$members = fetch_all($allMember);

echo json_encode($members);
