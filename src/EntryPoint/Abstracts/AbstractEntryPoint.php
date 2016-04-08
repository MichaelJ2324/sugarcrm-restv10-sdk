<?php

namespace SugarAPI\SDK\EntryPoint\Abstracts;


use SugarAPI\SDK\EntryPoint\Interfaces\EPInterface;
use SugarAPI\SDK\Request\POST;
use SugarAPI\SDK\Response\Standard as StandardResponse;

abstract class AbstractEntryPoint implements EPInterface {

    protected $_AUTH_REQUIRED = true;
    protected $_MODULE;
    protected $_URL;
    protected $_REQUIRED_DATA;

    protected $url;
    protected $Module;
    protected $Options = array();
    protected $Data;
    protected $Request;
    protected $Response;

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
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function status(){
        $this->Request->getStatus();
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
    public function getModule() {
        return $this->Module;
    }

    /**
     *
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
     * - Replcaes all other variables starting with $, with options in the order they were given
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
        $this->Response = new StandardResponse($this->Request->getResponse(),$this->Request->getCurlObject());
    }

    /**
     * Verify URL variables have been removed, and that valid number of options were passed.
     * @return bool
     * @throws EntryPointExecutionFailure
     */
    protected function verifyURL(){
        $urlVarCount = substr_count($this->_URL,"$");
        $optionCount = 0;
        if (!empty($this->Module)){
            $optionCount++;
        }
        $optionCount += count($this->Options);
        if ($urlVarCount!==$optionCount){
            if (empty($this->Module)){
                throw new EntryPointExecutionFailure('missing_module');
            }else{
                throw new EntryPointExecutionFailure('missing_options');
            }
        }else{
            return true;
        }
    }

    /**
     * @return bool
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
                throw new EntryPointExecutionFailure('missing_data');
            }else{
                return true;
            }
        }
    }

}