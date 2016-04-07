<?php

namespace SugarAPI\SDK\EntryPoint;


use SugarAPI\SDK\EntryPoint\Abstracts\Abstract_POST_EntryPoint;

class RefreshToken extends Abstract_POST_EntryPoint {

    protected $_AUTH_REQUIRED = false;
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