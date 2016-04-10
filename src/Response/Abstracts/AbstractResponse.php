<?php

namespace SugarAPI\SDK\Response\Abstracts;

use SugarAPI\SDK\Response\Interfaces\ResponseInterface;

abstract class AbstractResponse implements ResponseInterface{

    protected $CurlResponse;
    protected $headers;
    protected $body;
    protected $status;
    protected $error;

    public function __construct($curlResponse,$curlRequest){
        $this->CurlResponse = $curlResponse;
        if ($this->checkErrors($curlRequest)) {
            $this->extractResponse($curlRequest);
            $this->setStatus($curlRequest);
        }
    }

    protected function setStatus($curlRequest){
        $this->status = curl_getinfo($curlRequest,CURLINFO_HTTP_CODE);
    }

    protected function extractResponse($curlRequest){
        $header_size = curl_getinfo($curlRequest,CURLINFO_HEADER_SIZE);
        $this->headers = substr($this->CurlResponse, 0, $header_size);
        $this->body = substr($this->CurlResponse, $header_size);
    }

    protected function checkErrors($curlRequest){
        if (curl_errno($curlRequest) !== CURLE_OK) {
            $this->error = curl_error($curlRequest);
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * @inheritdoc
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @inheritdoc
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @inheritdoc
     */
    public function getError(){
        return $this->error;
    }

}