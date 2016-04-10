<?php

namespace SugarAPI\SDK\Response\Abstracts;

use SugarAPI\SDK\Response\Interfaces\ResponseInterface;

abstract class AbstractResponse implements ResponseInterface{

    /**
     * Full Curl Response
     * @var
     */
    protected $CurlResponse;

    /**
     * Extracted headers from Curl Response
     * @var
     */
    protected $headers;

    /**
     * Extracted body from Curl Response
     * @var
     */
    protected $body;

    /**
     * The HTTP Status Code of Request
     * @var
     */
    protected $status;

    /**
     * The last Curl Error that occurred
     * @var
     */
    protected $error;

    public function __construct($curlResponse,$curlRequest){
        $this->CurlResponse = $curlResponse;
        if ($this->checkErrors($curlRequest)) {
            $this->extractResponse($curlRequest);
        }
        $this->setStatus($curlRequest);
    }

    /**
     * Get the Status from the Curl Resource, and set the status
     * @param $curlRequest - Curl resource
     */
    protected function setStatus($curlRequest){
        $this->status = curl_getinfo($curlRequest,CURLINFO_HTTP_CODE);
    }

    /**
     * Seperate the Headers and Body from the CurlResponse, and set the object properties
     * @param $curlRequest
     */
    protected function extractResponse($curlRequest){
        $header_size = curl_getinfo($curlRequest,CURLINFO_HEADER_SIZE);
        $this->headers = substr($this->CurlResponse, 0, $header_size);
        $this->body = substr($this->CurlResponse, $header_size);
    }

    /**
     * Check Curl Request for errors
     * @param $curlRequest
     * @return bool
     */
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