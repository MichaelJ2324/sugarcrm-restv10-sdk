<?php



$SugarAPI = new \SugarAPI\SDK\SugarAPI('instance.this/Ent/7621/',array('username' => 'admin','password'=>'asdf'));
$SugarAPI->login();
print_r($SugarAPI->getToken());