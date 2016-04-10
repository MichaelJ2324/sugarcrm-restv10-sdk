<?php

namespace SugarAPI\SDK\Exception;

class EntryPointException extends SDKException {

    public function __construct($message) {
        parent::__construct($message);
    }

}