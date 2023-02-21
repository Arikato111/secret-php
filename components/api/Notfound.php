<?php
$Notfound = function ($req, $res) {
    $res->status(400);
    $res->json([
        "staus" => 0,
        "msg" => "bad request",
    ]);
};

$export = $Notfound;