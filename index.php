<?php


include_once './myWamp/php/myInfos.php';
include_once './myWamp/php/utils.php';


$loadedExtensions = get_loaded_extensions();
$phpVersion = phpversion();
$apacheVersion = apache_get_version();
//nicePrint($loadedExtensions);
if ( strpos($apacheVersion , 'OpenSSL') > 0 ){
    $apacheVersion = explode('OpenSSL',$apacheVersion);

    $sslVersion = explode('l',$apacheVersion[1]);
    $sslVersion = str_replace('/','',$sslVersion);
    $sslVersion = $sslVersion[0];

    $apacheVersion = str_replace('/',' ',$apacheVersion[0]);
}
$xdebugColor = 'text-rose-600';
if(function_exists('xdebug_info')) {
    $xdebugColor = 'text-green-600';
}
?>

<style>
    #tooltip{
        top: 1rem !important;
        right: 0.5rem;
    }
    .swal2-popup{
        border: #3c4552 2px solid !important;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }
    .createProjetAndGit:hover{
        background-color: #9334EA;
        
    }
    .toWhite:hover{
        color: white;
    }

    .descriCard {
        -ms-overflow-style: none; /* for Internet Explorer, Edge */
        scrollbar-width: none; /* for Firefox */
        overflow-y: scroll;
    }

    .descriCard::-webkit-scrollbar {
        display: none; /* for Chrome, Safari, and Opera */
    }





</style>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <title>MyWamp - locahost</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>

    <script defer src="<?=BOX_ICON?>"></script>
    <script defer src="<?=FONT_AWESOME?>"></script>
<!--    <script src="https://kit.fontawesome.com/711da2a695.js" crossorigin="anonymous"></script>-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="" />
    <link rel="stylesheet" href="" />
</head>
<body class="themeBG ">
<nav style="position: fixed;top: 0;" class="flex justify-between w-full px-10 py-4 items-center shadow bg-white sticky-bottom bg-white themeBG themeTEXT themeBORDER relative z-20">
    <div class="flex">
        <img class="mr-2" style="width: 2rem;m" src="./favicon.ico">
        <h1 class="text-xl text-gray-800 font-bold themeTEXT">MyWamp</h1>
        <div class="font-semibold flex items-center ml-4" ><span class="text-sm text-gray-400  "><?=$dt?></span></div>


    </div>
    <div class="flex items-center">
        
        <ul class="flex items-center space-x-6">

            <li class="font-semibold text-gray-700 themeTEXT"></li>

            <li class="font-semibold text-yellow-400 ">LocalHost : <?=$_SERVER['SERVER_PORT']?></li>

            <li>
            <a onclick="window.open('./myWamp/php/getInfo.php?php','popup','width=600,height=600'); return false;" href="./myWamp/php/getInfo.php?php" class="font-semibold text-blue-400 mr-2">PHP <?=$phpVersion?></a>

            <a class="font-semibold text-gray-700 <?=$xdebugColor?> " href="./myWamp/php/getInfo.php?xdebug" target="popup"
               onclick="window.open('./myWamp/php/getInfo.php?xdebug','popup','width=600,height=600'); return false;"> XDebug</a>

            <li>



        </ul>
        <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
            <input type="checkbox" value="" id="default-toggle" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"></span>
        </label>
        <div  class="flex flex-col ">
            <i id="gitIcon" onclick="openGitInfo()" style="" class='text-black text-2xl relative  fa-brands text-white fa-github cursor-pointer ml-2 themeTEXT'></i>
            <div id="modalGit" class="border p-4 border-slate-500 bg-white rounded absolute top-20 right-2 hidden themeBG themeTEXT themeBORDER">
                <ul>
                    <li class="text-2xl mb-2 ">
                        <div style="width: 4rem;height: 4rem;"  class="w-full justify-end">
                            <img class="rounded-full" id="avatarGit" src="">
                        </div>

                        <p>
                            GIT <i id="gitIcon"  style="" class='text-2xl relative  fa-brands text-white fa-github cursor-pointer ml-2 '></i>
                        </p>
                        <p class="mb-4">
                           informations
                        </p>

                    </li>
                    <li id="publicRepo" class="text-normal"></li>
                    <li id="privateRepo" class=" text-normal"></li>
                </ul>
            </div>

        </div>
        <div  class="flex flex-col ">
            <i onclick="openInfo()" class="cursor-pointer fa-solid fa-circle-info text-2xl ml-2"></i>
            <div id="modalInfos" class="hidden border p-4 border-slate-500 bg-white rounded absolute top-20 right-2  themeBG themeTEXT themeBORDER">
                <ul>
                    <li class="text-xl font-bold mb-2 ">
                        <p class="mb-4">
                           Informations
                        </p>

                    </li>
                    <li id="" class=""><span class="font-bold">Server : </span><?=$apacheVersion?></li>
                    <li id="" class=" "><span class="font-bold">SSL : </span>OpenSSL <?=$sslVersion?> </li>
                    <li id="" class=" "><span class="font-bold">Root : </span>  <?=$_SERVER['DOCUMENT_ROOT']?> </li>
                    <li onclick="openList(this)" class="cursor-pointer font-bold">PHP extentions loaded <i id="ulExt" class="cursor-pointer fa-solid fa-caret-down ml-2"></i></li>

                    <ul id="listExtension" style="max-height: 20rem !important;min-width: fit-content" class="descriCard overflow-scroll hidden cursor-pointer font-bold">
                        <div class="">
                            <input class="absolute border border-gray-300 focus-normal bg-white h-10 px-5 rounded-lg text-sm font-normal themeBG themeTEXT themeBORDER"
                                   type="text" name="searchExtension" id="searchExtension" placeholder="Research an active extension">
                            <div style="height: 3rem"></div>
                        </div>

                        <?php
                            foreach($loadedExtensions as $extensions){
                                echo "<li   class='liExt font-normal'><a href='https://www.google.com/search?q=php+extension+".$extensions."'>$extensions</a></li>";
                            }
                        ?>
                    </ul>
                </ul>
            </div>

        </div>



    </div>
</nav>
<div style="margin-top: 5rem" class="flex justify-center ">
    <div class="flex pt-2 relative text-gray-600 mr-2">
        <input class="border-2  bg-white h-10 px-5 pr-16 rounded-lg text-sm  themeBG themeTEXT themeBORDER"
               type="text" name="search" id="search" placeholder="Research a project">
        <button type="submit" id="btnSearch" class="absolute right-0 top-0 mt-5 mr-4 themeTEXT"><i class="fa-solid fa-rotate-right themeTEXT"></i>
        </button>

    </div>

    <div class="ml-4 pt-2 ml-2">
        <div class="dropdown inline-block relative z-10">
            <button class="font-semibold py-2 px-4 rounded inline-flex items-center  themeBG themeTEXT themeBORDER">
                <span class="mr-1">Create new project</span>
                <i class="ml-2 fa-solid fa-plus"></i>
            </button>
            <ul class="dropdown-menu absolute hidden  pt-1 bg-white themeBG themeTEXT themeBORDER">
                <li onclick="createProject(false)" class="cursor-pointer toWhite"><div class="rounded-t hover:bg-blue-400 py-2 px-4 block whitespace-no-wrap" >Create a new local project</div></li>
                <li onclick="createProject(true)" class="cursor-pointer toWhite"><div class="createProjetAndGit py-2 px-4 block whitespace-no-wrap" >Create a new local project and a git repository <i  class=' fa-brands fa-github cursor-pointer mr-2 toWhite'></i></div></li>

            </ul>
        </div>

    </div>



</div>

<div class="flex flex-wrap justify-center">

<?php

$blackListArray = array('.','..','.idea');
foreach($scandir as $fichier){
    $asGitProject = false ;
    $stat = stat("./$fichier");
    if ( !in_array($fichier ,$blackListArray) )
    {
        $dateCreation=date("d-m-Y ",$stat['ctime']);
//        $filename="";
//        $faviconProjectName="";

        $text='No more informations';

        if(@file_get_contents("./$fichier/".FILE_INFO_PROJECT)!==false)
        {
            $text=file_get_contents("./$fichier/".FILE_INFO_PROJECT);
        }

        if (findGit('./'.$fichier) === true ){
            $asGitProject = true;
        }



        $icon='./favicon2.ico';

        if(file_exists("./$fichier/".FAVICON_PROJECT))
        {
            $icon="./$fichier/".FAVICON_PROJECT;
        }



        echo "<div style='min-width: 20rem;max-width: 20rem;' class='p-6 m-4   rounded-lg drop-shadow-md shadow-md themeBORDER themeBG themeTEXT '>

            <div class='flex'>
                <div class='w-1/2' >
                    <img src='".$icon."' alt=''>
                    <h5  class='my-2 text-xl font-bold tracking-tight nameProjet '>$fichier</h5>
                </div>
                 <div class='w-1/2 flex justify-end' >
                    
                </div>
                
            </div>
            
            <p style='height: 3.5rem;' class='descriCard py-2 mb-3 overflow-scroll font-normal text-gray-700 dark:text-gray-400'>$text</p>
            <a href='./".$fichier."' class='inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-2'>
                Go to app
                <svg aria-hidden='true' class='ml-2 -mr-1 w-4 h-4' fill='currentColor' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z' clip-rule='evenodd'></path></svg>
            </a>
            <div class='flex justify-between'>
                <p class='mt-2 font-normal text-gray-700 dark:text-gray-400'>Created : $dateCreation</p>
                <div class='mt-2 font-normal text-gray-700 dark:text-gray-400'>
                ";
                if ($asGitProject === true ){
                    echo "<i onclick=\"openGit('".GIT_ACCOUNT."$fichier')\" class='text-purple-600 fa-brands fa-github cursor-pointer mr-2'></i>";
                }

                echo "<i onclick=\"openExplorer('$fichier')\" class='fa-regular fa-folder-open text-blue-400  cursor-pointer '></i>
                <i id='".$fichier."' onclick=\"remove('$fichier','$asGitProject')\" class='fa-solid fa-trash text-red-400 cursor-pointer mr-2'></i>";
                ?>

                </div>
            
            </div>
        </div>


<?php

    }
}


?>
<div>

</body>
</html>


<script src="./myWamp/js/config.js"></script>
<script src="./myWamp/js/utils.js"></script>
