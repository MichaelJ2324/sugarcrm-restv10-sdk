<?php

namespace SugarAPI\SDK\EntryPoint\POST;


use SugarAPI\SDK\EntryPoint\Abstracts\POST\AbstractPostEntryPoint;

class ModuleRecordRelationship extends AbstractPostEntryPoint {

    /**
     * @inheritdoc
     */
    protected $_URL = '$module/$record/link/$relationship';

}