<?php
function getAlert($text, $status = 'base') {
    $color = $status == 'base'? "text-black" : 
        ($status == 'success'? "text-green-500": "text-red-400");
?>
<div id="getAlert" class="fixed top-0 left-0 my-5 z-30 w-full mt-16 text-center">
    <div class="row">
        <div class="col-span-4"></div>
        <div class="col-span-4 px-3">
            <div class=" text-xl z-10 bg-white drop-shadow-xl shadow-zinc-300 p-3 rounded-lg <?php echo $color; ?>">
                <?php echo $text; ?>
            </div>
        </div>
        <div class="col-span-4"></div>
    </div>
</div>
<script>
    setTimeout(() => {
        document.getElementById("getAlert").innerHTML = '';
    }, 2000);
</script>
<?php
}

function fetch($result) {
    return mysqli_fetch_assoc($result);
}

function fetch_all($result) {
    return mysqli_fetch_all($result, 1);
}