<?php

$getParams = import('wisit-router/getParams');

if (isset($_SESSION['usr'])) {
    (function () {
        $db = new Database;
        if (
            ($_COOKIE['token1'] ?? false) ||
            ($_COOKIE['token2'] ?? false)
        ) {
            $log = $db->getLog_ByToken($_COOKIE['token1'], $_COOKIE['token2']);
            if ($log && $log['usr_id'] == $_SESSION['usr']) {
                return 1;
            }
        }
        session_unset();
        header('Location: /login?logout');
    })();
} elseif (isset($_COOKIE['token1']) && isset($_COOKIE['token2'])) {
    (function () {
        $db = new Database;
        $log = $db->getLog_ByToken($_COOKIE['token1'], $_COOKIE['token2']);
        $usr = $db->getUser_ByID($log['usr_id']);
        if ($usr) {
            $_SESSION['usr'] = $usr['usr_id'];
            $_SESSION['status'] = $usr['usr_status'];
            header('Refresh:0');
            die;
        }
    })();
}

if ($getParams(0) == 'admin') {
    if (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin') {
        return require('./pages/_error.php');
    } else {
        (function () {
            $db = new Database;
            if (!$db->getUser_ByID($_SESSION['usr'])) return require('./pages/_error.php');
        })();
    }
}

$spelte = import('spelte');
$spelte();
