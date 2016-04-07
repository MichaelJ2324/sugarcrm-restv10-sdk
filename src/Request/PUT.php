<?php

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class PUT extends AbstractRequest{

    protected static $_TYPE = 'PUT';

    protected function setType(){
        parent::setType();
        $this->setOption(CURLOPT_CUSTOMREQUEST, "PUT");
    }

}