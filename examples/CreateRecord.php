<?php

require_once __DIR__ . '/../vendor/autoload.php';

try{
    $SugarAPI = new \SugarAPI\SDK\SugarAPI('instances.this/Pro/7621/',array('username' => 'admin','password'=>'asdf'));
    $SugarAPI->login();
    $EP = $SugarAPI->createRecord('Accounts');
    $EP->data(array(
        'name' => 'Test Record 4',
        'email1' => 'test4@sugar.com'
    ));
    $response = $EP->execute()->getResponse();
    if ($response->getStatus()=='200'){
        $record = $response->getBody();
        $EP2 = $SugarAPI->getRecord('Accounts',$record->id)->data(array('fields' => 'name,email1'));
        $getResponse = $EP2->execute()->getResponse();
        print $EP2->getUrl();
        print_r($getResponse->getBody());
    }

}catch(\SugarAPI\SDK\Exception\AuthenticationError $ex){
    print $ex->getMessage();
}