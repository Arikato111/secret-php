<?php
$db = new Database;
$CatList = $db->getAllCategory();
?>
<div class="menu-aside">
    <aside class="menu-nav">
        <a href="/explore/" class="menu-item">
            <img class="inline-block w-7 h-7" onerror="this.onerror=null;this.style.display='none'" src="/public/default/all-icon.svg" alt="">
            ทั้งหมด</a>
        <?php foreach ($CatList as $cat) { ?>
            <a href="/explore/<?php echo $cat['cat_path']; ?>" class="menu-item">
                <img class="inline-block w-7 h-7" onerror="this.onerror=null;this.style.display='none'" src="/public/cat/<?php echo $cat['cat_img'] ?? "" ?>" alt="">
                <?php echo $cat['cat_name']; ?>
            </a>
        <?php } ?>
    </aside>
</div>