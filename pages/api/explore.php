<?php
$app = import('wisit-express');
$Notfound = import('./components/api/Notfound');
$db = new Database;

$app->origin();

$app->get('*', function ($req, $res) use ($db) {
    if ($_GET['cat'] ?? false) {
        $cat = $db->getCate_ByPath($_GET['cat']);
        if (!$cat) {
            $cat = ['cat_id' => 0];
        }
        $allPost = $db->getAllPost_apiExplore(limit: 100, desc: true, cat_id: $cat['cat_id'] ?? 0);
    } else {
        $allPost = $db->getAllPost_apiExplore(limit: 100, desc: true);
    }
    $res->status(200);
    $res->json($allPost);
});


$app->all('*', $Notfound);
