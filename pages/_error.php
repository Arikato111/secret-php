<?php
$getParams = import('wisit-router/getParams');
if($getParams(0) == 'api') {
    echo json_encode([
        "status"=> 0,
        "msg"=>"error not found"
    ]);
    die;
}
?>

<title>not found page</title>
<main>
    <div class="text-center mt-5 mx-3">
        <img class="inline-block w-40" src="/public/icons/alert.svg" alt="alert icon">
    </div>
    <div class="text-3xl text-center m-5 text-gray-600">หน้านี้ไม่พร้อมใช้งาน</div>
    <div class="text-center">
        <a class="btn primary" href="/explore/">กลับสู่เว็บไซต์</a>
    </div>
</main>