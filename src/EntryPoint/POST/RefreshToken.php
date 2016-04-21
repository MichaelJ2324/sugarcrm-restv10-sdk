<?php

namespace SugarAPI\SDK\EntryPoint\POST;

class RefreshToken extends Oauth2Token {

    /**
     * @inheritdoc
     */
    protected $_REQUIRED_DATA = array(
        'grant_type' => 'refresh_token',
        'refresh_token' => null,
        'client_id' => null,
        'client_secret' => null
    );

}