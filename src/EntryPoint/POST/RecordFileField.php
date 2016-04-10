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
     * @inheritdoc
     */
    public function data(array $data) {
        foreach($data as $key => $value){
            if (strtolower($key)!=='oauth_token' || strtolower($key)!=='delete_if_fails' || strtolower($key)!=='format'){
                if (strpos($value,'@')===FALSE){
                    $data[$key] = '@'.$value;
                }
            }
        }
        $data['oauth_token'] = $this->accessToken;
        $data['delete_if_fails'] = (isset($data['delete_if_fails'])?$data['delete_if_fails']:true);
        $data['format'] = 'sugar-html-json';
        return parent::data($data);
    }

}