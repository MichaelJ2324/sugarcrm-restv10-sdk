<?php

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class DELETE extends AbstractRequest{

    /**
     * @inheritdoc
     */
    protected static $_TYPE = 'DELETE';

    /**
     * @inheritdoc
     */
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

    /**
     * JSON Encode Body
     * @inheritdoc
     */
    public function setBody(array $body) {
        return parent::setBody(json_encode($body));
    }

}