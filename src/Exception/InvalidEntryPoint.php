<?php

namespace SugarAPI\SDK\Exception;


use SugarAPI\SDK\Exception\Abstracts\AbstractException;

class InvalidEntryPoint extends AbstractException{

    protected $defaultMessage = 'The method you called is not a valid EntryPoint in the SDK.';
    protected $failureCodes = array(
        'missing_ep' => 'The method you called is not a valid EntryPoint in the SDK.'
    );

}