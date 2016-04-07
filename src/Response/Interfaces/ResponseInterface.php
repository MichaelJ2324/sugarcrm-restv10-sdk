<?php

namespace SugarAPI\SDK\Response\Interfaces;


interface ResponseInterface {

    public function json($pretty = false);
    public function getStatus();
    public function getBody();
    public function getHeaders();

}