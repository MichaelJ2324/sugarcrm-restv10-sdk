<?php

namespace SugarAPI\SDK\EntryPoint\Interfaces;

interface EPInterface {

    /**
     * Set the module on the EntryPoint, that will be accessed via API
     * @param string
     * @return \SugarAPI\SDK\EntryPoint\Interfaces\EPInterface
     */
    public function module($module);

    /**
     * Set the URL options on the EntryPoint, such as Record ID
     * @param array
     * @return \SugarAPI\SDK\EntryPoint\Interfaces\EPInterface
     */
    public function options(array $options);

    /**
     * The data/payload that will be use by the EntryPoint to be submitted to the API
     * @param mixed
     * @return \SugarAPI\SDK\EntryPoint\Interfaces\EPInterface
     */
    public function data($data);

    /**
     * Check if Authentication is needed
     * @return boolean
     */
    public function authRequired();

    /**
     * Configure OAuth Token on Header
     * @param string
     * @return \SugarAPI\SDK\EntryPoint\Interfaces\EPInterface
     */
    public function configureAuth($accessToken);

    /**
     * Execute the EntryPoint Request
     * @return \SugarAPI\SDK\EntryPoint\Interfaces\EPInterface
     */
    public function execute();

    /**
     * Get the module that is set on the EntryPoint
     * @return string
     */
    public function getModule();

    /**
     * Get the full URL being used by the EntryPoint
     * @return string
     */
    public function getURL();

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