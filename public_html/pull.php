<?php

if (isset($_GET['payload']) || isset($_POST['payload'])) {
    shell_exec('cd /var/www/Uhppote-PHP/ && git reset --hard HEAD && git pull');
}
