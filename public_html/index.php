<?php
/*
 * Created on Tue Jul 27 2021
 *
 * The MIT License (MIT)
 * Copyright (c) 2021 Uhppote PHP
 * Created by Ashley Bailey
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

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
