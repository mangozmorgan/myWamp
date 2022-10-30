<?php
setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('Europe/Paris');
$dt = strftime('%A %d %B %Y, %H:%M');

$scandir = scandir("./");

function findGit($dir){
    if ( is_dir($dir) ){
        $scandir = scandir($dir);
        foreach( $scandir as $fileOrDir ){
            if ( $fileOrDir === '.git' || $fileOrDir === '.gitattributes'){
                return true;
            }
        }
    }
}