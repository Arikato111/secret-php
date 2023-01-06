<?php
$db = new Database;
$allUser = $db->getUser_All(hide_private: true);
if ($allUser) {
    echo json_encode($allUser, JSON_PRETTY_PRINT);
} else {
    echo "NULL";
}
