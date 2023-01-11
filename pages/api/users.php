<?php
$app = import('wisit-express');
$db = new Database;
$app->origin();

$app->get('*', function ($req, $res) use ($db) {
    $allUser = $db->getUser_All(hide_private: true);
    if ($allUser) {
        $res->json($allUser);
    } else {
        echo "NULL";
    }
});

$app->all('*', function ($req, $res) {
    $res->status(400);
    $res->json([
        "staus" => 0,
        "msg" => "bad request",
    ]);
});
