<?php

include_once './GitController.php';

$git=new GitController();
$repoStatusArray=array();


//$commitToDo=0;
//
//if(isset($res["new file"]))
//{
//    $commitToDo=count($res["new file"]);
//}
//$repoStatusArray['commitsToDo']=$commitToDo;

$behindFromOrigin=$git->getBehindStatusFromOrigin(trim($_POST['repo']));
//nicePrint($behindFromOrigin);
//if ( $behindFromOrigin === null ){
//    $behindFromOrigin = 0 ;
//}


echo json_encode($behindFromOrigin);