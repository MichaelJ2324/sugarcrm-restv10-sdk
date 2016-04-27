<?php

namespace SugarAPI\SDK\Tests\Stubs\EntryPoint;

use SugarAPI\SDK\EntryPoint\Abstracts\GET\AbstractGetFileEntryPoint;

class GetFileEntryPointStub extends AbstractGetFileEntryPoint {

    protected $_URL = '$test';

    protected $_DATA_TYPE = 'array';

    protected $_REQUIRED_DATA = array(
        'foo' => NULL,
        'bar' => 'foo'
    );

}