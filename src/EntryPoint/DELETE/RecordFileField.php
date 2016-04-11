<?php

namespace SugarAPI\SDK\EntryPoint\DELETE;

use SugarAPI\SDK\EntryPoint\Abstracts\DELETE\JSONEntryPoint as DELETEJSONEntryPoint;

class RecordFileField extends DELETEJSONEntryPoint {

    protected $_URL = '$module/$record/file/$field';

}