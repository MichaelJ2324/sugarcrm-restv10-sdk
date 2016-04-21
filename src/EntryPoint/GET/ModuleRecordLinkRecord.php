<?php

namespace SugarAPI\SDK\EntryPoint\GET;

use SugarAPI\SDK\EntryPoint\Abstracts\GET\AbstractGetEntryPoint;

class ModuleRecordLinkRecord extends AbstractGetEntryPoint {

    /**
     * @inheritdoc
     */
    protected $_URL = '$module/$record/link/$relationship/$record';

}