<?php

$config = array(
    "db" => array(
        "db1" => array(
            "dbname" => "database1",
            "username" => "dbUser",
            "password" => "pa$$",
            "host" => "localhost"
        )
    ),
    "urls" => array(
        "baseUrl" => "http://uhppote.vhx.cloud/"
    ),
    "paths" => array(
        "resources" => $_SERVER['DOCUMENT_ROOT'] . "/resources/",
        "images" => array(
            "content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
            "layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
        )
    )
);


/* Paths */
defined("LIBRARY_PATH")
    or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));

defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));



/* Error reporting. */
ini_set("error_reporting", "true");
error_reporting(E_ALL);
