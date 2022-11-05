<?php
include_once './GitController.php';
$git = new GitController();
$userGitInfo = $git->getGitUserInfo();

if ( !empty($userGitInfo) && is_array($userGitInfo) ){
    echo json_encode($userGitInfo);
}

