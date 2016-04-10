<?php

namespace SugarAPI\SDK\Exception;

class SDKException extends \Exception{

    public function __construct($message = 'Unknown SugarAPI SDK Exception Occurred.') {
        parent::__construct($message);
    }

}