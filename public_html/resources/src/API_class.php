<?php

namespace UhppotePHP;

use Error;
use Exception;
use Throwable;
// use UhppotePHP\API\Modules;

class API
{

    // use \UhppotePHP\API\Modules;

    static function Route($ROUTE, $DATA)
    {
        $PATH       = "UhppotePHP\\Modules\\" . $ROUTE['path'];
        $MODULE     = $ROUTE['module'];

        $PATH::$MODULE($DATA);
    }
}
