<?php

namespace SugarAPI\SDK\EntryPoint\PUT;

use SugarAPI\SDK\EntryPoint\Abstracts\PUT\AbstractPutEntryPoint;

class ModuleRecord extends AbstractPutEntryPoint {

    /**
     * @inheritdoc
     */
    protected $_URL = '$module/$record';

}