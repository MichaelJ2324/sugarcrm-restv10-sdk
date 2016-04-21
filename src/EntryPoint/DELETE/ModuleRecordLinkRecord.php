<?php

namespace SugarAPI\SDK\EntryPoint\DELETE;

use SugarAPI\SDK\EntryPoint\Abstracts\DELETE\AbstractDeleteEntryPoint;

class ModuleRecordLinkRecord extends AbstractDeleteEntryPoint {

    /**
     * @inheritdoc
     */
    protected $_URL = '$module/$record/link/$relationship/$record';

}