<?php 
$db = import('./Database/db');
$CatList = $db->query("SELECT * FROM cat");
?>

<aside class="menu-nav">
    <?php while($cat = fetch($CatList)) { ?>
    <a href="/explore/<?php echo $cat['cat_path']; ?>" class="menu-item"><?php echo $cat['cat_name']; ?></a>
    <?php } ?>
</aside>