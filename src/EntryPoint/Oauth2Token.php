<?php

namespace SugarAPI\SDK\EntryPoint;


class Oauth2Token extends Abstract_POST_EntryPoint {

    protected static $_AUTH_REQUIRED = false;
    protected static $_URL = 'oauth2/token';
    protected static $_REQUIRED_DATA = array(
        'username',
        'password',
        'grant_type',
        'client_id',
        'client_secret',
        'platform'
    );


}