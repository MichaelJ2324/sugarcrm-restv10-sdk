<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts;

use SugarAPI\SDK\Request\PUT;
use SugarAPI\SDK\Response\Standard as StandardResponse;

abstract class Abstract_PUT_EntryPoint extends AbstractEntryPoint{

    protected function setupRequest(){
        $this->Request = new PUT();
    }

}