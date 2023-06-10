<?php
$db = new Database();
$user = $db->getUser_ByID($_SESSION['usr'] ?? 0);

?>
<div class="form-control w-full items-center">
    <?php if ($user['google-token'] ?? false) { ?>
        <button class="text-green-600 border-green-500 flex justify-center items-center"><img class="w-7 mx-2" src="/public/default/google-logo.png" alt="google logo">เชื่อมต่อแล้ว</button>
    <?php } else { ?>
        <button id="getConnectGoogle" class="text-red-500 flex justify-center items-center"><img class="w-7 mx-2" src="/public/default/google-logo.png" alt="google logo">ยังไม่เชื่อมต่อ</button>
    <?php } ?>
</div>

<script type="module" src="/public/google-login.js"></script>