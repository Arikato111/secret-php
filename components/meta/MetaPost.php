<?php
$MetaPost = function ($post) {
    $db = new Database;
    $usr = $db->getUser_ByID($post['post_usr_id'] ?? 0);
?>

<meta name="title" content="<?php echo $post['post_detail'] ?? ""; ?>" />
    <meta name="description" content="โพสต์ของ <?php echo $usr['usr_name'] ?? "ไม่พบชื่อผู้ใช้"; ?>" />

    <meta property="og:url" content="https://<?php echo $_SERVER['SERVER_NAME'] ?? ""; ?>/posts/<?php echo $post['post_id'] ?? ""; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $post['post_detail'] ?? ""; ?>" />
    <meta property="og:description" content="โพสต์ของ <?php echo $usr['usr_name'] ?? "ไม่พบชื่อผู้ใช้"; ?>" />
    <meta property="og:image" content="https://<?php echo $_SERVER['SERVER_NAME'] ?? ""; ?>/public/posts/<?php echo $post['post_img'] ?? ""; ?>" />

<?php
};

$export = $MetaPost;
