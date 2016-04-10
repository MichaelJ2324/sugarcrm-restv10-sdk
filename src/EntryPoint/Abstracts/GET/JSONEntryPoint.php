<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts\GET;

use SugarAPI\SDK\EntryPoint\Abstracts\AbstractEntryPoint;
use SugarAPI\SDK\Request\GET;

abstract class JSONEntryPoint extends AbstractEntryPoint {

    /**
     * @inheritdoc
     */
    protected function setupRequest(){
        $this->Request = new GET();
    }

}