<?php
/**
 * ©[2016] SugarCRM Inc.  Licensed by SugarCRM under the Apache 2.0 license.
 */

namespace SugarAPI\SDK\Request;

use SugarAPI\SDK\Request\Abstracts\AbstractRequest;

class POST extends AbstractRequest {

    /**
     * @inheritdoc
     */
    protected static $_TYPE = 'POST';

    /**
     * @inheritdoc
     */
    protected static $_DEFAULT_HEADERS = array(
        "Content-Type: application/json"
    );

    /**
     * @inheritdoc
     *
     * Set the Curl POST Option to True
     */
    protected function setType(){
        parent::setType();
        $this->setOption(CURLOPT_POST, 1);
    }

    /**
     * JSON Encode Body
     * @inheritdoc
     */
    public function setBody($body){
        return parent::setBody(json_encode($body));
    }
}