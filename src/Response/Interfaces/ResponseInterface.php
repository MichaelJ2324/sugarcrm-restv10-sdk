<?php

namespace SugarAPI\SDK\Response\Interfaces;


interface ResponseInterface {

    /**
     * Get the JSON Response
     * @param bool $pretty - Pretty Print or not
     * @return string - JSON String of Data
     */
    public function json($pretty = false);

    /**
     * Get the Response HTTP Status Code
     * @return mixed
     */
    public function getStatus();

    /**
     * Get the Response Body
     * @return mixed
     */
    public function getBody();

    /**
     * Get the Response Headers
     * @return mixed
     */
    public function getHeaders();

}