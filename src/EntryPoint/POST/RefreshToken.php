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

    /**
     * Configure Grant Type to be refresh_token
     * @param mixed $data
     * @return array|mixed
     */
    protected function configureData($data){
        if (is_array($data)){
            $data['grant_type'] = 'refresh_token';
        }elseif (is_object($data)){
            $data->grant_type = 'refresh_token';
        }
        return $data;
    }

}