<?php

namespace SugarAPI\SDK\Response\Abstracts;

use SugarAPI\SDK\Response\ResponseInterface;

abstract class AbstractResponse implements ResponseInterface{

    protected $headers;
    protected $body;
    protected $status;

    public function __construct($curlResponse,$curlRequest){
        $header_size = curl_getinfo($curlRequest,CURLINFO_HEADER_SIZE);
        $this->headers = substr($curlResponse, 0, $header_size);
        $this->body = json_decode(substr($curlResponse, $header_size));
        $this->status = curl_getinfo($curlRequest,CURLINFO_HTTP_CODE);
    }

    public function json($pretty = false){
        if ($pretty){
            return json_encode($this->body,JSON_PRETTY_PRINT);
        }else{
            return json_encode($this->body);
        }
    }
    public function getStatus(){
        return $this->status;
    }
    public function getBody() {
        return $this->body;
    }
    public function getHeaders() {
        return $this->headers;
    }

}