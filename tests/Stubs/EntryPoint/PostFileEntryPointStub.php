<?php

namespace SugarAPI\SDK\Tests\Stubs\EntryPoint;

use SugarAPI\SDK\EntryPoint\Abstracts\POST\AbstractPostFileEntryPoint;

class PostFileEntryPointStub extends AbstractPostFileEntryPoint {

    protected $_URL = '$test';

    protected $_DATA_TYPE = 'array';

    protected $_REQUIRED_DATA = array(
        'foo' => NULL,
        'bar' => 'foo'
    );

}