<?php

namespace SugarAPI\SDK\Request;


class GETFile extends GET {

    /**
     * File to dump response
     * @var resource
     */
    protected $filePath;

    /**
     * File Handle used by Curl
     * @var
     */
    protected $fileHandle;

    /**
     * @inheritdoc
     */
    protected static $_DEFAULT_HEADERS = array();

    /**
     * Set Temp File for File Response
     * @inheritdoc
     */
    public function send(){
        //$this->initFile();
        return parent::send();
    }

    public function setFile($filePath){
        if ($this->status == self::STATUS_INIT) {
            $this->filePath = fopen($filePath, 'w+');
        }
        return $this;
    }

    protected function initFile(){
        if ($this->status == self::STATUS_INIT) {
            if ($this->filePath == NULL) {
                $this->filePath = tempnam(sys_get_temp_dir(), 'SugarAP_SDK_Response_');
            }
        }
        $this->fileHandle = fopen($this->filePath,'w+');
    }

    protected function closeFile(){
        if ($this->status !== self::STATUS_INIT) {
            fclose($this->fileHandle);
        }
    }

    public function getFile(){
        return $this->filePath;
    }

    public function close(){
        $this->closeFile();
        return parent::close();
    }

}