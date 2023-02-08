<?php
$db = new Database;
$getParams = import('wisit-router/getParams');
$b_id = (int) $getParams();

if (isset($_POST['deleteBD'])) {
    $bd_id = (int)($_POST['bd_id'] ?? 0);
    $boardDetail = $db->getBoardDetail_ByID($bd_id);

    if (!isset($_SESSION['usr']) || empty($_SESSION['usr'])) {
        getAlert('กรุณาเข้าสู่ระบบเพื่อใช้งาน', 'danger');
    } elseif (!$board || $boardDetail['usr_id'] != $_SESSION['usr'] && (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin')) {
        getAlert('You have no permission', 'danger');
    } else {
        $db->deleteBoardDetail_ByID($bd_id);
        header("Refresh:0");
        die;
    }
}

$allBD = $db->getAllBoardDetail(desc: true);
$allBD = $db->getAllBoardDetail_ByBID(b_id: $b_id, desc: true, limit: 200);
foreach ($allBD as $bd) :
    $usr_post = $db->getUser_ByID($bd['usr_id']);
    $id = rand();
?>
    <div class="form-control mx-3">
        <?php if (
            isset($_SESSION['usr']) && $_SESSION['usr'] == $usr_post['usr_id']
            || (isset($_SESSION['status']) && $_SESSION['status'] == 'admin')
        ) : ?>
            <!-- Dropdown menu -->
            <div class="text-end px-3">
                <button id="dropdownPost" data-dropdown-toggle="dropdownpost<?php echo $id; ?>" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                </button>
            </div>
            <div id="dropdownpost<?php echo $id; ?>" class="z-30 hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
                <form method="post">
                    <input type="hidden" name="bd_id" value="<?php echo $bd['bd_id'] ?? 0; ?>">
                    <ul class="py-1" aria-labelledby="dropdownPost">
                        <li>
                            <button name="deleteBD" class="text-rose-600 block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">ลบ</button>
                        </li>
                    </ul>
                </form>
            </div>
            <!-- Dropdown menu -->
        <?php endif; ?>

        <div class="flex items-center px-3">
            <div>
                <img class="w-9 h-9 rounded-full inline-block" src="/public/profile/<?php echo $usr_post['usr_img'] ?? ""; ?>" onerror="this.onerror=null; this.src='/public/default/profile.png'" alt="profile image">
            </div>
            <div class="px-3">
                <a class="hover:underline" href="/<?php echo $usr_post['usr_username'] ?? ""; ?>"><?php echo $usr_post['usr_name'] ?? "ไม่พบผู้ใช้งานนี้"; ?></a>
                <div class="text-gray-500 text-sm">โพสต์เมื่อ <?php echo $bd['bd_date'] ?? ""; ?> </div>
            </div>
        </div>
        <pre class="whitespace-pre-wrap break-words p-3 text-lg font-bold"><?php echo $bd['bd_name']; ?></pre>
    </div>
<?php endforeach; ?>