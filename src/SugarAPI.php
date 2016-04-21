<?php

namespace SugarAPI\SDK;

use SugarAPI\SDK\Client\Abstracts\AbstractClient;

/**
 * The default SDK Client
 * @package SugarAPI\SDK
 */
class SugarAPI extends AbstractClient {

    /**
     * The configured Authentication options
     * @var array
     */
    protected $credentials = array(
        'username' => '',
        'password' => '',
        'client_id' => 'sugar',
        'client_secret' => '',
        'platform' => 'api'
    );

    /**
     * @inheritdoc
     * Overrides only the credentials properties passed in, instead of entire credentials array
     */
    public function setCredentials(array $credentials){
        foreach ($this->credentials as $key => $value){
            if (isset($credentials[$key])){
                $this->credentials[$key] = $credentials[$key];
            }
        }
        return parent::setCredentials($this->credentials);
    }

}