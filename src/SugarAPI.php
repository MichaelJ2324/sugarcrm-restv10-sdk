<?php

namespace SugarAPI\SDK;

use SugarAPI\SDK\Exception\AuthenticationException;
use SugarAPI\SDK\Exception\SDKException;

class SugarAPI {

    const API_URL = '/rest/v10/';

    /**
     * Default Settings for SugarAPI Object.
     * Includes Default Instance, and Default Authentication Ooptions
     * Example:
     *      array(
     *          'instance' => 'localhost',
     *          'auth' => array(
     *              'username' => 'admin',
     *              'password' => 'password',
     *              'client_id' => 'custom_client',
     *              'client_secret' => 's3cr3t',
     *              'platform' => 'custom_app'
     *          )
     *      );
     * @var array
     */
    protected static $_DEFAULTS = array();

    /**
     * The configured instance
     * @var
     */
    protected $instance;

    /**
     * The configured Rest v10 URL
     * @var
     */
    protected $url;

    /**
     * The configured Authentication options
     * @var array
     */
    protected $authOptions = array(
        'username' => '',
        'password' => '',
        'client_id' => '',
        'client_secret' => '',
        'platform' => ''
    );

    /**
     * The authentication token, after successful login to SugarAPI
     * @var
     */
    protected $authToken;

    /**
     * The time in which Auth Token expires, and needs to be refreshed
     * @var
     */
    protected $authExpiration;

    /**
     * The list of registered EntryPoints
     * @var array
     */
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

    /**
     * Configure the static property $_DEFAULTS with settings from defaults.php
     */
    protected function loadDefaults(){
        if (empty(static::$_DEFAULTS)) {
            include __DIR__ . DIRECTORY_SEPARATOR . 'defaults.php';
            if (isset($defaults)) {
                static::$_DEFAULTS = $defaults;
            }
        }
        if (isset(static::$_DEFAULTS['instance'])){
            $this->setInstance(static::$_DEFAULTS['instance']);
        }
        if (isset(static::$_DEFAULTS['auth']) && is_array(static::$_DEFAULTS['auth'])){
            $this->setAuthOptions(static::$_DEFAULTS['auth']);
        }
    }

    /**
     * Configure the Authentication Options being used by SugarAPI Object
     * @param array $options
     */
    public function setAuthOptions(array $options){
        foreach ($this->authOptions as $key => $value){
            if (isset($options[$key])){
                $this->authOptions[$key] = $options[$key];
            }
        }
    }

    /**
     * Register the defined EntryPoints in SDK, located in src/EntryPoint/registry.php file
     * @throws SDKException
     */
    protected function registerSDKEntryPoints(){
        require __DIR__.DIRECTORY_SEPARATOR.'EntryPoint'.DIRECTORY_SEPARATOR.'registry.php';
        foreach ($entryPoints as $funcName => $className){
            $className = "SugarAPI\\SDK\\EntryPoint\\".$className;
            $this->registerEntryPoint($funcName, $className);
        }
    }

    /**
     * Register an EntryPoint method on the SugarAPI object.
     * Allows for loading custom EntryPoints, so long as custom EntryPoints are autoloaded accordingly
     * @param $funcName - name of Method to be called on SugarAPI Object
     * @param $className - full name of EntryPoint Class that will be utilized
     * @throws SDKException
     */
    public function registerEntryPoint($funcName, $className){
        if (isset($this->entryPoints[$funcName])){
            throw new SDKException('SDK method already defined. Method '.$funcName.' references Class '.$className);
        }
        $this->entryPoints[$funcName] = $className;
    }

    /**
     * Generates the EntryPoint objects based on the Method name that was called
     * @param $name
     * @param $params
     * @return mixed
     * @throws AuthenticationException
     * @throws SDKException
     */
    public function __call($name, $params){
        if (array_key_exists($name, $this->entryPoints)){
            $Class = $this->entryPoints[$name];
            $EntryPoint = new $Class($this->url, $params);

            if ($EntryPoint->authRequired()){
                if (isset($this->authToken)){
                    if ($this->authExpired()){
                        $this->refreshAuth();
                    }
                    $EntryPoint->configureAuth($this->authToken->access_token);
                }else{
                    throw new AuthenticationException('Authentication is required for EntryPoint ['.$name.'].');
                }
            }
            return $EntryPoint;
        }else{
            throw new SDKException('Method '.$name.', is not a registered method of the SugarAPI SDK');
        }
    }

    /**
     * Login to the configured SugarCRM instance, and stored the Auth Token
     * @throws AuthenticationException
     */
    public function login(){
        if (empty($this->authOptions['username']) || empty($this->authOptions['password'])){
            throw new AuthenticationException("Username or Password was not provided.");
        }
        $response = $this->oauth2Token()->data($this->authOptions)->execute()->getResponse();
        if ($response->getStatus()=='200'){
            $this->setAuthToken($response->getBody());
        } else{
            throw new AuthenticationException($response->getBody());
        }
    }

    /**
     * Set the current AuthToken and Auth Expiration properties
     * @param stdObject $token
     */
    protected function setAuthToken($token){
        $this->authToken = $token;
        $this->authExpiration = time()+$token->expires_in;
    }

    /**
     * Refresh Auth Token to further API use
     */
    public function refreshAuth(){
        $refreshOptions = array(
            'client_id' => $this->authOptions->client_id,
            'client_secret' => $this->authOptions->client_secret,
            'refresh_token' => $this->authOptions->refresh_token
        );
        $response = $this->oauth2Refresh()->data($refreshOptions)->execute()->getResponse();
        if ($response->getStatus()=='200'){
            $this->setAuthToken($response->getBody());
        } else{
            throw new AuthenticationException($response->getBody());
        }
    }

    /**
     * Check if current access token is expired
     * @return bool
     */
    public function authExpired(){
        return time() >= $this->authExpiration;
    }

    /**
     * Force Logout of SugarAPI Object
     */
    public function logout(){
       if (!empty($this->authToken)){
           $response = $this->oauth2Logout()->execute()->getResponse();
           if ($response->getStatus()=='200'){
               unset($this->authToken);
               unset($this->authExpiration);
           }
       }
    }

    /**
     * Configure the instance that the SugarAPI object will be communicating with
     * @param $instance
     */
    public function setInstance($instance){
        if (strpos("http", $instance)===FALSE){
            $instance = "http://".$instance;
        }
        if (strpos("rest/v10", $instance)!==FALSE){
            $instance = str_replace("rest/v10", "", $instance);
        }
        $this->instance = $instance;
        $this->url = rtrim($this->instance, "/").self::API_URL;
    }

    /**
     * Get the configured Rest v10 URL
     * @return mixed
     */
    public function getURL(){
        return $this->url;
    }

    /**
     * Get the Authentication Token
     * @return mixed
     */
    public function getToken(){
        return $this->authToken;
    }

    /**
     * Get the configured Authentication Options
     * @return array
     */
    public function getAuthOptions(){
        return $this->authOptions;
    }
}