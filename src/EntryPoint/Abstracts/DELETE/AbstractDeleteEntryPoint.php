<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts\DELETE;


use SugarAPI\SDK\EntryPoint\Abstracts\AbstractEntryPoint;
use SugarAPI\SDK\Request\DELETE;
use SugarAPI\SDK\Response\JSON;

abstract class AbstractDeleteEntryPoint extends AbstractEntryPoint {

    public function __construct($url, array $options = array()) {
        $this->setRequest(new DELETE());
        parent::__construct($url, $options);
    }

    public function execute($data = null) {
        parent::execute($data);
        $this->setResponse(new JSON($this->Request->getResponse(),$this->Request->getCurlObject()));
        return $this;
    }

}