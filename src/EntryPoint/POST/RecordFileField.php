<?php

namespace SugarAPI\SDK\EntryPoint\POST;

use SugarAPI\SDK\EntryPoint\Abstracts\POST\FileEntryPoint as POSTFileEntryPoint;

class RecordFileField extends POSTFileEntryPoint {

    protected $_URL = '$module/$record/file/$field';

}