<?php

namespace SugarAPI\SDK\EntryPoint\Traits;

use SugarAPI\Exception\EntryPointExecutionFailure;

trait EPTrait {

    protected static $_AUTH_REQUIRED = true;
    protected static $_MODULE;
    protected static $_URL;
    protected static $_REQUIRED_DATA;

    protected $url;
    protected $Module;
    protected $Options = array();
    protected $Data;
    protected $Request;
    protected $Response;

    public function __construct($url,$options = array()){
        $this->url = $url;
        $this->Module = static::$_MODULE;

        if (!empty($this->options)) {
            if (empty($this->module)) {
                if (strpos(static::$_URL, '$module') !== FALSE) {
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
        $this->configureURL();
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
        $this->Data = json_encode($data);
        $this->Request->setBody($data);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function execute(){
        if ($this->verifyURL()) {
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
        return static::$_AUTH_REQUIRED;
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
       return json_decode($this->Data);
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
        $url = static::$_URL;
        if (strpos(static::$_URL,"$")!==FALSE) {
            if (count($this->Options) > 0) {
                $urlParts = explode("/", static::$_URL);
                $o = 0;
                foreach ($urlParts as $key => $part) {
                    if (strpos($part, '$module') !== FALSE) {
                        if (isset($this->module)) {
                            $urlParts[$key] = $this->module;
                            continue;
                        } else {
                            if (isset($this->Options[$o])) {
                                $this->module = $this->Options[$o];
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
     * Verify URL variables have been removed, and that valid number of options were passed.
     * @return bool
     * @throws EntryPointExecutionFailure
     */
    protected function verifyURL(){
        $urlVarCount = substr_count(static::$_URL,"$");
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
        if (empty(static::$_REQUIRED_DATA)){
            return true;
        }else{
            $errors = array();
            foreach(static::$_REQUIRED_DATA as $property){
                if (empty($this->Data[$property])){
                    $errors[] = $property;
                }
            }
            if (count($errors)>0){
                throw new EntryPointExecutionFailure('missing_data',implode($errors,", "));
            }else{
                return true;
            }
        }
    }
}