<?php
$db = new Database;
Wexpress::get('*', function () use ($db) {
    $header = Req::header();
    $token1 = $header['token1'] ?? null;
    $token2 = $header['token2'] ?? null;
    if ($token1 && $token2) {
        $log = $db->getLog_ByToken($token1, $token2);
        if ($log) {
            $usr = $db->getUser_ByID($log['usr_id']);
            if ($usr) {
                unset($usr['usr_password']);
                Res::json(['status' => 1, 'message' => 'load token succes', 'usr' => $usr]);
                die;
            }
        }
    }
    Res::json(['status' => 0, 'message' => 'bad request']);
    die;
});
