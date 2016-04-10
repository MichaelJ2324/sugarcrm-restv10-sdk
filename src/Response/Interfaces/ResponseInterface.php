<?php

namespace SugarAPI\SDK\Response\Interfaces;


interface ResponseInterface {

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

    /**
     * Get the Request Errors if they occurred
     * @return string
     */
    public function getError();

}