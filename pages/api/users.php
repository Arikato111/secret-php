<?php
$Notfound = import('./components/api/Notfound');
$db = new Database;

Wexpress::get('*', function () use ($db) {
    $allUser = $db->getUser_All(hide_private: true, desc: true);
    if ($allUser) {
        Res::json($allUser);
    } else {
        Res::json([]);
    }
});

Wexpress::all('*', $Notfound);
