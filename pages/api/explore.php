<?php
$app = import('wisit-express');
$Notfound = import('./components/api/Notfound');
$db = new Database;

$app->origin();

$app->get('*', function ($req, $res) use ($db) {
    $allPost = $db->getAllPost(limit: 100, desc: true);
    $res->status(200);
    $res->json($allPost);
});


$app->all('*', $Notfound);
