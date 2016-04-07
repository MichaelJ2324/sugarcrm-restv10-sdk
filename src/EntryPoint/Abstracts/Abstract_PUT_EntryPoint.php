<?php

namespace SugarAPI\SDK\EntryPoint;

use SugarAPI\SDK\EntryPoint\Interfaces\EPInterface;
use SugarAPI\SDK\EntryPoint\Traits\EPTrait;
use SugarAPI\SDK\Request\PUT;
use SugarAPI\SDK\Response\Standard as StandardResponse;

abstract class Abstract_PUT_EntryPoint implements EPInterface{

    use EPTrait;

    protected function setupRequest(){
        $this->Request = new PUT();
    }
    protected function setupResponse(){
        $this->Response = new StandardResponse($this->Request->getResponse(),$this->Request->getRequest());
    }

}