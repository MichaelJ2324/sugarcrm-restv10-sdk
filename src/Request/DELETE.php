<?php

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class DELETE extends AbstractRequest{

    protected static $_TYPE = 'DELETE';

    protected function setType(){
        parent::setType();
        $this->setOption(CURLOPT_CUSTOMREQUEST, "DELETE");
    }

}