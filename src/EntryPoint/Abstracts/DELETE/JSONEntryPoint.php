<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts\DELETE;


use SugarAPI\SDK\EntryPoint\Abstracts\AbstractEntryPoint;
use SugarAPI\SDK\Request\DELETE;

abstract class JSONEntryPoint extends AbstractEntryPoint {

    /**
     * @inheritdoc
     */
    protected function setupRequest(){
        $this->Request = new DELETE();
    }

}