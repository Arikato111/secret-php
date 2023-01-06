<?php
$db = import('./Database/db');
if(isset($_POST['createCat'])) {
    $db->query("INSERT INTO `cat`
    (`cat_id`, `cat_name`, `cat_path`) VALUES 
    (NULL,'{$_POST['cat_name']}','{$_POST['cat_path']}')");
    header("Refresh:0");die;
}
?>

<form method="post" class="form-control sm:sticky sm:top-16">
    <input type="text" name="cat_name" placeholder="ชื่อหมวดหมู่" id="" class="input-text" required>
    <input type="text" name="cat_path" placeholder="path directory" id="" class="input-text" reauired>
    <div class="text-right">
        <button name="createCat" class="btn btn-dark">สร้างหมวดหมู่</button>
    </div>
</form>