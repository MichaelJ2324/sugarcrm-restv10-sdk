<?php

namespace SugarAPI\SDK;

use SugarAPI\SDK\Exception\AuthenticationException;
use SugarAPI\SDK\Exception\SDKException;

class SugarAPI {

    const API_URL = '/rest/v10/';

    protected static $_DEFAULTS = array();

    protected $instance;
    protected $url;

    protected $authOptions = array(
        'grant_type' => 'password',
        'username' => '',
        'password' => '',
        'client_id' => '',
        'client_secret' => '',
        'platform' => ''
    );
    protected $authToken;

    private $entryPoints = array();

    public function __construct($instance = '', array $authOptions = array()){
        $this->loadDefaults();
        if (!empty($instance)){
            $this->setInstance($instance);
        }
        if (!empty($authOptions)){
            $this->setAuthOptions($authOptions);
        }
        $this->registerSDKEntryPoints();
    }

    protected function loadDefaults(){
        include __DIR__.DIRECTORY_SEPARATOR.'defaults.php';
        if (isset($defaults)){
            static::$_DEFAULTS = $defaults;
            if (isset($defaults['instance'])){
                $this->setInstance($defaults['instance']);
            }
            if (isset($defaults['auth']) && is_array($defaults['auth'])){
                $this->setAuthOptions($defaults['auth']);
            }
        }
    }

    public function setAuthOptions(array $options){
        foreach ($this->authOptions as $key => $value){
            if (isset($options[$key])){
                $this->authOptions[$key] = $options[$key];
            }
        }
    }

    protected function registerSDKEntryPoints(){
        require __DIR__.DIRECTORY_SEPARATOR.'EntryPoint'.DIRECTORY_SEPARATOR.'registry.php';
        foreach ($entryPoints as $funcName => $className){
            $className = "SugarAPI\\SDK\\EntryPoint\\".$className;
            $this->registerEntryPoint($funcName, $className);
        }
    }

    public function registerEntryPoint($funcName, $className){
        if (isset($this->entryPoints[$funcName])){
            throw new SDKException('SDK method already defined. Method '.$funcName.' references Class '.$className);
        }
        $this->entryPoints[$funcName] = $className;
    }

    public function __call($name, $params){
        if (array_key_exists($name, $this->entryPoints)){
            $Class = $this->entryPoints[$name];
            $EntryPoint = new $Class($this->url, $params);

            if ($EntryPoint->authRequired()){
                if (isset($this->authToken)){
                    $EntryPoint->configureAuth($this->authToken->access_token);
                }else{
                    throw new AuthenticationException('no_auth');
                }
            }
            return $EntryPoint;
        }else{
            throw new SDKException('Method '.$name.', is not a registered method of the SugarAPI SDK');
        }
    }
    public function login(){
        if (empty($this->authOptions['username']) || empty($this->authOptions['password'])){
            throw new AuthenticationException("Username or Password was not provided.");
        }
        $EP = $this->accessToken();
        $response = $EP->data($this->authOptions)->execute()->getResponse();
        if ($response->getStatus()=='200'){
            $this->authToken = $response->getBody();
        } else{
            throw new AuthenticationException($response->getBody());
        }
    }
    public function setInstance($instance){
        if (strpos("https", $instance)!==FALSE){
            $this->secure = TRUE;
        }
        if (strpos("http", $instance)===FALSE){
            $instance = "http://".$instance;
        }
        if (strpos("rest/v10", $instance)!==FALSE){
            $instance = str_replace("rest/v10", "", $instance);
        }
        $this->instance = $instance;
        $this->url = rtrim($this->instance, "/").self::API_URL;
    }
    public function getURL(){
        return $this->url;
    }
    public function getToken(){
        return $this->authToken;
    }
    public function getAuthOptions(){
        return $this->authOptions;
    }
}