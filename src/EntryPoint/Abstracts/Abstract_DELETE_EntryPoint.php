<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts;


use SugarAPI\SDK\EntryPoint\Interfaces\EPInterface;
use SugarAPI\SDK\EntryPoint\Traits\EPTrait;
use SugarAPI\SDK\Request\DELETE;
use SugarAPI\SDK\Response\Standard as StandardResponse;

abstract class Abstract_DELETE_EntryPoint implements EPInterface{

    use EPTrait;

    protected function setupRequest(){
        $this->Request = new DELETE();
    }
    protected function setupResponse(){
        $this->Response = new StandardResponse($this->Request->getResponse(),$this->Request->getCurlObject());
    }

}