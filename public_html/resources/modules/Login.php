<?php

namespace UhppotePHP\Modules;

use Elegant\Sanitizer\Sanitizer;

class Login
{
    static function POST($DATA)
    {
        session_start();

        $db = new \UhppotePHP\db();

        $DATAclean = [
            'username' => $DATA['username'],
            'password' => crypt($DATA['password'], getenv('CRYPTO')),
            'remember' => $DATA['remember']
        ];

        $FILTERS = [
            'username' => \UhppotePHP\Extensions\Filters\MySQL::class,
            'password' => fn ($value, array $options = []) => crypt($value, getenv('CRYPTO')),
            'remember' => \UhppotePHP\Extensions\Filters\Boolean::class
        ];

        $sanatize = new Sanitizer($DATAclean, $FILTERS);
        $clean = $sanatize->sanitize();

        $check = $db->query("SELECT password FROM users_login WHERE username='{$clean['username']}'")->fetchArray();

        if ($clean['password'] == (isset($check['password'])) ? $check['password'] : '') {
            $_SESSION['LOGGED_IN'] = true;
        }

        echo json_encode(['redirect' => '/admin/']);
    }
}
