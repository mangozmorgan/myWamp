<?php
if ( file_exists('./myInfos.php') ){
    include_once './myInfos.php';
}
//elseif ( file_exists('../myInfos.php') ){
//    include_once '../myInfos.php';
//}

class GitController
{
    public $username = USER_GIT;
    public $token = TOKEN_AUTH_GIT;
    public $headers = array();

    public function __construct(){
        $this->headers[] = 'Accept: application/vnd.github+json';
        $this->headers[] = "Authorization: Bearer ".$this->token;
    }

    public function removeRepository( $repository ){



        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/'.$this->username.'/'.$repository);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_USERAGENT,'myWampApp');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);



        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        var_dump($result);
    }

    public function createRepository( $repositoryName , $description="" , $private = true ){

        if($private != false && $private != 'private'){
            $private = 'false';
        }else{
            $private = 'true';
        }

        $ch = curl_init();
        $err = '';

        curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/user/repos');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT,'myWampApp');

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"name\":\"$repositoryName\",\"description\":\"$description\",\"homepage\":\"https://github.com\",\"private\":$private,\"has_issues\":true,\"has_projects\":true,\"has_wiki\":true}");


        $this->headers[] = 'Content-Type: application/x-www-form-urlencoded';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $repoCreated = curl_exec($ch);

        curl_close($ch);

        if( isset(json_decode($repoCreated)->errors) ){
            return array('error'=>'Github : '.json_decode($repoCreated)->errors[0]->message);

        }else{
            return array('success'=>$repoCreated);
        }


    }

    public function cloneRepo($repositoryName){
        chdir(dirname(dirname(__DIR__)));
        $res = shell_exec("git clone https://github.com/mangozmorgan/".$repositoryName.".git");
    }

    public function getGitUserInfo(){

        $userGitInfo = array();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/user');
        curl_setopt($ch, CURLOPT_USERAGENT,'myWampApp');

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $this->headers );

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $decodedData = json_decode($result);

        $userGitInfo['avatar_url'] = $decodedData->avatar_url;
        $userGitInfo['location'] = $decodedData->location;
        $userGitInfo['public_repos'] = $decodedData->public_repos;
        $userGitInfo['total_private_repos'] = $decodedData->total_private_repos;

        return $userGitInfo;
    }

    public function getLocalRepoStatus($repo){
        chdir("C:/wamp64/www/$repo")  ;
        $result=exec("git status",$r2);

//        echo "<pre>";

//        foreach($r2 as $line)
//        {
////            echo $line."\n";
//            nicePrint(trim($line));
//        }

        unset($r2);

//        echo "\n\n";
//        echo "------------------------------------------------------";
//        echo "\ngit status\n";
//        echo "------------------------------------------------------";
//        echo "\n\n";
        $result = exec("git config --global --add safe.directory C:/wamp64/www/$repo",$r2);
        $result=exec("git status 2>&1",$r2);

//        echo "<pre>";
        $statusArray = array();

        foreach($r2 as $line)
        {

            if ( strpos($line,':')){
                $explodedString = explode(':',$line);

                if(strlen($explodedString[1]) != 0 ){

                    $statusArray[trim($explodedString[0])][] = $explodedString[1];

                }
            }else{
                if(strlen($line) != 0 ){
                    $statusArray[] = $line;

                }

            }

        }

        if ( isset($statusArray['new file']) ){
            $statusArray['toCommit'] = count($statusArray['new file']);
        }

        return $statusArray;
    }

    public function getBehindStatusFromOrigin($repo)
    {
        $resultArray = array();
        $resultArray['ahead'] = 0 ;
        $resultArray['behind'] = 0 ;
        chdir("C:/wamp64/www/$repo");
//        $result=exec("git fetch",$r2);
        $result=exec("git status -sb",$r2);
        $behindCount='0';

        if ( !empty($r2) ){

            foreach($r2 as $line)
            {

                if(strpos($line,'behind') > 0 )
                {

                    $behindCount=explode('[',$line);
                    $behindCount=trim(str_replace('behind ','',$behindCount[1]));
                    $behindCount=trim(str_replace(']','',$behindCount));

                }
                $resultArray["behind"] = $behindCount;

                if( strpos($line,'ahead')  >   0){

                    if(strpos($line,',') > 0 ){
                        $ahead = explode(',',$behindCount);
                        $behind = trim(str_replace(', ','',$ahead[1]));
                        $ahead = trim(str_replace('ahead ','',$ahead[0]));
                        $resultArray["ahead"] = $ahead;
                        $resultArray["behind"] = $behind;
                    }else{
                        $behindCount=explode('[',$line);
                        $behindCount=trim(str_replace('ahead ','',$behindCount[1]));
                        $behindCount=trim(str_replace(']','',$behindCount));
                        $ahead = explode(',',$behindCount);
                        $ahead = trim(str_replace('ahead ','',$ahead[0]));
                        $resultArray["ahead"] = $ahead;

                    }

                }else{
                    $resultArray["ahead"] = 0;
                }

                return $resultArray;
            }
        }else{
            return $resultArray;
        }




        unset($r2);
        return $resultArray;
    }


}