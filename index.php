<?php
    include_once './myWamp/php/myInfos.php';
    include_once './myWamp/php/utils.php';
?>

<style>
    .swal2-popup{
        border: #3c4552 2px solid !important;
    }

</style>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <title>Wamp64 - locahost</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
    <script defer src="<?=BOX_ICON?>"></script>
    <script defer src="<?=FONT_AWESOME?>"></script>
<!--    <script src="https://kit.fontawesome.com/711da2a695.js" crossorigin="anonymous"></script>-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="" />
</head>
<body class="themeBG ">
<nav style="position: fixed;z-index: 1;top: 0;" class="flex justify-between w-full px-10 py-4 items-center shadow bg-white sticky-bottom bg-white themeBG themeTEXT themeBORDER">
    <div class="flex">
        <img class="mr-2" style="width: 2rem;m" src="./favicon.ico">
        <h1 class="text-xl text-gray-800 font-bold themeTEXT">Wamp64</h1>

    </div>
    <div class="flex items-center">
        
        <ul class="flex items-center space-x-6">
            <li class="font-semibold text-gray-700 themeTEXT"><?=$dt?></li>

            <li>
            <li class="font-semibold text-gray-700 themeTEXT">LocalHost : <?=$_SERVER['SERVER_PORT']?></li>

            <li>
            <li class="font-semibold text-gray-700 themeTEXT"><?=$_SERVER['SERVER_SOFTWARE']?></li>

            <li>


        </ul>
        <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
            <input type="checkbox" value="" id="default-toggle" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"></span>
        </label>
    </div>
</nav>
<div style="margin-top: 5rem" class="flex justify-center">
    <div class=" pt-2 relative mx-auto text-gray-600 ">
        <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm  themeBG themeTEXT themeBORDER"
               type="text" name="search" id="search" placeholder="name of project">
        <button type="submit" id="btnSearch" class="absolute right-0 top-0 mt-5 mr-4 themeTEXT"><i class="fa-solid fa-rotate-right themeTEXT"></i>
        </button>
    </div>
</div>

<div class="flex flex-wrap justify-center">

<?php

$blackListArray = array('.','..','.idea');
foreach($scandir as $fichier){

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



        $icon='./favicon2.ico';

        if(file_exists("./$fichier/".FAVICON_PROJECT))
        {
            $icon="./$fichier/".FAVICON_PROJECT;
        }

        echo "<div style='min-width: 20rem;' class='p-6 m-4   rounded-lg drop-shadow-md border-gray-200 shadow-md themeBORDER themeBG themeTEXT '>
            <a href='./".$fichier."'>
                <img src='".$icon."' alt=''>
                <h5  class='mb-2 text-xl font-bold tracking-tight nameProjet '>$fichier</h5>
            </a>
            <p class='mb-3 font-normal text-gray-700 dark:text-gray-400'>$text</p>
            <a href='./".$fichier."' class='inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800'>
                Go to app
                <svg aria-hidden='true' class='ml-2 -mr-1 w-4 h-4' fill='currentColor' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z' clip-rule='evenodd'></path></svg>
            </a>
            <div class='flex justify-between'>
                <p class='mt-2 font-normal text-gray-700 dark:text-gray-400'>Created : $dateCreation</p>
                <div class='mt-2 font-normal text-gray-700 dark:text-gray-400'>
                ";
                if (findGit('./'.$fichier) === true ){
                    echo "<i onclick=\"openGit('".GIT_ACCOUNT."$fichier')\" class='text-purple-600 fa-brands fa-github cursor-pointer mr-2'></i>";
                }

                echo "<i onclick=\"openExplorer('$fichier')\" class='fa-regular fa-folder-open text-blue-400 cursor-pointer '></i>
                <i onclick=\"remove('$fichier')\" class='fa-solid fa-trash text-red-400 cursor-pointer mr-2'></i>";
                ?>

                </div>
            
            </div>
        </div>


<?php
        ;
    }
}


?>
<div>

</body>
</html>


<script src="./myWamp/js/config.js"></script>
<script src="./myWamp/js/utils.js"></script>
