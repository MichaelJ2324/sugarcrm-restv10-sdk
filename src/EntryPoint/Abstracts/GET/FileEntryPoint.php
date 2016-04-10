<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts\GET;

use SugarAPI\SDK\EntryPoint\Abstracts\GET\JSONEntryPoint as GETEntryPoint;
use SugarAPI\SDK\Request\GETFile;
use SugarAPI\SDK\Response\File as FileResponse;

class FileEntryPoint extends GETEntryPoint {

    /**
     * The directory in which to download the File
     * @var string
     */
    protected $downloadDir = null;

    /**
     * @inheritdoc
     */
    protected function setupRequest() {
        $this->Request = new GETFile();
    }

    /**
     * @inheritdoc
     * File Response Object has option File Destination parameter, which is passed using DownloadDir property
     */
    protected function setupResponse() {
        $this->Response = new FileResponse($this->Request->getResponse(),$this->Request->getCurlObject(),$this->downloadDir);
    }

    /**
     * @param $path
     * @return $this
     */
    public function downloadTo($path){
        $this->downloadDir = $path;
        return $this;
    }

}