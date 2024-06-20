<?php

require dirname(__DIR__) . './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();



//DOC : your personnal Font Awesome CDN
define('FONT_AWESOME', $_ENV['FONT_AWESOME_CDN']);



//DOC : to get your personnal Git token Auth go to -> https://github.com/settings/tokens -> Generate new token
define('TOKEN_AUTH_GIT', $_ENV['GIT_TOKEN']);
define('GIT_ACCOUNT', $_ENV['GIT_ACCOUNT']);
define('USER_GIT', $_ENV['GIT_USERNAME']);

//DOC : You need to create this little file in every projects if you want to have a little descrition of your project in the interface like readme.txt in myWamp directory
define('FILE_INFO_PROJECT', "readme.txt");

//DOC : By default the favicon of website is called "favicon.ico" but you can change here ! That's needed to display a little picture in the interface
define('FAVICON_PROJECT', "favicon.ico");


