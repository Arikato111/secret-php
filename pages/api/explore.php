<?php
$app = import('wisit-express');
$Notfound = import('./components/api/Notfound');
$db = new Database;

$app->origin();

$app->get('*', function ($req, $res) use ($db) {
    $allPost = $db->getAllPost_apiExplore(limit: 100, desc: true, cat_id: 1);
    $res->status(200);
    $res->json($allPost);
});


$app->all('*', $Notfound);
