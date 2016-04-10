<?php

namespace SugarAPI\SDK\Request\Abstracts;

use SugarAPI\SDK\Request\Interfaces\RequestInterface;

abstract class AbstractRequest implements RequestInterface{

    const STATUS_INIT = 'initialized';
    const STATUS_SENT = 'sent';
    const STATUS_CLOSED = 'closed';

    /**
     * The HTTP Request Type
     * @var string
     */
    protected static $_TYPE = '';

    /**
     * The Default Curl Options
     * @var array
     */
    protected static $_DEFAULT_OPTIONS = array(
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
        CURLOPT_HEADER => true,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FOLLOWLOCATION => 0
    );

    /**
     * The default HTTP Headers to be added to Curl Request
     * @var array
     */
    protected static $_DEFAULT_HEADERS = array();

    /**
     * The Curl Resource used to actually send data to Sugar API
     * @var - Curl Resource
     */
    protected $CurlResponse;

    /**
     * The raw response from curl_exec
     * @var - Curl Response
     */
    protected $CurlRequest;

    /**
     * List of Headers for Request
     * @var array
     */
    protected $headers = array();

    /**
     * The body of the request or payload. JSON Encoded
     * @var string
     */
    protected $body = '';

    /**
     * The URL the Request is sent to
     * @var string
     */
    protected $url = '';

    /**
     * @var null
     */
    protected $status = null;

    /**
     * The Request Type
     * @var
     */
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

    /**
     * @inheritdoc
     */
    public function setURL($url) {
        $this->url = $url;
        $this->setOption(CURLOPT_URL,$this->url);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getURL() {
        return $this->url;
    }

    /**
     * @inheritdoc
     */
    public function addHeader($name, $value) {
        $token = $name.": ".$value;
        $this->headers[] = $token;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setHeaders(array $array = array()) {
        if (count($array)>0) {
            foreach ($array as $key => $value) {
                $this->addHeader($key, $value);
            }
        }
        $this->setOption(CURLOPT_HTTPHEADER, $this->headers);
        return $this;
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
    public function setBody($body) {
        $this->body = $body;
        $this->setOption(CURLOPT_POSTFIELDS, $this->body);
        return $this;
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
    public function getCurlObject() {
        return $this->CurlRequest;
    }

    /**
     * @inheritdoc
     */
    public function setOption($option, $value) {
        curl_setopt($this->CurlRequest, $option, $value);
    }

    /**
     * @inheritdoc
     */
    public function send() {
        $this->setHeaders();
        $this->CurlResponse = curl_exec($this->CurlRequest);
        $this->status = self::STATUS_SENT;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getResponse(){
        return $this->CurlResponse;
    }

    /**
     * Set the Type on the Request
     */
    protected function setType(){
        $this->type = static::$_TYPE;
    }

    /**
     * @inheritdoc
     */
    public function reset(){
        if (is_object($this->CurlRequest)){
            $this->close();
        }
        $this->start();
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function start() {
        $this->CurlRequest = curl_init();
        $this->status = self::STATUS_INIT;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function close(){
        curl_close($this->CurlRequest);
        unset($this->CurlRequest);
        $this->status = self::STATUS_CLOSED;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCurlStatus() {
        return $this->status;
    }
}