<?php

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class DELETE extends AbstractRequest{

    protected static $_TYPE = 'DELETE';

    protected static $_DEFAULT_HEADERS = array(
        "Content-Type: application/json"
    );

    /**
     * @inheritdoc
     *
     * Set the Curl Custom Request Option to DELETE
     */
    protected function setType(){
        parent::setType();
        $this->setOption(CURLOPT_CUSTOMREQUEST, "DELETE");
    }

    public function setBody($body) {
        return parent::setBody(json_encode($body));
    }

}