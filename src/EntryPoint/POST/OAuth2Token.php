<?php

namespace SugarAPI\SDK\EntryPoint\POST;

use SugarAPI\SDK\EntryPoint\Abstracts\POST\AbstractPostEntryPoint;

class OAuth2Token extends AbstractPostEntryPoint {

    protected $_AUTH_REQUIRED = false;
    protected $_URL = 'oauth2/token';
    protected $_REQUIRED_DATA = array(
        'username' => null,
        'password' => null,
        'grant_type' => 'password',
        'client_id' => null,
        'client_secret' => null,
        'platform' => null
    );
    protected $_DATA_TYPE = 'array';

}
