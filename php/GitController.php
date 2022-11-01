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

    public function createRepository( $repositoryName , $description , $private = false ){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/user/repos');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT,'myWampApp');

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"name\":\"$repositoryName\",\"description\":\"$description\",\"homepage\":\"https://github.com\",\"private\":\"$private\",\"has_issues\":true,\"has_projects\":true,\"has_wiki\":true}");


        $this->headers[] = 'Content-Type: application/x-www-form-urlencoded';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $repoCreated = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $repoCreated;
    }
}