<?php
$getParams = import('wisit-router/getParams');
$db = new Database;
$post_id = $getParams(1);

if (isset($_POST['deleteComment'])) {
    $pd_id = (int) $_POST['pd_id'] ?? 0;
    $getPd = $db->getPostComment_ByID($pd_id);
    if (!isset($_SESSION['usr']) || $_SESSION['usr'] != $getPd['usr_id'] && (!isset($_SESSION['status']) || $_SESSION['status'] != 'admin')) {
        getAlert('You have no permission', 'danger');
    } else {
        $db->deletePostComment__ByID($pd_id);
        header("Refresh:0");
        die;
    }
}

$allComment = $db->getAllPostComment_ByPostID($post_id);
foreach ($allComment as $comment) :
    $usr_com = $db->getUser_ByID($comment['usr_id']);
    $id_ran = rand();
?>
    <div class="form-control">
        <?php if (
            isset($_SESSION['usr']) && $_SESSION['usr'] == $usr_com['usr_id']
            || (isset($_SESSION['status']) && $_SESSION['status'] == 'admin')
        ) : ?>
            <!-- Dropdown menu -->
            <div class="text-end">
                <button id="dropdownButton" data-dropdown-toggle="dropdown<?php echo $id_ran; ?>" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                </button>
            </div>
            <div id="dropdown<?php echo $id_ran; ?>" class="z-30 hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
                <form method="post">
                    <input type="hidden" name="pd_id" value="<?php echo $comment['pd_id']; ?>">
                    <ul class="py-1" aria-labelledby="dropdownButton">
                        <li>
                            <button name="deleteComment" class="text-rose-600 block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">ลบ</button>
                        </li>
                    </ul>
                </form>
            </div>
            <!-- Dropdown menu -->
        <?php endif; ?>
        <div class="flex items-center px-3">
            <div>
                <img class="w-9 rounded-full inline-block" src="/public/profile/<?php echo $usr_com['usr_img'] ?? ""; ?>" onerror="this.onerror=null; this.src='/public/default/profile.png'" alt="profile image">
            </div>
            <div class="px-3">
                <span><?php echo $usr_com['usr_name'] ?? "ไม่พบผู้ใช้งานนี้"; ?></span>
                <div class="text-gray-500 text-sm">โพสต์เมื่อ <?php echo $comment['pd_date'] ?? ""; ?></div>
            </div>
        </div>

        <pre class="p-3 whitespace-pre-wrap break-words max-h-[300px] overflow-y-auto "><?php echo $comment['pd_name'] ?? ""; ?></pre>
    </div>
<?php endforeach; ?>