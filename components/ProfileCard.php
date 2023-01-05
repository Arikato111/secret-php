<?php
$export = function ($username) {
    $db = import('./Database/db');
    $username = $username;
    $usr_profile = fetch($db->query("SELECT * FROM usr WHERE usr_username = '$username'"));

    if (isset($_POST['follow'])) {
        if (!isset($_SESSION['usr'])) {
            header('Location: /login');
            die;
        }
        if ($db->query("SELECT * FROM follow WHERE 
    fol_atk = {$_SESSION['usr']} AND fol_def = {$_POST['usr_id']}")->num_rows == 0) {
            $date = date('Y-m-d');
            $db->query("INSERT INTO `follow`
        (`fol_id`, `fol_atk`, `fol_def`, `fol_date`) VALUES 
        (NULL, {$_SESSION['usr']}, {$_POST['usr_id']},'$date')");
            header("Refresh:0");
            die;
        } else {
            $db->query("DELETE FROM follow WHERE 
    fol_atk = {$_SESSION['usr']} AND fol_def = {$_POST['usr_id']}");
        }
    }

    if (isset($_POST['deleteProfile'])) {
        $db->query("DELETE FROM usr WHERE usr_username = '$username'");
        unlink('./public/profile/' . $usr_profile['usr_img']);
        if ($_SESSION['usr'] == $usr_profile['usr_id']) {
            header('Location: /login?logout');
            die;
        } else {
            header("Location: /home");
            die;
        }
    }

    if (!$usr_profile) return require('./pages/_error.php');
    if (isset($_POST['editProfile'])) return import('./components/profile/EditProfile');
    if (isset($_POST['editImg'])) return import('./components/profile/EditImg');
    if (isset($_POST['editPassword'])) return import('./components/profile/EditPassword');
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
                <form method="post">
                    <ul class="py-1" aria-labelledby="dropdownButton">
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
                            <form method="post">
                                <button name="deleteProfile" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                            </form>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
        <div class="flex flex-col items-center pb-10">
            <img class="w-24 h-24 mb-3 rounded-full shadow-lg object-cover" src="/public/profile/<?php echo $usr_profile['usr_img'] ?? ""; ?>" alt="Bonnie image" />
            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><?php echo $usr_profile['usr_name']; ?></h5>
            <span class="text-sm text-gray-500 dark:text-gray-400">@<?php echo $usr_profile['usr_username']; ?></span>
            <span class="text-sm text-gray-500 dark:text-gray-400">วันเกิด : <?php echo $usr_profile['usr_date']; ?></span>
            <span class="text-sm text-gray-500 dark:text-gray-400">ที่อยู่ : <?php echo $usr_profile['usr_address']; ?></span>
            <span class="text-sm text-gray-500 dark:text-gray-400">เบอร์โทร : <?php echo $usr_profile['usr_tel']; ?></span>
            <form method="POST" class="flex mt-4 space-x-3 md:mt-6">
                <input type="hidden" name="usr_id" value="<?php echo $usr_profile['usr_id']; ?>">
                <?php if (!isset($_SESSION['usr']) || $_SESSION['usr'] != $usr_profile['usr_id']) : ?>
                    <?php if (isset($_SESSION['usr']) && $db->query("SELECT * FROM follow WHERE 
                    fol_atk = {$_SESSION['usr']} AND fol_def = {$usr_profile['usr_id']}")->num_rows != 0) : ?>
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