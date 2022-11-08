<?php

if( isset($_GET['xdebug']) ){
    xdebug_info();
}elseif( isset($_GET['php']) ){
    phpinfo();
}