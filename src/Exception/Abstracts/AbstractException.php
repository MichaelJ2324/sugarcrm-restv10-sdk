<?php

namespace SugarAPI\Exception\Abstracts;

abstract class AbstractException extends \Exception{

    protected $defaultMessage = 'Unknown SugarAPI SDK Exception Occurred.';
    protected $failureCodes = array();

    public function __construct($code) {
        $message = $this->convertCode($code);
        parent::__construct($message, $code);
    }

    protected function convertCode($code){
        if (array_key_exists($code,$this->failureCodes)){
            return $this->failureCodes[$code];
        }else{
            return $this->defaultMessage;
        }
    }

    public function __toString(){
        return "SugarAPI SDK Exception [".$this->code." - ".$this->message."] occurred on ".$this->line." in ".$this->file;
    }

}