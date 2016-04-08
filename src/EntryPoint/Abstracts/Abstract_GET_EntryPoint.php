<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts;

use SugarAPI\SDK\Request\GET;

abstract class Abstract_GET_EntryPoint extends AbstractEntryPoint {

    /**
     * @inheritdoc
     */
    protected function setupRequest(){
        $this->Request = new GET();
    }

}