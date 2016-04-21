<?php

namespace SugarAPI\SDK\EntryPoint\GET;

use SugarAPI\SDK\EntryPoint\Abstracts\GET\AbstractGetEntryPoint;

class ModuleRecordRelationship extends AbstractGetEntryPoint {

    /**
     * @inheritdoc
     */
    protected $_URL = '$module/$record/link/$relationship';

}