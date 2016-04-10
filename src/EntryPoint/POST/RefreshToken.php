<?php

namespace SugarAPI\SDK\EntryPoint\POST;


use SugarAPI\SDK\EntryPoint\Abstracts\POST\JSONEntryPoint as POSTEntryPoint;

class RefreshToken extends POSTEntryPoint {

    protected $_REQUIRED_DATA = array(
        'grant_type',
        'refresh_token',
        'client_id',
        'client_secret'
    );

    public function data(array $data){
        $data['grant_type'] = 'refresh_token';
        return parent::data($data);
    }

}