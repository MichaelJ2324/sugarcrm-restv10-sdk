<?php

require_once __DIR__ . '/../vendor/autoload.php';

try{
    $SugarAPI = new \SugarAPI\SDK\SugarAPI('instances.this/Ent/7700/',array('username' => 'admin','password'=>'asdf'));
    $SugarAPI->login();
    $EP = $SugarAPI->createRecord('Notes')->data(array('name' => 'Test Note'))->execute();
    $response = $EP->getResponse();
    if ($response->getStatus()=='200'){
        $record = $response->getBody();

        $uplaodFileParams = array(
            "format" => "sugar-html-json",
            "delete_if_fails" => true,
            "oauth_token" => $SugarAPI->getToken()->access_token,
            'filename' => '@'.__DIR__.'/testfile.txt;filename=testfile.txt'
        );
        $upload = $SugarAPI->attachFile('Notes',$record->id,'filename')->data($uplaodFileParams)->execute();
        $response = $upload->getResponse();
        if ($response->getStatus()=='200'){
            $record = $response->getBody();
            print_r($response);
        }else{
            print_r($upload->getRequest());
            echo "Failed to Update Note with File<br>";
            echo "Response: ".$response->getStatus()."<br>";
            print_r($response->getBody());
        }
    }else{
        echo "Failed to create Note<br>";
        echo "Response: ".$response->getStatus()."<br>";
        print_r($response->getBody());
    }

}catch(\SugarAPI\SDK\Exception\SDKException $ex){
    print $ex->getMessage();
}