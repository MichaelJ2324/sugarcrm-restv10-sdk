<?php

namespace SugarAPI\SDK;

use SugarAPI\Exception\InitializationFailure;
use SugarAPI\Exception\InvalidEntryPoint;
use SugarAPI\Exception\AuthenticationError;

class SugarAPI {

    const API_URL = '/rest/v10/';

    protected static $_DEFAULTS = array();

    protected $instance;
    protected $url;
    protected $secure = false;

    protected $authOptions = array(
        'grant_type' => 'password',
        'username' => '',
        'password' => '',
        'client_id' => 'SugarAPI-SDK',
        'client_secret' => 'SugarAPI-SDK-Secret',
        'platform' => 'api'
    );
    protected $authToken;

    private $entryPoints = array();

    public function __construct($instance='',array $authOptions = array()){
        $this->loadDefaults();
        if (!empty($instance)){
            $this->setInstance($instance);
        }
        if (!empty($authOptions)){
            $this->configureAuth($authOptions);
        }
        $this->registerEntryPoints();
    }

    protected function loadDefaults(){
        include __DIR__ . 'defaults.php';
        if (isset($defaults)) {
            static::$_DEFAULTS = $defaults;
            if (isset($defaults['instance'])){
                $this->setInstance($defaults['instance']);
            }
            if (isset($defaults['auth']) && is_array($defaults['auth'])){
                $this->configureAuth($defaults['auth']);
            }
        }
    }

    public function configureAuth(array $options){
        foreach($this->authOptions as $key => $value){
            if (isset($options[$key])){
                $this->authOptions[$key] = $options[$key];
            }
        }
    }

    protected function registerEntryPoints(){
        require __DIR__ . 'EntryPoint' .DIRECTORY_SEPARATOR.'registry.php';
        if (isset($entryPoints)){
            $this->entryPoints = $entryPoints;
        }else{
            throw new InitializationFailure('no_ep_registry');
        }
    }

    public function __call($name,$params){
        if (array_key_exists($name,$this->entryPoints)){
            $className = "SugarAPI\\SDK\\EntryPoint\\".$this->entryPoints[$name];
            $EntryPoint = new $className($this->url,$params);

            if ($EntryPoint->authRequired()){
                $EntryPoint->getRequest()->addHeader('OAuth-Token',$this->authToken['access_token']);
            }
            return $EntryPoint;
        }else{
            throw new InvalidEntryPoint('invalid_ep');
        }
    }
    public function login(){
        if (empty($this->authOptions['username']) || empty($this->authOptions['password'])){
            throw new AuthenticationError('missing_user_pass');
        }
        $EP = $this->oauth2Token();
        $this->authToken = $EP->data($this->authOptions)->execute()->getResponse()->getBody();
    }
    public function setInstance($instance){
        if (str_pos("https",$instance)!==FALSE){
            $this->secure = TRUE;
        }
        if (str_pos("http",$instance)===FALSE){
            $instance = "http://".$instance;
        }
        if (strpos("rest/v10",$instance)!==FALSE){
            $instance = str_replace("rest/v10","",$instance);
        }
        $this->instance = $instance;
        $this->url = rtrim($this->instance,"/").self::API_URL;
    }
    public function getURL(){
        return $this->url;
    }
    public function getToken(){
        return $this->authToken;
    }
}