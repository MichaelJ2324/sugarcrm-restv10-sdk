<?php

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class GET extends AbstractRequest{

    protected static $_TYPE = 'PUT';

    public function setBody($body){
        $this->body = $body;
        $this->setURL($this->url."?".http_build_query($body));
    }

}