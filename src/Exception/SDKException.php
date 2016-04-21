<?php

namespace SugarAPI\SDK\Exception;

class SDKException extends \Exception {

    protected $default_message = 'Unknown SDK Exception occurred.';

    public function __construct($message) {
        if (empty($message)){
            $message = $this->default_message;
        }
        parent::__construct($message);
    }

}