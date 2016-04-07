<?php


require_once __DIR__ . '/../vendor/autoload.php';

try{
    $SugarAPI = new \SugarAPI\SDK\SugarAPI('instances.this/Pro/7621/',array('username' => 'admin','password'=>'asdf'));
    $SugarAPI->login();
    $EP = $SugarAPI->filterRecords('Accounts');
    $response = $EP->execute()->getResponse();
    if ($response->getStatus()=='200'){
        print_r($response->getBody());
    }else{
        print_r($EP);
        print_r($response->getBody());
    }
}catch(\SugarAPI\SDK\Exception\AuthenticationError $ex){
    print $ex->getMessage();
}
