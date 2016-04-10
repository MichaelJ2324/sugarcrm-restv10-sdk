<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts\POST;

use SugarAPI\SDK\Request\POSTFile;
use SugarAPI\SDK\EntryPoint\Abstracts\POST\JSONEntryPoint as POSTEntryPoint;

class FileEntryPoint extends POSTEntryPoint {

    /**
     * @inheritdoc
     */
    protected function setupRequest() {
        $this->Request = new POSTFile();
    }

}