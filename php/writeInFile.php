<?php


if ( $_POST['method'] === 'changeTheme' ){

    $str=file_get_contents('../js/config.js');

    $str = explode('theme',$str);


    if ( $str[1] === "':'normal'}" ){
//        nicePrint('it was normal');

        $str[1] = "':'dark'}";
    }else{
        nicePrint('it was dark');

        $str[1] = "':'normal'}";
    }
    $newString = $str[0]."theme".$str[1];

    file_put_contents('../js/config.js', $newString );
}




