<?php

namespace SugarAPI\SDK\EntryPoint\POST;

class RefreshToken extends Oauth2Token {

    /**
     * @inheritdoc
     */
    protected $_REQUIRED_DATA = array(
        'grant_type' => 'refresh_token',
        'refresh_token' => NULL,
        'client_id' => NULL,
        'client_secret' => NULL
    );

}