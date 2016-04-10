<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts\GET;

use SugarAPI\SDK\EntryPoint\Abstracts\GET\JSONEntryPoint as GETEntryPoint;
use SugarAPI\SDK\Request\GETFile;
use SugarAPI\SDK\Response\File as FileResponse;

class FileEntryPoint extends GETEntryPoint {

    protected $downloadDir = null;

    protected function setupRequest() {
        $this->Request = new GETFile();
    }
    protected function setupResponse() {
        $this->Response = new FileResponse($this->Request->getResponse(),$this->Request->getCurlObject(),$this->downloadDir);
    }

    public function downloadTo($path){
        $this->downloadDir = $path;
        return $this;
    }

}