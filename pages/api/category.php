<?php
$app = import('wisit-express');
$Notfound = import('./components/api/Notfound');
$db = new Database;

$app->origin();

$app->get('*', function ($req,$res) use ($db) {
    $category = $db->getAllCategory();
    $res->json($category);
});

$app->all('*', $Notfound);