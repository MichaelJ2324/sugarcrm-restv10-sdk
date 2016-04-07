<?php

namespace SugarAPI\SDK\Exception;

use SugarAPI\SDK\Exception\Abstracts\AbstractException;

class InitializationFailure extends AbstractException {

    protected $defaultMessage = 'Unknown Initialization Error';
    protected $failureCodes = array(
        'no_default' => 'Default Instance not configured in \'defaults.php\' file, and no instance passed to SugarAPI SDK.',
        'no_ep_registry' => 'Entrypoint registry file did not contain registry.',

    );

}