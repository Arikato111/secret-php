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
    <link rel="stylesheet" href="/public/style.css">
    <link rel="stylesheet" href="/public/output.css">
    <link rel="shortcut icon" href="/public/icons/grass.svg" type="image/x-icon">
</head>

<body>
    <?php
    require('./components/Navbar.php');
    /********* Content ***********/
    require('./pages/_main.php');
    /********* Content ***********/
    ?>
    <script src="/public/flowbite.js"></script>

</body>

</html>