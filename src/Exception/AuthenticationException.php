<?php

namespace SugarAPI\SDK\Exception;

class AuthenticationException extends SDKException{

    protected $message = 'Authentication Exception occurred when attempting to Login to SugarCRM instance. Message: %s';

    public function __construct($message) {
        $message = sprintf($this->message,$message);
        parent::__construct($message);
    }

}