<?php

include_once './GitController.php';

Function enleveaccents($chaine)
{
    $string= strtr($chaine,

        "ÀÁÂàÄÅàáâàäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏ" .
        "ìíîïÙÚÛÜùúûüÿÑñ",
        "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");

    return $string;
} ;

$_POST['directoryName'] = enleveaccents(trim($_POST['directoryName']));

if (strpos($_POST['directoryName'],' ')){
    $_POST['directoryName'] = str_replace(' ','_',$_POST['directoryName']);
}

$git = new GitController();
$git->cloneRepo($_POST['directoryName']);
sleep(3);

touch('C:/wamp64/www/'.$_POST['directoryName'].'/readme.txt');

$myfile = fopen('C:/wamp64/www/'.$_POST['directoryName'].'/readme.txt', "w") or die("Unable to open file!");

$res = fwrite($myfile, $_POST['description']);
fclose($myfile);
// var_dump($res);