<?php
require_once(realpath(dirname(__FILE__) . "/config.php"));

set_error_handler("warning_handler", E_WARNING);

$DATA = '';

try {

    UhppotePHP\JWT\WebAuth::Verify(getallheaders());

    if (json_decode(file_get_contents('php://input'), true) == null) {
        throw new Exception('No JSON data found');
    }
} catch (Throwable | Exception | Error $e) {
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => ['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()]]);
    exit;
}

$phpInput = json_decode(file_get_contents('php://input'), true);

$ROUTE      = $phpInput['route'];
$DATA       = (isset($phpInput['data'])) ? $phpInput['data'] : '';


try {
    \UhppotePHP\API::Route($ROUTE, $DATA);
} catch (Throwable | Exception | Error $e) {
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => ['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()]]);
    exit;
}

restore_error_handler();

function warning_handler($errno, $errstr)
{
    throw new Exception($errstr);
}
