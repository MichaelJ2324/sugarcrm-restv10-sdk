<?php

namespace SugarAPI\SDK\Response;

use SugarAPI\SDK\Response\Abstracts\AbstractResponse;

class File extends AbstractResponse {

    /**
     * The name of the File from Response
     * @var string
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
            $this->setupDestination($destination);
            $this->writeFile();
        }
    }

    /**
     * Configure the Destination path to store the File response
     * @param null $destination
     */
    protected function setupDestination($destination = null){
        if (empty($destination)){
            $destination = sys_get_temp_dir().'/SugarAPI';
            if (!file_exists($destination)){
                mkdir($destination,0777);
            }
        }
        $this->destinationPath = $destination;
    }

    /**
     * Extract the filename from the Headers, and store it in filename property
     */
    protected function extractFileName(){
        foreach (explode("\r\n",$this->headers) as $header)
        {
            if (strpos($header,'filename')!==FALSE){
                $this->fileName = substr($header,(strpos($header,"\"")+1),-1);
            }
        }
    }

    /**
     * Return the filename found in response
     * @return mixed
     */
    public function getFileName(){
        return $this->fileName;
    }

    /**
     * Write the downloaded file
     * @return string|boolean - False if not written
     */
    public function writeFile(){
        if (!empty($this->fileName)){
            $file = $this->file();
            $fileHandle = fopen($file,'w+');
            fwrite($fileHandle,$this->body);
            fclose($fileHandle);
            return $file;
        }else{
            return false;
        }

    }

    /**
     * Return the full File path, where Response was stored
     * @return string
     */
    public function file(){
        return rtrim($this->destinationPath,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$this->fileName;
    }

}