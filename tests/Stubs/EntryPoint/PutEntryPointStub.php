<?php

namespace SugarAPI\SDK\Tests\Stubs\EntryPoint;

use SugarAPI\SDK\EntryPoint\Abstracts\PUT\AbstractPutEntryPoint;

class PutEntryPointStub extends AbstractPutEntryPoint {

    protected $_URL = '$test';

    protected $_DATA_TYPE = 'array';

    protected $_REQUIRED_DATA = array(
        'foo' => NULL,
        'bar' => 'foo'
    );

}