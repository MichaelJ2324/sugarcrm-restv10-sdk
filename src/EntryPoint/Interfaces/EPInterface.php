<?php

namespace SugarAPI\SDK\EntryPoint\Interfaces;

use SugarAPI\SDK\Request\Interfaces\RequestInterface;
use SugarAPI\SDK\Response\Interfaces\ResponseInterface;

interface EPInterface {

    /**
     * Set the URL options on the EntryPoint, such as Record ID
     * @param array
     * @return \SugarAPI\SDK\EntryPoint\Interfaces\EPInterface
     */
    public function setOptions(array $options);

    /**
     * Actually sets the data on the EntryPoint, and on the Request object. Raw data is passed here
     * @param $data
     */
    public function setData($data);

    /**
     * Set the full URL that the EntryPoint submits data to
     * @param $url
     */
    public function setUrl($url);

    /**
     * Set the Request Object used by the EntryPoint
     * @param RequestInterface $Request
     * @return mixed
     */
    public function setRequest(RequestInterface $Request);

    /**
     * Set the Response Object used by the EntryPoint
     * @param ResponseInterface $Response
     * @return mixed
     */
    public function setResponse(ResponseInterface $Response);

    /**
     * Configure OAuth Token on Header
     * @param string
     * @return \SugarAPI\SDK\EntryPoint\Interfaces\EPInterface
     */
    public function setAuth($accessToken);

    /**
     * Check if Authentication is needed
     * @return boolean
     */
    public function authRequired();

    /**
     *
     * @param null $data
     * @return mixed
     */
    public function execute($data = null);

    /**
     * Get the module that is set on the EntryPoint
     * @return string
     */
    public function getModule();

    /**
     * Get the full URL being used by the EntryPoint
     * @return string
     */
    public function getUrl();

    /**
     * Get the data URL being used by the EntryPoint
     * @return string
     */
    public function getData();

    /**
     * Get the Response from the EntryPoint request
     * @return \SugarAPI\SDK\Response\Abstracts\AbstractResponse
     */
    public function getResponse();

    /**
     * Get the Request Object being used by the EntryPoint
     * @return \SugarAPI\SDK\Request\Abstracts\AbstractRequest
     */
    public function getRequest();

}