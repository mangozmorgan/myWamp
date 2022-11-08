<?php
include_once './GitController.php';

$git = new GitController();
$repoStatusArray = array();

$res = $git->getLocalRepoStatus($_POST['repo']);

$commitToDo = 0;

if ( isset($res["new file"]) )  {
    $commitToDo = count($res["new file"]);
}
$repoStatusArray['commitsToDo'] = $commitToDo;

//$behindFromOrigin = $git->getBehindStatusFromOrigin(trim($_POST['repo']));
//nicePrint($behindFromOrigin);die();
//if ( $behindFromOrigin === null ){
//    $behindFromOrigin = 0 ;
//}
//$repoStatusArray['behindFromOrigin'] = $behindFromOrigin;
//nicePrint($repoStatusArray);

echo json_encode($repoStatusArray);