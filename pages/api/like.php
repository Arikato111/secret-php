<?php
$app =  import('wisit-express');

$app->post('*', function ($req, $res) {
    $body = $req->body();
    $body = json_decode($body);
    if (!($_SESSION['usr'] ?? false) || !($body->post ?? false)) {
        $res->json([
            'status' => 0,
            'msg' => 'you are not login'
        ]);
    } else {
        $db = new Database;
        $post_id = (int) $body->post;
        if ($db->isLikePost($post_id, $_SESSION['usr'])) {
            $db->deleteLikePost($post_id, $_SESSION['usr']);
            $isLike = false;
        } else {
            $db->insertLikePost($post_id, $_SESSION['usr']);
            $isLike = true;
        }
        $res->json([
            'status' => 1,
            'isLike' => $isLike
        ]);
    }
});

$app->all('*', function ($req, $res) {
    $res->status(400);
    $method = $_SERVER['REQUEST_METHOD'];
    $res->json([
        "staus" => 0,
        "msg" => "bad request",
        "method" => $method
    ]);
});
