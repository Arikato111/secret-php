<?php 
$db = import('./Database/db');
$getParams = import('wisit-router/getParams');
$cat = $getParams(1);
$CatData = fetch($db->query("SELECT * FROM cat WHERE cat_name = '$cat'"));
if(!$CatData) return import('./pages/_error');
?>


<title>explore | aden</title>
<main class="py-3">
    <div class="row">
        <div class="col-span-3">
            <?php import('./components/explore/Nav'); ?>
        </div>
        <div class="col-span-6 bg-yellow-400">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius eveniet cupiditate animi doloribus, obcaecati quis deleniti, ab vitae totam maiores aspernatur. Ex quasi esse rerum praesentium earum sapiente facere voluptatum!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius eveniet cupiditate animi doloribus, obcaecati quis deleniti, ab vitae totam maiores aspernatur. Ex quasi esse rerum praesentium earum sapiente facere voluptatum!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius eveniet cupiditate animi doloribus, obcaecati quis deleniti, ab vitae totam maiores aspernatur. Ex quasi esse rerum praesentium earum sapiente facere voluptatum!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius eveniet cupiditate animi doloribus, obcaecati quis deleniti, ab vitae totam maiores aspernatur. Ex quasi esse rerum praesentium earum sapiente facere voluptatum!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius eveniet cupiditate animi doloribus, obcaecati quis deleniti, ab vitae totam maiores aspernatur. Ex quasi esse rerum praesentium earum sapiente facere voluptatum!
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius eveniet cupiditate animi doloribus, obcaecati quis deleniti, ab vitae totam maiores aspernatur. Ex quasi esse rerum praesentium earum sapiente facere voluptatum!
        </div>
        <div class="col-span-3">
            <?php import('./components/NavContact'); ?>
        </div>
    </div>
</main>