<?php

if (isset($_POST['payload']) || isset($_GET['payload'])) {

    exec('cd /var/www/Uhppote-PHP/ && git reset --hard HEAD && git pull', $output);
    echo json_encode($output);
}
