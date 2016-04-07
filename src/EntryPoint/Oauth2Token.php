<?php

namespace SugarAPI\SDK\EntryPoint;

use SugarAPI\SDK\EntryPoint\Abstracts\Abstract_POST_EntryPoint;

class Oauth2Token extends Abstract_POST_EntryPoint {

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