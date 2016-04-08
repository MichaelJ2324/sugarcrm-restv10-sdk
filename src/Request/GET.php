<?php

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class GET extends AbstractRequest{

    protected static $_TYPE = 'GET';

    /**
     * @inheritdoc
     *
     * Convert Body to Query String
     */
    public function setBody($body){
        $this->body = http_build_query($body);
    }

    /**
     * @inheritdoc
     *
     * Configure the URL with Body since Payload is sent via Query String
     */
    public function send(){
        $this->setURL($this->url."?".$this->body);
        return parent::send();
    }

}