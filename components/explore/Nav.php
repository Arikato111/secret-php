<?php
$db = import('./Database/db');
$CatList = $db->query("SELECT * FROM cat");
?>
<div class="menu-aside">
    <aside class="menu-nav">
        <a href="/explore/" class="menu-item">ทั้งหมด</a>
        <?php while ($cat = fetch($CatList)) { ?>
            <a href="/explore/<?php echo $cat['cat_path']; ?>" class="menu-item"><?php echo $cat['cat_name']; ?></a>
        <?php } ?>
    </aside>
</div>