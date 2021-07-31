<?php

if ($_POST['payload']) {
    $dir = realpath(__DIR__ . '/../');
    // shell_exec('cd ' . $dir . ' && git reset –hard HEAD && git pull');
}
