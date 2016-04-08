<?php

namespace SugarAPI\SDK\EntryPoint;

use SugarAPI\SDK\EntryPoint\Abstracts\Abstract_PUT_EntryPoint;

class FavoriteRecord extends Abstract_PUT_EntryPoint {

    protected $_URL = '$module/$record/favorite';

}