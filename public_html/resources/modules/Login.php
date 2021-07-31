<?php

namespace UhppotePHP\Modules;

use Elegant\Sanitizer\Sanitizer;
use UhppotePHP\UhppoteException;
use UhppotePHP\ExceptionCodes;

class LoginException extends UhppoteException
{
}

class Login
{
    static function POST($DATA)
    {
        session_start();

        $db = new \UhppotePHP\db();

        $DATAclean = [
            'username' => $DATA['username'],
            'password' => $DATA['password'],
            'remember' => $DATA['remember']
        ];

        $FILTERS = [
            'username' => \UhppotePHP\Extensions\Filters\MySQL::class,
            'password' => fn ($value, array $options = []) => md5($value),
            'remember' => \UhppotePHP\Extensions\Filters\Boolean::class
        ];

        $sanatize = new Sanitizer($DATAclean, $FILTERS);
        $clean = $sanatize->sanitize();

        $check = $db->query("SELECT password FROM users_login WHERE username='{$clean['username']}'");

        if ($check->numRows() == 0) {
            throw new LoginException("Account not found!", ExceptionCodes::Login);
        }

        $login = $check->fetchArray();

        if ($login['password'] === $clean['password']) {
            $_SESSION['LOGGED_IN'] = true;
            echo json_encode(['redirect' => '/admin/']);
            exit;
        }

        throw new LoginException("Login details are wrong!", ExceptionCodes::Login);
    }
}
