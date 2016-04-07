<?php

namespace SugarAPI\SDK\Exception;


use SugarAPI\SDK\Exception\Abstracts\AbstractException;

class AuthenticationError extends AbstractException{

    protected $defaultMessage = 'Unknown error occurred, when SDK attempted to Authenticate to SugarCRM instance.';
    protected $failureCodes = array(
        'missing_user_pass' => 'Username or Password was not provided.',
        'invalid_user_pass' => 'The username or password provided were invalid.',
        'failed_auth' => 'SugarAPI SDK is not authenticated.'
    );

}