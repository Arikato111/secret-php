<?php
$db = import('./Database/db');
?>

<title>กระดานสนทนา | aden</title>
<div class="row">
    <div class="col-span-3">
        <?php import('./components/board/Nav'); ?>
    </div>
    <div class="col-span-6 text-zinc-800">
        <?php import('./components/board/CreateBoard'); ?>
        <?php import('./components/board/ShowBoard'); ?>
    </div>
    <div class="col-span-3">
        <?php import('./components/NavContact'); ?>
    </div>
</div>