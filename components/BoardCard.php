<?php
$export = function ($id, $hover = true) {
    $db = new Database;


    if (isset($_POST['deleteBoard'])) {
        $board_id = (int)($_POST['b_id'] ?? 0);
        $board_check = $db->getBoard_ByID($board_id);

        if (!$board_check || !isset($_SESSION['usr'])) {
            getAlert('คำขอไม่ถูกต้อง');
        } elseif ($_SESSION['usr'] != $board_check['usr_id'] && (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin')) {
            getAlert('You have no permission', 'danger');
        } else {
            $db->deleteBoard_ByID($board_id);
            $db->deleteAllBoardDetail_ByBID($board_id);
            header("Refresh:0");
            die;
        }
    }


    $board = $db->getBoard_ByID($id);
    $usr_post = $db->getUser_ByID($board['usr_id']);
    $cat = $db->getCate_ByID($board['cat_id']);
?>
    <div class="form-control z-0 relative mx-3">
        <?php if (
            isset($_SESSION['usr']) && $_SESSION['usr'] == $usr_post['usr_id']
            || (isset($_SESSION['status']) && $_SESSION['status'] == 'admin')
        ) : ?>
            <!-- Dropdown menu -->
            <div class="text-end px-3">
                <button id="dropdownPost" data-dropdown-toggle="dropdownpost<?php echo $board['b_id']; ?>" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                </button>
            </div>
            <div id="dropdownpost<?php echo $board['b_id']; ?>" class="hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
                <form method="post">
                    <input type="hidden" name="b_id" value="<?php echo $board['b_id']; ?>">
                    <ul class="py-1" aria-labelledby="dropdownPost">
                        <li>
                            <button name="deleteBoard" class="text-rose-600 block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">ลบ</button>
                        </li>
                    </ul>
                </form>
            </div>
            <!-- Dropdown menu -->
        <?php endif; ?>
        <div class="flex items-center px-3">
            <div>
                <img class="w-9 h-9 rounded-full object-cover inline-block" src="/public/profile/<?php echo $usr_post['usr_img'] ?? ""; ?>" onerror="this.onerror=null; this.src='/public/default/profile.png'" alt="profile image">
            </div>
            <div class="px-3">
                <a class="hover:underline" href="/<?php echo $usr_post['usr_username'] ?? ""; ?>"><?php echo $usr_post['usr_name'] ?? "ไม่พบผู้ใช้งานนี้"; ?></a>
                <div class="text-gray-500 text-sm">โพสต์เมื่อ <?php echo $board['b_date'] ?? ""; ?> ⦁ <?php echo $cat['cat_name'] ?? ""; ?></div>
            </div>
        </div>
        <?php if ($hover) : ?>
            <a href="/board/<?php echo $board['b_id'] ?? ""; ?>">
            <?php endif; ?>
            <div class="hover:bg-gray-100 text-xl rounded-lg p-3 px-3 mt-3 font-bold">
                <?php echo $board['b_name']; ?>
            </div>
            <div class="text-right">
                <span class="mx-3">
                    <?php echo $db->getBoardDetailCount_ByBID($board['b_id']) ?? 0; ?>
                    คำตอบ
                </span>
                <span>
                    <?php echo $board['b_view'] ?? 0; ?> เข้าชม
                </span>
            </div>
            <?php if ($hover) : ?>
            </a>
        <?php endif; ?>
    </div>
<?php } ?>