<?php

namespace SugarAPI\SDK\Request\Abstracts;

use SugarAPI\SDK\Request\Interfaces\RequestInterface;

abstract class AbstractRequest implements RequestInterface{

    protected static $_TYPE = '';
    protected static $_DEFAULT_OPTIONS = array(
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
        CURLOPT_HEADER => true,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FOLLOWLOCATION => 0
    );
    protected static $_DEFAULT_HEADERS = array(
        "Content-Type: application/json"
    );

    protected $CurlResponse;
    protected $CurlRequest;
    protected $Response;

    protected $headers = array();
    protected $body = '';
    protected $url = '';
    protected $type;

    public function __construct($url = null){
        $this->start();
        if (!empty($url)){
            $this->setURL($url);
        }
        $this->setType();
        foreach(static::$_DEFAULT_OPTIONS as $option => $value){
            $this->setOption($option,$value);
        }
    }

    public function setURL($url) {
        $this->url = $url;
        $this->setOption(CURLOPT_URL,$this->url);
        return $this;
    }
    public function getURL() {
        return $this->url;
    }
    public function addHeader($name, $value) {
        $token = $name.": ".$value;
        $this->headers[] = $token;
    }
    public function setHeaders(array $array = array()) {
        if (count($array)>0) {
            foreach ($array as $key => $value) {
                $this->addHeader($key, $value);
            }
        }
        $this->setOption(CURLOPT_HTTPHEADER, $this->headers);
        return $this;
    }
    public function getHeaders() {
        return $this->headers;
    }
    public function setBody($body) {
        $this->body = json_encode($body);
        $this->setOption(CURLOPT_POSTFIELDS, $this->body);
        return $this;
    }
    public function getBody() {
        return json_decode($this->body);
    }
    public function getCurlObject() {
        return $this->CurlRequest;
    }

    public function setOption($option, $value) {
        curl_setopt($this->CurlRequest, $option, $value);
    }
    public function send() {
        $this->setHeaders();
        $this->CurlResponse = curl_exec($this->CurlRequest);
        return $this;
    }
    public function getResponse(){
       return $this->CurlResponse;
    }

    protected function setType(){
        $this->type = static::$_TYPE;
    }
    public function reset(){
        if (is_object($this->CurlRequest)){
            $this->close();
        }
        $this->start();
    }
    public function start() {
        $this->CurlRequest = curl_init();
    }
    public function close(){
        curl_close($this->CurlRequest);
        unset($this->CurlRequest);
    }
}