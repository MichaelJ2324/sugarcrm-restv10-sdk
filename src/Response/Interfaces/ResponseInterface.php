<?php

namespace SugarAPI\SDK\Response;


interface ResponseInterface {

    public function json($pretty = false);
    public function getStatus();
    public function getBody();
    public function getHeaders();

}