<?php
if(isset($_POST['regis'])) {
    echo "hello";
    return;
}
 ?>

<title>สมัครสมาชิก - aden</title>
<main class="frame">
    <form class="form-control " method="post">
        <h3 class="text-4xl text-center p-3">สมัครสมาชิก</h3>
        <input class="input-text" type="text" name="usr_name" placeholder="ชื่อ - สกุล" required>
        <textarea class="input-text" name="usr_address" placeholder="ที่อยู่" required></textarea>
        <div class="flex">
            <label class="input-label" for="">วันเกิด</label>
            <input class="input-text" type="date" name="" id="">    
        </div>
        <input class="input-text" type="email" name="usr_email" placeholder="อีเมล" required>
        <input class="input-text" type="text" name="usr_tel" placeholder="เบอร์โทร" required>
        <input class="input-text" type="text" name="usr_username" placeholder="username" required>
        <input class="input-text" type="password" name="usr_password" placeholder="รหัสผ่าน" required>
        <input class="input-text" type="password" name="usr_password1" placeholder="ยืนยันรหัสผ่าน" required>
        <button name="regis" class="bg-blue-600 text-white py-2 px-3 rounded-lg">สมัคร</button>
    </form>
    <br>
</main>