<?php
date_default_timezone_set("Asia/Bangkok");
header("Cache-Control: no-cache, no-store, must-revalidate");
ob_start();
session_start();
require('./modules/use-import/main.m.php');
require('./Database/Database.php');
require('./components/lib/getAlert.php');
require('./components/lib/htmlchar.php');
require('./components/lib/deleteUser.php');


$getParams = import('wisit-router/getParams');
// use for api
if ($getParams(0) == 'api') {
    return require('./pages/_main.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="title" content="aden" />
    <meta name="description" content="social media and open source project" />

    <meta property="og:url" content="https://aden.anytion.com" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="aden" />
    <meta property="og:description" content="social media and open source project" />
    <meta property="og:image" content="https://aden.anytion.com/public/default/logo.svg" />

    <link rel="shortcut icon" href="/public/default/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="/public/style.css">
    <link rel="stylesheet" href="/public/output.css">
</head>

<body>
    <?php
    require('./components/Navbar.php');
    /********* Content ***********/
    require('./pages/_main.php');
    /********* Content ***********/
    ?>
    <script src="/public/flowbite.js"></script>
    <script src="/public/script.js"></script>
</body>

</html>