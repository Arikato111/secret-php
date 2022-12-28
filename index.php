<?php
require('./modules/use-import/main.m.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</body>

</html>