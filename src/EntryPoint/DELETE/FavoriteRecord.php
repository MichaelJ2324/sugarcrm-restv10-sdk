<?php

namespace SugarAPI\SDK\EntryPoint\DELETE;

use SugarAPI\SDK\EntryPoint\Abstracts\DELETE\JSONEntryPoint as DELETEJSONEntryPoint;

class FavoriteRecord extends DELETEJSONEntryPoint {

    protected $_URL = '$module/$record/favorite';

}