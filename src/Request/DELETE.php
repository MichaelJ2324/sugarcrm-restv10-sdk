<?php

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class DELETE extends AbstractRequest{

    protected static $_TYPE = 'DELETE';

    /**
     * @inheritdoc
     *
     * Set the Curl Custom Request Option to DELETE
     */
    protected function setType(){
        parent::setType();
        $this->setOption(CURLOPT_CUSTOMREQUEST, "DELETE");
    }

}