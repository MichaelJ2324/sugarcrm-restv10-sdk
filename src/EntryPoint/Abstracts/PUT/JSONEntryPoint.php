<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts\PUT;

use SugarAPI\SDK\EntryPoint\Abstracts\AbstractEntryPoint;
use SugarAPI\SDK\Request\PUT;

abstract class JSONEntryPoint extends AbstractEntryPoint {

    /**
     * @inheritdoc
     */
    protected function setupRequest(){
        $this->Request = new PUT();
    }

}