<?php
$db = new Database;
$getParams = import('wisit-router/getParams');
$Post = import('./components/Post');
$post_id = (int) $getParams(1) ?? 0;

$post = $db->getPost_ByID($post_id);

if (!$post) {
    return import('./pages/_error');
}

if (isset($_POST['createComment'])) {
    $pd_name = $_POST['pd_name'] ?? "";

    if (!isset($_SESSION['usr'])) {
        header('Location: /login');
        die;
    } elseif (
        strlen($pd_name) > 500 ||
        strlen($pd_name) == 0
    ) {
        getAlert('ข้อความต้องมีขนาดไม่เกิน 500 ตัวอักษร', 'danger');
    } else {
        $pd_name = htmlchar($pd_name);
        $db->insertPostComment($post_id, $pd_name, $_SESSION['usr']);
        header("Refresh:0");
        die;
    }
}

$usr_post = $db->getUser_ByID($post['post_usr_id']);
?>

<title>โพสต์ | <?php echo $usr_post['usr_name'] ?? "ไม่พบผู้ใช้งานนี้"; ?></title>
<main class="py-3">
    <div class="row">
        <div class="col-span-3">
            <?php import('./components/explore/Nav'); ?>
        </div>
        <div class="col-span-6 text-zinc-800">
            <div class="mt-5 mb-3 text-right px-3">
                <a class="inline-block bg-gray-500 px-3  py-2 text-white rounded-lg" onclick="window.history.back()" href="#">ย้อนกลับ</a>
            </div>
            <?php $Post($post); ?>
            <form class="form-control-group" method="post">
                <input class="input-text m-0" maxlength="500" type="text" name="pd_name" id="" required>
                <button name="createComment" class="btn primary">แสดงความคิดเห็น</button>
            </form>
            <div class="mx-3">
                <?php import('./components/post/ShowComment'); ?>
            </div>
        </div>
        <div class="col-span-3">
            <?php import('./components/NavContact'); ?>
        </div>
    </div>
</main>