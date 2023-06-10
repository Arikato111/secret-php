<?php
// this api working only the same domain
// ***no front-end support.***
$Notfound = import('./components/api/Notfound');
$db = new Database;

Wexpress::post('*', function () use ($db) {
    $googleToken = $_POST['google-token'] ?? "";
    if ($googleToken ?? false) {
        $usr = $db->getUser_ByGoogle($googleToken);
        if ($usr ?? false) {
            $_SESSION['usr'] = $usr['usr_id'];
            $_SESSION['status'] = $usr['usr_status'];
            $db->insertLog($usr['usr_id']);
            Res::status(200);
            Res::json([
                'status' => 1,
                'message' => 'login success'
            ]);
            return;
        } else {
            Res::status(200);
            Res::json([
                'status' => 0,
                'message' => 'not found user',
                'usr' => $usr
            ]);
            return;
        }
    }
    Res::status(200);
    Res::json([
        'status' => 0,
        'message' => 'bad request'
    ]);
});

Wexpress::all('*', $Notfound);
