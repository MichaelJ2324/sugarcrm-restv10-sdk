<?php

namespace SugarAPI\SDK\Tests\Stubs;

use SugarAPI\SDK\EntryPoint\Abstracts\POST\AbstractPostEntryPoint;

class PostEntryPointStub extends AbstractPostEntryPoint {

    protected $_URL = '$test';

    protected $_DATA_TYPE = 'array';

    protected $_REQUIRED_DATA = array(
        'foo' => NULL,
        'bar' => 'foo'
    );

}