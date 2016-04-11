<?php

namespace SugarAPI\SDK\EntryPoint\POST;

use SugarAPI\SDK\EntryPoint\Abstracts\POST\FileEntryPoint as POSTFileEntryPoint;

class RecordFileField extends POSTFileEntryPoint {

    protected $_URL = '$module/$record/file/$field';

    /**
     * @inheritdoc
     */
    protected $_REQUIRED_DATA = array(
        'format',
        'delete_if_fails',
        'oauth_token'
    );

    /**
     * Allow for shorthand calling of attachFile method.
     * Users can simply submit the File in via string, or pass the filename => path. Options must be configured before shorthand works completely
     * @param mixed $data
     * @return array|mixed
     */
    protected function configureData($data){
        if (!empty($this->Options)){
            $fileField = end($this->Options);
        }
        if (is_string($data) && isset($fileField)){
            $data = array(
                $fileField => $data
            );
        }
        if (is_array($data)){
            if (isset($fileField)){
                $data[$fileField] = $this->setFileFieldValue($data[$fileField]);
            }else{
                foreach ($data as $key => $value){
                    if (strtolower($key)!=='oauth_token' || strtolower($key)!=='delete_if_fails' || strtolower($key)!=='format'){
                        $data[$key] = $this->setFileFieldValue($value);
                    }
                }
            }
            $data['oauth_token'] = $this->accessToken;
            $data['delete_if_fails'] = (isset($data['delete_if_fails'])?$data['delete_if_fails']:TRUE);
            $data['format'] = 'sugar-html-json';
        } elseif (is_object($data) && isset($fileField)){
            $data->$fileField = $this->setFileFieldValue($data->$fileField);
            $data->oauth_token = $this->accessToken;
            $data->delete_if_fails = (isset($data->delete_if_fails)?$data->delete_if_fails:TRUE);
            $data->format = 'sugar-html-json';
        }
        return $data;
    }

    /**
     * Configure the filepath to have an @ symbol in front if one is not found
     * @param string $value
     * @return string
     */
    protected function setFileFieldValue($value){
        if (strpos($value, '@')===FALSE){
            $value = '@'.$value;
        }
        return $value;
    }

}