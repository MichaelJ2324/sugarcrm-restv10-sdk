<?php

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class POST extends AbstractRequest{

    protected static $_TYPE = 'POST';

    /**
     * @inheritdoc
     *
     * Set the Curl POST Option to True
     */
    protected function setType(){
        parent::setType();
        $this->setOption(CURLOPT_POST, 1);
    }
}