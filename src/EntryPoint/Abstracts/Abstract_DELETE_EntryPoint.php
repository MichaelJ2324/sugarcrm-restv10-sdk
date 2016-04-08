<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts;


use SugarAPI\SDK\Request\DELETE;

abstract class Abstract_DELETE_EntryPoint extends AbstractEntryPoint {

    /**
     * @inheritdoc
     */
    protected function setupRequest(){
        $this->Request = new DELETE();
    }

}