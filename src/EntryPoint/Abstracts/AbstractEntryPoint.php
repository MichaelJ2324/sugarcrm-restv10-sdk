<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts;


use SugarAPI\SDK\EntryPoint\Interfaces\EPInterface;
use SugarAPI\SDK\Exception\EntryPointException;
use SugarAPI\SDK\Request\POST;
use SugarAPI\SDK\Response\JSON as JSONResponse;

abstract class AbstractEntryPoint implements EPInterface {

    /**
     * Whether or not Authentication is Required
     * @var bool
     */
    protected $_AUTH_REQUIRED = true;

    /**
     * The default Module for the EntryPoint
     * @var string
     */
    protected $_MODULE;

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
    protected $_REQUIRED_DATA;

    /**
     * The configured URL for the EntryPoint
     * @var string
     */
    protected $url;

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
        $this->url = $url;
        $this->Module = $this->_MODULE;

        if (!empty($options)) {
            if (empty($this->Module)) {
                if (strpos($this->_URL, '$module') !== FALSE) {
                    $this->module($options[0]);
                    array_shift($options);
                }
            }
            $this->options($options);
        }
        $this->setupRequest();
    }

    /**
     * @inheritdoc
     */
    public function module($module){
        $this->Module = $module;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function options(array $options){
        $this->Options = $options;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function data(array $data){
        $this->Data = $data;
        $this->Request->setBody($this->Data);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function execute(){
        if ($this->verifyURL() && $this->validateData()) {
            $this->configureURL();
            $this->Request->setURL($this->url);
            $this->Request->send();
            $this->setupResponse();
            //Trying to manage memory by closing Curl Resource
            $this->Request->close();
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function authRequired() {
        return $this->_AUTH_REQUIRED;
    }

    /**
     * @inheritdoc
     */
    public function configureAuth($accessToken) {
        if ($this->authRequired()){
            $this->accessToken = $accessToken;
            $this->Request->addHeader('OAuth-Token', $accessToken);
        }
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
    public function getURL(){
        return $this->url;
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
     * Configures the URL, by updating any variable placeholders in the URL property on the EntryPoint
     * - Replaces $module with $this->Module
     * - Replaces all other variables starting with $, with options in the order they were given
     */
    protected function configureURL(){
        $url = $this->_URL;
        if (strpos($this->_URL,"$")!==FALSE) {
            if (count($this->Options) > 0 || !empty($this->Module)) {
                $urlParts = explode("/", $this->_URL);
                $o = 0;
                foreach ($urlParts as $key => $part) {
                    if (strpos($part, '$module') !== FALSE) {
                        if (isset($this->Module)) {
                            $urlParts[$key] = $this->Module;
                            continue;
                        } else {
                            if (isset($this->Options[$o])) {
                                $this->Module = $this->Options[$o];
                                array_shift($this->Options);
                            }
                        }
                    }
                    if (strpos($part, "$") !== FALSE) {
                        if (isset($this->Options[$o])) {
                            $urlParts[$key] = $this->Options[$o];
                            $o++;
                        }
                    }
                }
                $url = implode($urlParts,"/");
            }
        }
        $this->url = $this->url.$url;
    }

    /**
     * Setup the Request Object property, setup on initial Construct of EntryPoint
     */
    protected function setupRequest(){
        $this->Request = new POST();
    }

    /**
     * Setup the Response Object Property, not called until after Request Execution
     */
    protected function setupResponse(){
        $this->Response = new JSONResponse($this->Request->getResponse(),$this->Request->getCurlObject());
    }

    /**
     * Verify URL variables have been removed, and that valid number of options were passed.
     * @return bool
     * @throws EntryPointException
     */
    protected function verifyURL(){
        $urlVarCount = substr_count($this->_URL,"$");
        $optionCount = 0;
        if (!empty($this->Module)){
            $optionCount++;
        }
        $optionCount += count($this->Options);
        if ($urlVarCount!==$optionCount){
            if (empty($this->Module) && strpos($this->_URL,'$module')){
                throw new EntryPointException('Module is required for EntryPoint '.get_called_class());
            }else{
                throw new EntryPointException('EntryPoint URL ('.$this->_URL.') requires more parameters than passed.');
            }
        }else{
            return true;
        }
    }

    /**
     * Validate Required Data for the Request
     * @return bool
     * @throws EntryPointException
     */
    protected function validateData(){
        if (empty($this->_REQUIRED_DATA)||count($this->_REQUIRED_DATA)==0){
            return true;
        }else{
            $errors = array();
            foreach($this->_REQUIRED_DATA as $property){
                if (isset($this->Data[$property]) || $this->Data[$property]!==null){
                    continue;
                }else{
                    $errors[] = $property;
                }
            }
            if (count($errors)>0){
                throw new EntryPointException('EntryPoint requires specific properties in Request data. Missing the following '.implode($errors,","));
            }else{
                return true;
            }
        }
    }

}