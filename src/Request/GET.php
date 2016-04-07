<?php

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class GET extends AbstractRequest{

    protected static $_TYPE = 'GET';

    public function setBody($body){
        $this->body = http_build_query($body);
    }
    public function send(){
        $this->setURL($this->url."?".$this->body);
        return parent::send();
    }

}