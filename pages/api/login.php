<?php
$Notfound = import('./components/api/Notfound');
$db = new Database;

Wexpress::post('*', function () use ($db) {
    $body = Req::body();
    $body = json_decode($body, true);
    $username = $body['username'] ?? null;
    $password = $body['password'] ?? null;
    if (
        !($username ?? false) ||
        !($password ?? false)
    ) {
        Res::json(['status' => 0, 'message' => 'bad request']);
        die;
    }

    $password = md5($password ?? "");
    $usr = $db->getLogin($username, $password);
    if ($usr) {
        $token = $db->createToken($usr['usr_id']);
        if ($token) {
            Res::json(['status' => 1, 'token1' => $token['token1'], 'token2' => $token['token2']]);
        } else {
            Res::json(['status' => 0, 'message' => 'create token faild']);
        }
    } else {
        Res::json(['status' => 0, 'message' => 'ชื่อผู้ใช้หรือระหัสผ่านไม่ถูกต้อง']);
    }
});

Wexpress::all('*', $Notfound);
