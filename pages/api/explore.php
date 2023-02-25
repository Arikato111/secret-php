<?php
$Notfound = import('./components/api/Notfound');
$db = new Database;

Wexpress::get('*', function () use ($db) {
    if ($_GET['cat'] ?? false) {
        $cat = $db->getCate_ByPath($_GET['cat']);
        if (!$cat) {
            $cat = ['cat_id' => 0];
        }
        $allPost = $db->getAllPost_apiExplore(limit: 100, desc: true, cat_id: $cat['cat_id'] ?? 0);
    } else {
        $allPost = $db->getAllPost_apiExplore(limit: 100, desc: true);
    }
    Res::status(200);
    Res::json($allPost);
});

Wexpress::all('*', $Notfound);
