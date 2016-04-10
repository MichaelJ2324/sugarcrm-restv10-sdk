<?php

namespace SugarAPI\SDK\EntryPoint\DELETE;

use SugarAPI\SDK\EntryPoint\Abstracts\DELETE\JSONEntryPoint as DELETEEntryPoint;

class DeleteRecord extends DELETEEntryPoint {

    protected $_URL = '$module/$record';

}