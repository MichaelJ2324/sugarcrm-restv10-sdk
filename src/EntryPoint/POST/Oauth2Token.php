<?php

namespace SugarAPI\SDK\EntryPoint\POST;

use SugarAPI\SDK\EntryPoint\Abstracts\POST\JSONEntryPoint as POSTEntryPoint;

class Oauth2Token extends POSTEntryPoint {

    protected $_AUTH_REQUIRED = false;
    protected $_URL = 'oauth2/token';
    protected $_REQUIRED_DATA = array(
        'username',
        'password',
        'grant_type',
        'client_id',
        'client_secret',
        'platform'
    );

    public function data(array $data){
        $data['grant_type'] = 'password';
        return parent::data($data);
    }


}