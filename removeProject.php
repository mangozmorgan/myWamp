<?php


define('FILE_PATH', "../".$_POST['directory']);


function removeAll ( $path ) {
    foreach ( new DirectoryIterator($path) as $item ):
        if ( $item->isFile() ){
            unlink($item->getRealPath());
        }

        if ( !$item->isDot() && $item->isDir() ) RemoveAll($item->getRealPath());

    endforeach;

    $res = rmdir($path);

    return $res;
}

$res = removeAll(FILE_PATH);

echo $res;