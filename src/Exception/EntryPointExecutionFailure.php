<?php
/**
 * Created by PhpStorm.
 * User: mrussell
 * Date: 4/6/16
 * Time: 11:34 AM
 */

namespace SugarAPI\Exception;


use SugarAPI\Exception\Abstracts\AbstractException;

class EntryPointExecutionFailure extends AbstractException{

    protected $defaultMessage = 'Unknown error occurred, when creating API EntryPoint.';
    protected $failureCodes = array(
        'missing_options' => 'API EntryPoint URL requires more parameters than were passed into Object.',
        'missing_module' => 'API EntryPoint requires Module to be set. Please pass the Module in the options, or use the setModule method.',
    );

}