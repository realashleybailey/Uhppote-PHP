<?php
require_once(realpath(dirname(__FILE__) . "/resources/config.php"));

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '':
    case '/':
        include_once(__DIR__ . '/login.php');
        break;

    case '/admin':
    case '/admin/':
    case '/admin/main':
    case '/admin/main/':
        template('header.php');
        view('main');
        template('footer.php');
        break;
    case '/admin/test1':
    case '/admin/test1/':
        template('header.php');
        view('test1');
        template('footer.php');
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/404.php';
        break;
}
