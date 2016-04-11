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

    /**
     * Configure the Grant Type to be Password
     * @param mixed $data
     * @return array|mixed
     */
    protected function configureData($data) {
        if (is_array($data)){
            $data['grant_type'] = 'password';
        }elseif (is_object($data)){
            $data->grant_type = 'password';
        }
        return $data;
    }


}