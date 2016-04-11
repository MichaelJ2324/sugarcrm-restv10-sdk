<?php

namespace SugarAPI\SDK\EntryPoint\GET;

use SugarAPI\SDK\EntryPoint\Abstracts\GET\FileEntryPoint as GETFileEntryPoint;

class RecordFileField extends GETFileEntryPoint {

    /**
     * @inheritdoc
     */
    protected $_URL = '$module/$record/file/$field';


}