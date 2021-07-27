<?php
require_once(realpath(dirname(__FILE__) . "/../config.php"));

function template($contentFile, $variables = array())
{
    $contentFileFullPath = TEMPLATES_PATH . "/" . $contentFile;

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
        $error_message = 'Could not find template file: ' . $contentFileFullPath;
        require_once(TEMPLATES_PATH . "/error.php");
    }
}
