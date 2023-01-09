<?php
$export = function ($usr_profile) {
    $db = new Database;

    if (isset($_POST['follow'])) {
        $atk_id = $_SESSION['usr'];
        $def_id = (int) ($_POST['usr_id'] ?? 0);
        if (!isset($_SESSION['usr'])) {
            header('Location: /login');
            die;
        }
        if (!$db->getUser_ByID($def_id)) {
            getAlert('ไม่พบผู้ใช้', 'danger');
        } elseif ($db->isFollow($atk_id, $def_id)) {
            $db->deleteFollow($atk_id, $def_id);
            header("Refresh:0");
            die;
        } else {
            $db->insertFollow($atk_id, $def_id);
            header("Refresh:0");
            die;
        }
    }

    if (isset($_POST['deleteProfile'])) {

        if (!isset($_SESSION['usr'])) {
        } elseif ($_SESSION['usr'] != $usr_profile['usr_id']) {
        } else {
            deleteUser($_SESSION['usr']);
            header('Location: /login?logout');
            die;
        }
    }

    if (!$usr_profile) return require('./pages/_error.php');
    if ($_SESSION['usr'] ?? false) {
        if (isset($_POST['editProfile'])) return import('./components/profile/EditProfile');
        if (isset($_POST['editImg'])) return import('./components/profile/EditImg');
        if (isset($_POST['editPassword'])) return import('./components/profile/EditPassword');
        if (isset($_POST['log'])) return import('./components/profile/Log');
    }
?>


    <!-- Content -->

    <div class="w-full my-5 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-end px-4 pt-4">
            <?php if (isset($_SESSION['usr']) && $_SESSION['usr'] == $usr_profile['usr_id']) : ?>
                <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                </button>
            <?php endif; ?>
            <!-- Dropdown menu -->
            <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
                <ul class="py-1" aria-labelledby="dropdownButton">
                    <form method="post">
                        <li>
                            <button name="editImg" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">เปลี่ยนรูปโปรไฟล์</button>
                        </li>
                        <li>
                            <button name="editProfile" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">แก้ไขข้อมูล</button>
                        </li>
                        <li>
                            <button name="editPassword" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">เปลี่ยนรหัสผ่าน</button>
                        </li>
                        <li>
                            <button name="log" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">ประวัติการเข้าสู่ระบบ</button>
                        </li>
                    </form>
                    <li>
                        <form method="post" onsubmit="return confirm('ยืนยันการลบบัญชีของคุณ \n หากคุณลบบัญชี ข้อมูลทั้งหมดที่เกี่ยวกับคุณจะถูกลบไปด้วย คิดดีๆ ก่อนนะ');">
                            <button name="deleteProfile" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col items-center pb-10">
            <img class="w-24 h-24 mb-3 rounded-full shadow-lg object-cover" src="/public/profile/<?php echo $usr_profile['usr_img'] ?? ""; ?>" onerror="this.onerror=null; this.src='/public/default/profile.png'" alt="Bonnie image" />
            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><?php echo $usr_profile['usr_name']; ?></h5>
            <span class="text-sm text-gray-500 dark:text-gray-400">@<?php echo $usr_profile['usr_username']; ?></span>
            <div class="mx-10 px-3">
                <span class="text-sm text-gray-500 dark:text-gray-400">วันเกิด : <?php echo $usr_profile['usr_date']; ?></span>
                <span class="text-sm text-gray-500 dark:text-gray-400">ที่อยู่ : <?php echo $usr_profile['usr_address']; ?></span>
                <span class="text-sm text-gray-500 dark:text-gray-400">เบอร์โทร : <?php echo $usr_profile['usr_tel']; ?></span>
            </div>
            <div class="mx-10 text-sm p-3 border-zinc-300 rounded-lg">
                <?php echo $usr_profile['usr_bio'] ?? ""; ?>
            </div>
            <form method="POST" class="flex mt-4 space-x-3 md:mt-6">
                <input type="hidden" name="usr_id" value="<?php echo $usr_profile['usr_id']; ?>">
                <?php if (!isset($_SESSION['usr']) || $_SESSION['usr'] != $usr_profile['usr_id']) : ?>
                    <?php if ($db->isFollow($_SESSION['usr'] ?? 0, $usr_profile['usr_id'] ?? 0) != 0) : ?>
                        <button name="follow" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <img class="w-6" src="/public/icons/right.svg" alt="right icon">
                            ติดตามแล้ว</button>
                    <?php else : ?>
                        <button name="follow" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            ติดตาม</button>
                    <?php endif; ?>
                <?php endif; ?>
                <a class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">
                    <img class="w-5 mx-1" src="/public/icons/share.svg" alt="share icon">
                    share
                </a>
            </form>
        </div>
    </div>

    <!-- Content -->
<?php }; ?>