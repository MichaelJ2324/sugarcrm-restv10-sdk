<?php

namespace SugarAPI\SDK\EntryPoint\POST;

use SugarAPI\SDK\EntryPoint\Abstracts\POST\AbstractPostEntryPoint;

class Bulk extends AbstractPostEntryPoint {

    /**
     * @inheritdoc
     */
    protected $_URL = 'bulk';

    /**
     * @inheritdoc
     */
    protected $_DATA_TYPE = 'array';

    /**
     * @inheritdoc
     */
    protected $_REQUIRED_DATA = array(
        'requests' => NULL
    );

    private $bulkRequest = array(
        'url' => '',
        'data' => '',
        'headers' => array(),
        'method' => ''
    );

    protected function configureData($data) {
        $requestData = array(
            'requests' => array()
        );
        $counter = 0;
        foreach($data as $key => $EntryPoint){
            if (is_object($EntryPoint)) {
                $requestData['requests'][$counter] = $this->bulkRequest;
                $requestData['requests'][$counter]['method'] = $EntryPoint->getRequest()->getType();
                if ($requestData['requests'][$counter]['method'] == "POST" || $requestData['requests'][$counter]['method'] == "PUT") {
                    $requestData['requests'][$counter]['data'] = json_encode($EntryPoint->getData());
                } else {
                    unset($requestData['requests'][$counter]['data']);
                }
                $requestData['requests'][$counter]['headers'] = $EntryPoint->getRequest()->getHeaders();
                $requestData['requests'][$counter]['url'] = "v10/" . str_replace($this->baseUrl, "", $EntryPoint->getUrl());

                $counter++;
            }
        }
        $data = $requestData;
        parent::configureData($data);
    }
}