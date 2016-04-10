<?php

namespace SugarAPI\SDK\Request;


class POSTFile extends POST {

    /**
     * @inheritdoc
     */
    protected static $_DEFAULT_HEADERS = array(
        "Content-Type: multipart/form-data"
    );

    /**
     * @inheritdoc
     */
    public function setBody($body) {
        $this->body = $body;
        $this->setOption(CURLOPT_POSTFIELDS,$this->body);
        return $this;
    }

}