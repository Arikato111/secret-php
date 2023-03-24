<?php
$getParams = import('wisit-router/getParams');
$MetaProfile = import('./components/meta/MetaProfile');
$MetaPost = import('./components/meta/MetaPost');
$db = new Database;

$path = $getParams(0);

$usr = $db->getUser_ByUsername($path);

if ($path == 'post' && $getParams(1) != '') {
    $post = $db->getPost_ByID((int) $getParams(1));
}
if ($post ?? false) {
   $MetaPost($post); 
} elseif ($usr) {
    $MetaProfile($usr);
} else {
?>
    <meta name="title" content="สำรวจ | กระดานสนทนา | ผู้คน" />
    <meta name="description" content="aden คือแพลตฟอร์มสำหรับผู้ที่อยากพูดคุยสื่อสารกับคนอื่นๆ อย่างเรียบง่ายและไม่ซับซ้อน" />
    <meta name="keywords" content="aden, โซเชียล, โซเชียล aden, เว็บออนไลน์, เว็บข่าวสาร, เว็บกระทู้, เว็บไซต์พูดคุย, เว็บกระดานข่าวสาร, เว็บอะไรสักอย่าง, นึกไม่ออกแล้ว, open source, เว็บ open source, เว็บไซต์ open source, เว็บออนไลน์ open source">
    <meta property="og:url" content="https://aden.anytion.com" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="สำรวจ | กระดานสนทนา | ผู้คน" />
    <meta property="og:description" content="aden คือแพลตฟอร์มสำหรับผู้ที่อยากพูดคุยสื่อสารกับคนอื่นๆ อย่างเรียบง่ายและไม่ซับซ้อน" />
    <meta property="og:image" content="https://aden.anytion.com/public/default/brand.jpg" />

<?php } ?>