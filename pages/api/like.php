<?php

Wexpress::post('*', function () {
    $body = Req::body();
    $body = json_decode($body);
    if (!($_SESSION['usr'] ?? false) || !($body->post ?? false)) {
        Res::json([
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
        Res::json([
            'status' => 1,
            'isLike' => $isLike
        ]);
    }
});

Wexpress::all('*', function () {
    Res::status(400);
    Res::json([
        "staus" => 0,
        "msg" => "bad request",
    ]);
});
