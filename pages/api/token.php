<?php
$Notfound = import('./components/api/Notfound');
$db = new Database;

Wexpress::post('*', function () use ($db) {
    $token1 = $_POST['token1'] ?? null;
    $token2 = $_POST['token2'] ?? null;
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
});

Wexpress::delete('*', function () use ($db) {
    $token1 = $_POST['token1'] ?? null;
    $token2 = $_POST['token2'] ?? null;
    if ($token1 && $token2) {
        $log = $db->getLog_ByToken($token1, $token2);
        if ($log) {
            $db->deleteLog_ByID($log['log_id'] ?? 0);
            Res::json(['status' => 1, 'message' => 'delete token success']);
        }
    }
    Res::json(['status' => 0, 'message' => 'bad request']);
});

Wexpress::all('*', $Notfound);
