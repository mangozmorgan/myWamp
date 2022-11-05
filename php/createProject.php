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

//DOC :verification about directory exist
if( is_dir('../../'.$_POST['directoryName']) ){

    echo json_encode( array('error'=>"project already existing in local directory") );

}else{

    if ( $_POST['git'] === 'false' ){

        mkdir('../../'.$_POST['directoryName']);

        $myfile = fopen('../../'.$_POST['directoryName'].'/readme.txt', "w") or die("Unable to open file!");

        $res = fwrite($myfile, $_POST['description']);
        fclose($myfile);

    }else{
       $res = $git->createRepository($_POST['directoryName'],$_POST['description'],$_POST['visibility']);
       echo json_encode($res);
    }
}


