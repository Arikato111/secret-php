<?php
$db = import('./Database/db');
$CatList = $db->query("SELECT * FROM cat");
?>

<div class="overflow-x-auto mt-3 sm:mt-0">
    <aside class="menu-nav">
        <a href="/board/" class="menu-item">ทั้งหมด</a>
        <?php while ($cat = fetch($CatList)) { ?>
            <a href="/board/<?php echo $cat['cat_path']; ?>" class="menu-item"><?php echo $cat['cat_name']; ?></a>
        <?php } ?>
    </aside>
</div>