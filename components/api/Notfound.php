<?php
$Notfound = function ($req, $res) {
    $res->status(400);
    $res->json([
        "status" => 0,
        "message" => "bad request",
    ]);
};

$export = $Notfound;