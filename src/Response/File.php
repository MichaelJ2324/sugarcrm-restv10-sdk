<?php

namespace SugarAPI\SDK\Response;

use SugarAPI\SDK\Response\Abstracts\AbstractResponse;

class File extends AbstractResponse {

    /**
     * @var
     */
    protected $fileName;

    /**
     * File Path for response
     * @var string
     */
    protected $destinationPath;

    public function __construct($curlResponse, $curlRequest,$destination = null) {
        parent::__construct($curlResponse, $curlRequest);
        $this->extractFileName();
        if (!empty($destination)) {
            $this->setupDestiantion($destination);
            $this->writeFile();
        }
    }

    protected function setupDestiantion($destination = null){
        if (empty($destination)){
            $destination = sys_get_temp_dir().'/SugarAPI';
            if (!file_exists($destination)){
                mkdir($destination,0777);
            }
        }
        $this->destinationPath = $destination;
    }

    protected function extractFileName(){
        foreach (explode("\r\n",$this->headers) as $header)
        {
            if (strpos($header,'filename')!==FALSE){
                $this->fileName = substr($header,(strpos($header,"\"")+1),-1);
            }
        }
    }

    public function getFileName(){
        return $this->fileName;
    }

    protected function writeFile(){
        $fileHandle = fopen($this->file(),'w+');
        fwrite($fileHandle,$this->body);
        fclose($fileHandle);
    }

    public function file(){
        return rtrim($this->destinationPath,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$this->fileName;
    }

}