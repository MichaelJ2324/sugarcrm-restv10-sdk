<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts\PUT;

use SugarAPI\SDK\EntryPoint\Abstracts\AbstractEntryPoint;
use SugarAPI\SDK\Request\PUT;
use SugarAPI\SDK\Response\JSON;

abstract class AbstractPutEntryPoint extends AbstractEntryPoint {

    public function __construct($url, array $options = array()) {
        $this->setRequest(new PUT());
        parent::__construct($url, $options);
    }

    public function execute($data = null) {
        parent::execute($data);
        $this->setResponse(new JSON($this->Request->getResponse(),$this->Request->getCurlObject()));
        return $this;
    }

}