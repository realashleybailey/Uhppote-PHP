<?php
require $_SERVER['DOCUMENT_ROOT'] . '/src/vendor/autoload.php';

set_error_handler("warning_handler", E_WARNING);

$DATA = '';

try {

    UhppotePHP\JWT\WebAuth::Verify(getallheaders());

    if (json_decode(file_get_contents('php://input'), true) == null) {
        throw new Exception('No JSON data found');
    }
} catch (Throwable | Exception | Error $e) {
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => ['message' => $e->getMessage()]]);
    exit;
}

$ROUTE  = json_decode(file_get_contents('php://input'), true)['route'];
$DATA   = json_decode(file_get_contents('php://input'), true)['data'];


try {
    \UhppotePHP\API::Route($ROUTE, $DATA);
} catch (Throwable | Exception | Error $e) {
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => ['message' => $e->getMessage()]]);
    exit;
}

restore_error_handler();

function warning_handler($errno, $errstr)
{
    throw new Exception($errstr);
}
