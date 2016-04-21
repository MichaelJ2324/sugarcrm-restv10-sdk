<?php

namespace SugarAPI\SDK\EntryPoint\GET;

use SugarAPI\SDK\EntryPoint\Abstracts\GET\AbstractGetEntryPoint;

class ModuleRecordAudit extends AbstractGetEntryPoint {

    /**
     * @inheritdoc
     */
    protected $_URL = '$module/$record/audit';

}