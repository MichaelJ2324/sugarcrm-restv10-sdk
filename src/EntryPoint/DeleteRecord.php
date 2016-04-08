<?php

namespace SugarAPI\SDK\EntryPoint;


use SugarAPI\SDK\EntryPoint\Abstracts\Abstract_DELETE_EntryPoint;

class DeleteRecord extends Abstract_DELETE_EntryPoint {

    protected $_URL = '$module/$record';

}