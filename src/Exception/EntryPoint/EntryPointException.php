<?php

namespace SugarAPI\SDK\Exception\EntryPoint;

use SugarAPI\SDK\Exception\SDKException;

class EntryPointException extends SDKException {

    protected $message = 'EntryPoint Exception [%s] occurred on EntryPoint %s: %s';

    public function __construct($EntryPoint, $data){
        parent::__construct(sprintf($this->message, get_called_class(), $EntryPoint, $data));
    }

}