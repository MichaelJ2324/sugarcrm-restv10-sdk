<?php

namespace SugarAPI\SDK\EntryPoint\DELETE;

use SugarAPI\SDK\EntryPoint\Abstracts\DELETE\AbstractDeleteEntryPoint;

class ModuleRecordFileField extends AbstractDeleteEntryPoint {

    /**
     * @inheritdoc
     */
    protected $_URL = '$module/$record/file/$field';

}