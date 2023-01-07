<?php
function deleteUser(int $id)
{
    $db = new Database;
    $db->deleteAllBoard_ByUsrID($id);
    $db->deleteAllBoardDetail_ByUsrID($id);
    $db->deleteAllFollow_ByUsrID($id);
    $db->deleteAllPoll_ByUsrId($id);
    $db->deleteAllPollLog_ByUsrId($id);
    $allPost = $db->getAllPost_ByUsrID($id);
    foreach ($allPost as $post) {
        if (file_exists('./public/posts/' . $post['post_img']))
            unlink('./public/posts/' . $post['post_img']);
        $db->deletePost_ByID($post['post_id']);
        $db->deletePostDetail_ByPostID($post['post_id']);
        $db->deletePostLike(post_id: $post['post_id'], usr_id: $id);
    }
    $db->deletePostDetail_ByUsrID($id);
    $usr = $db->getUser_ByID($id);
    if (file_exists('./public/profile/' . $usr['usr_img']))
        unlink('./public/profile/' . $usr['usr_img']);
    $db->deleteUser_ByID($id);
}
