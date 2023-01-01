<?php

$getParams = import('wisit-router/getParams');
if($getParams(0) == 'admin') {
    if(!isset($_SESSION['status']) || $_SESSION['status'] != 'admin' ) {
        return require('./pages/_error.php');
    }
}

$spelte = import('spelte');
$spelte();