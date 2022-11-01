<?php

include_once './GitController.php';

$git=new GitController();
var_dump($_POST);
$repoCreated = $git->removeRepository($_POST['directory']);