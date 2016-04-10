<?php

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class PUT extends AbstractRequest{

    protected static $_TYPE = 'PUT';

    protected static $_DEFAULT_HEADERS = array(
        "Content-Type: application/json"
    );

    /**
     * @inheritdoc
     *
     * Set the Curl Custom Request Option to PUT
     */
    protected function setType(){
        parent::setType();
        $this->setOption(CURLOPT_CUSTOMREQUEST, "PUT");
    }

    public function setBody($body) {
        return parent::setBody(json_encode($body));
    }

}