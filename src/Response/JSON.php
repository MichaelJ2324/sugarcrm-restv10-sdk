<?php

namespace SugarAPI\SDK\Response;

use SugarAPI\SDK\Response\Abstracts\AbstractResponse;

class JSON extends AbstractResponse {


    /**
     * Get JSON Response
     */
    public function json(){
        return $this->body;
    }

    /**
     * @inheritdoc
     */
    public function getBody($asArray = true){
        return json_decode($this->body, $asArray);
    }

}