<?php

exec('cd /var/www/Uhppote-PHP/ && git reset --hard HEAD && git pull', $output);
echo json_encode($output);
