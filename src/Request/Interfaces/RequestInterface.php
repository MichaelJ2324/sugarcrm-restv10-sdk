<?php

namespace SugarAPI\SDK\Request\Interfaces;

interface RequestInterface {

    public function setBody($array);
    public function getBody();

    public function addHeader($name,$value);
    public function setHeaders(array $array);
    public function getHeaders();

    public function getCurlObject();

    public function setOption($option,$value);

    public function setURL($url);
    public function getURL();

    public function send();
    public function getResponse();

    public function start();
    public function close();
    public function reset();

}