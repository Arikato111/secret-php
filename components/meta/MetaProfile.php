<?php
$MetaProfile = function ($usr) {
?>
    
    <meta name="title" content="<?php echo $usr['usr_name'] ?? "ไม่พบชื่อผู้ใช้"; ?>" />
    <meta name="description" content="<?php echo $usr['usr_bio'] ?? ""; ?>" />

    <meta property="og:url" content="https://<?php echo $_SERVER['SERVER_NAME'] ?? ""; ?>/<?php echo $usr['usr_username'] ?? ""; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $usr['usr_name'] ?? ""; ?>" />
    <meta property="og:description" content="<?php echo $usr['usr_bio'] ?? ""; ?>" />
    <meta property="og:image" content="https://<?php echo $_SERVER['SERVER_NAME'] ?? ""; ?>/public/profile/<?php echo $usr['usr_img'] ?? ""; ?>" />

<?php
};

$export = $MetaProfile;
