<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts\GET;

use SugarAPI\SDK\EntryPoint\Abstracts\AbstractEntryPoint;
use SugarAPI\SDK\Request\GETFile;
use SugarAPI\SDK\Response\File as FileResponse;

abstract class AbstractGetFileEntryPoint extends AbstractEntryPoint {

    /**
     * The directory in which to download the File
     * @var string
     */
    protected $downloadDir = null;

    public function __construct($url, array $options = array()) {
        $this->setRequest(new GETFile());
        parent::__construct($url, $options);
    }

    public function execute($data = null) {
        parent::execute($data);
        $this->setResponse(new FileResponse($this->Request->getResponse(),$this->Request->getCurlObject(),$this->downloadDir));
        return $this;
    }

    /**
     * Set the download directory for the File the EntryPoint is retrieving
     * @param $path
     * @return $this
     */
    public function downloadTo($path){
        $this->downloadDir = $path;
        return $this;
    }

}