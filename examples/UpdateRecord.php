<?php

require_once __DIR__ . '/../vendor/autoload.php';

$record_id = '436dcb0b-14a9-c0d4-3046-5706b186b9b8';

try{
    $SugarAPI = new \SugarAPI\SDK\SugarAPI('instances.this/Pro/7621/',array('username' => 'admin','password'=>'asdf'));
    $SugarAPI->login();
    $EP = $SugarAPI->updateRecord('Accounts',$record_id);
    $EP->getRequest()->setOption();
    $record = $SugarAPI->updateRecord('Accounts',$record_id)->data(array(
        'name' => 'Test Record 5',
        'email1' => 'test5@sugar.com'
    ))->execute()->getResponse()->getBody();
    echo "Updated Record: ".$record->id;

}catch(\SugarAPI\SDK\Exception\AuthenticationException $ex){
    print $ex->getMessage();
}


