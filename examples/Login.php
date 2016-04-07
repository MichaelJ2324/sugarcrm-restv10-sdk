<?php

require_once __DIR__ . '/../vendor/autoload.php';

$SugarAPI = new \SugarAPI\SDK\SugarAPI('instances.this/Ent/7621/',array('username' => 'admin','password'=>'asdf'));
$SugarAPI->login();
print_r($SugarAPI->getToken());