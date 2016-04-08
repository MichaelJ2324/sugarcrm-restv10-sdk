<?php

namespace SugarAPI\SDK\EntryPoint\Interfaces;

interface EPInterface {

    /**
     * Set the module on the EntryPoint, that will be accessed via API
     * @param $module
     * @return \SugarAPI\SDK\EntryPoint\Abstracts\AbstractEntryPoint Object
     */
    public function module($module);

    /**
     * Set the URL options on the EntryPoint, such as Record ID
     * @param $module
     * @return SugarAPI\SDK\EntryPoint Object
     */
    public function options(array $options);

    /**
     * The data/payload that will be use by the EntryPoint to be submitted to the API
     * @param array $data
     * @return \SugarAPI\SDK\EntryPoint\Abstracts\AbstractEntryPoint Object
     */
    public function data(array $data);

    /**
     * Check if Authentication is needed
     * @return boolean - if auth is required
     */
    public function authRequired();

    /**
     * Execute the EntryPoint Request
     * @return \SugarAPI\SDK\EntryPoint\Abstracts\AbstractEntryPoint Object
     */
    public function execute();

    /**
     * Get the status of the EntryPoint Request
     * @return integer - HTTP Status Code
     */
    public function status();

    /**
     * Get the module that is set on the EntryPoint
     * @return string - configured module
     */
    public function getModule();

    /**
     * Get the full URL being used by the EntryPoint
     * @return string - configured URL
     */
    public function getURL();

    /**
     * Get the data URL being used by the EntryPoint
     * @return string - configured URL
     */
    public function getData();

    /**
     * Get the Response from the EntryPoint request
     * @return \SugarAPI\SDK\Response\Abstracts\AbstractResponse Object
     */
    public function getResponse();

    /**
     * Get the Request Object being used by the EntryPoint
     * @return \SugarAPI\SDK\Request\Abstracts\AbstractRequest Object
     */
    public function getRequest();

}