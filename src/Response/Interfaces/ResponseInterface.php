<?php

namespace SugarAPI\SDK\Response\Interfaces;


interface ResponseInterface {

    /**
     * Get the Response HTTP Status Code
     * @return string
     */
    public function getStatus();

    /**
     * Get the Response Body
     * @return string
     */
    public function getBody();

    /**
     * Get the Response Headers
     * @return string
     */
    public function getHeaders();

    /**
     * Get the Request Errors if they occurred
     * @return string
     */
    public function getError();

}