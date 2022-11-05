<?php

include_once './myInfos.php';

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
// TODO à venir : doit check si le repo exist deja
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


}