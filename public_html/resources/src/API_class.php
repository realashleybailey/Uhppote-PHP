<?php

namespace UhppotePHP;

use Error;
use Exception;
use Throwable;

class API
{
    static function Route($ROUTE, $DATA)
    {
        try {
            \UhppotePHP\API\Modules::$ROUTE($DATA);
        } catch (Throwable | Exception | Error $e) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => ['message' => $e->getMessage()]]);
        }
    }
}
