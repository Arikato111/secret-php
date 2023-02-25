<?php
$Notfound = import('./components/api/Notfound');
$db = new Database;

Wexpress::get('*', function () use ($db) {
    $category = $db->getAllCategory();
    Res::json($category);
});

Wexpress::all('*', $Notfound);