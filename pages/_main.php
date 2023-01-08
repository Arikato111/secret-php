<?php

$getParams = import('wisit-router/getParams');
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
