<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

function view($contentFile, $variables = array())
{
    $contentFileFullPath = VIEWS_PATH . "/" . $contentFile . ".php";

    if (count($variables) > 0) {
        foreach ($variables as $key => $value) {
            if (strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }

    if (file_exists($contentFileFullPath)) {
        require_once($contentFileFullPath);
    } else {
        $error_message = 'Could not find views file: ' . $contentFileFullPath;
        require_once(TEMPLATES_PATH . "/error.php");
    }
}
