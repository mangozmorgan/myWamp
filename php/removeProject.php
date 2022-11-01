<?php


$path = dirname(dirname(__DIR__));
$path = $path."\\".$_POST['directory'];
exec("rd /s /q $path",$output);


echo true;