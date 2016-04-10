<?php

namespace SugarAPI\SDK\EntryPoint\PUT;

use SugarAPI\SDK\EntryPoint\Abstracts\PUT\JSONEntryPoint as PUTEntryPoint;

class UpdateRecord extends PUTEntryPoint {

    protected $_URL = '$module/$record';

}