<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts;


use SugarAPI\SDK\EntryPoint\Interfaces\EPInterface;
use SugarAPI\SDK\Exception\EntryPoint\InvalidURLException;
use SugarAPI\SDK\Exception\EntryPoint\RequiredDataException;
use SugarAPI\SDK\Exception\EntryPoint\RequiredOptionsException;
use SugarAPI\SDK\Response\Interfaces\ResponseInterface;
use SugarAPI\SDK\Request\Interfaces\RequestInterface;

abstract class AbstractEntryPoint implements EPInterface {

    /**
     * Whether or not Authentication is Required
     * @var bool
     */
    protected $_AUTH_REQUIRED = true;

    /**
     * The URL for the EntryPoint
     * - When configuring URL you define URL Parameters with $variables
     *      Examples:
     *          - Forecasts/$record_id
     * - $module Variable is a keyword to place the Module property into the URL
     *      Examples:
     *          - $module/$record
     * - Options property is used to replace variables in the order in which they are passed
     *
     * @var string
     */
    protected $_URL;

    /**
     * An array of Required Data properties that should be passed in the Request
     * @var array
     */
    protected $_REQUIRED_DATA = array();

    /**
     * The required type of Data to be given to the EntryPoint. If none, different types can be passed in.
     * @var string
     */
    protected $_DATA_TYPE;

    /**
     * The configured URL for the EntryPoint
     * @var string
     */
    protected $Url;

    /**
     * The initial URL passed into the EntryPoint
     * @var
     */
    protected $baseUrl;

    /**
     * The configured Module for the EntryPoint
     * @var string
     */
    protected $Module;

    /**
     * The passed in Options for the EntryPoint
     * - If $module variable is used in $_URL static property, then 1st option will be used as Module
     * @var array
     */
    protected $Options = array();

    /**
     * The data being passed to the API EntryPoint
     * @var mixed - array or Std Object
     */
    protected $Data;

    /**
     * The Request Object, used by the EntryPoint to submit the data
     * @var Object
     */
    protected $Request;

    /**
     * The Response Object, returned by the Request Object
     * @var Object
     */
    protected $Response;

    /**
     * Access Token for authentication
     * @var string
     */
    protected $accessToken;


    public function __construct($url,$options = array()){
        $this->baseUrl = $url;

        if (!empty($options)) {
            $this->setOptions($options);
        }elseif(!$this->requiresOptions()){
            $this->configureURL();
        }
    }

    /**
     * @inheritdoc
     */
    public function setOptions(array $options){
        $this->Options = $options;
        if ($this->verifyOptions()){
            $this->configureURL();
        }
        return $this;
    }

    /**
     * @inheritdoc
     * @throws RequiredDataException - When passed in data contains issues
     */
    public function setData($data){
        $this->Data = $data;
        if ($this->verifyData()) {
            $this->Request->setBody($data);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setAuth($accessToken) {
        if ($this->authRequired()){
            $this->accessToken = $accessToken;
            $this->Request->addHeader('OAuth-Token', $accessToken);
        }
        return $this;
    }

    /**
     * @inheritdoc
     * @throws InvalidURLException - When passed in URL contains $variables
     */
    public function setUrl($url) {
        $this->Url = $url;
        if ($this->verifyUrl()) {
            $this->Request->setURL($this->Url);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setRequest(RequestInterface $Request) {
        $this->Request = $Request;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setResponse(ResponseInterface $Response) {
        $this->Response = $Response;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getModule() {
        return $this->Module;
    }

    /**
     * @inheritdoc
     */
    public function getData(){
        return $this->Data;
    }

    /**
     * @inheritdoc
     */
    public function getUrl(){
        return $this->Url;
    }

    /**
     * @inheritdoc
     */
    public function getResponse(){
        return $this->Response;
    }

    /**
     * @inheritdoc
     */
    public function getRequest(){
        return $this->Request;
    }

    /**
     * @inheritdoc
     */
    public function execute($data = null){
        if ($data!==null){
            $this->configureData($data);
        }
        $this->Request->send();
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function authRequired() {
        return $this->_AUTH_REQUIRED;
    }

    /**
     * Override function for configuring Default Values on some EntryPoints to allow for short hand
     */
    protected function configureData($data){
        if (!empty($this->_REQUIRED_DATA)&&is_array($data)){
            foreach($this->_REQUIRED_DATA as $property => $value){
                if (!isset($data[$property])){
                    $data[$property] = $value;
                }
            }
        }
        $this->setData($data);
    }

    /**
     * Configures the URL, by updating any variable placeholders in the URL property on the EntryPoint
     * - Replaces $module with $this->Module
     * - Replaces all other variables starting with $, with options in the order they were given
     */
    protected function configureURL(){
        $url = $this->_URL;
        if ($this->requiresOptions()) {
            $urlParts = explode("/", $this->_URL);
            $o = 0;
            foreach ($urlParts as $key => $part) {
                if (strpos($part, "$") !== FALSE) {
                    if (isset($this->Options[$o])) {
                        $urlParts[$key] = $this->Options[$o];
                        $o++;
                    }
                }
            }
            $url = implode($urlParts,"/");
        }
        $url = $this->baseUrl.$url;
        $this->setUrl($url);
    }

    /**
     * Verify if URL is configured properly
     * @return bool
     * @throws InvalidURLException
     */
    protected function verifyUrl(){
        $UrlArray = explode("?",$this->Url);
        if (strpos($UrlArray[0],"$") !== FALSE){
            throw new InvalidURLException(get_called_class(),"Configured URL is ".$this->Url);
        }
        return true;
    }

    /**
     * Verify URL variables have been removed, and that valid number of options were passed.
     * @return bool
     * @throws RequiredOptionsException
     */
    protected function verifyOptions(){
        $urlVarCount = substr_count($this->_URL,"$");
        $optionCount = 0;
        $optionCount += count($this->Options);
        if ($urlVarCount!==$optionCount){
            throw new RequiredOptionsException(get_called_class(),"URL requires $urlVarCount options.");
        }
        return true;
    }

    /**
     * Validate Required Data for the Request
     * @return bool
     * @throws RequiredDataException
     */
    protected function verifyData(){
        if (isset($this->_DATA_TYPE)||!empty($this->_DATA_TYPE)) {
            if (gettype($this->Data) !== $this->_DATA_TYPE) {
                throw new RequiredDataException(get_called_class(),"Valid DataType is {$this->_DATA_TYPE}");
            }
        }
        if (!empty($this->_REQUIRED_DATA)){
            $errors = array();
            foreach($this->_REQUIRED_DATA as $property => $defaultValue){
                if (!isset($this->Data[$property])){
                    $errors[] = $property;
                }
            }
            if (count($errors)>0){
                throw new RequiredDataException(get_called_class(),"Missing data for $errors");
            }
        }
        return true;
    }

    /**
     * Checks if EntryPoint URL contains requires Options
     * @return bool
     */
    protected function requiresOptions(){
        return strpos($this->_URL,"$") !== FALSE?TRUE:FALSE;
    }

}