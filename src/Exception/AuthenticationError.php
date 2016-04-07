<?php

namespace SugarAPI\Exception;


use SugarAPI\Exception\Abstracts\AbstractException;

class AuthenticationError extends AbstractException{

    protected $defaultMessage = 'Unknown error occurred, when creating API EntryPoint.';
    protected $failureCodes = array(
        'missing_user_pass' => 'Username or Password was not provided.',
        'invalid_user_pass' => 'The username or password provided were invalid.',
        'no_auth' => 'SugarAPI SDK is not authenticated.'
    );

}