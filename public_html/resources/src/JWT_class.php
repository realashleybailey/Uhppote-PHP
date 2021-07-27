<?php

namespace UhppotePHP\JWT;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class WebAuth
{
    static function Create()
    {
        $secretKey = getenv('JWTkey');
        $issuedAt   = new \DateTimeImmutable();
        $expire     = $issuedAt->modify('+1 hours')->getTimestamp();

        $data = [
            'iat'  => $issuedAt->getTimestamp(),
            'iss'  => $_SERVER['HTTP_HOST'],
            'nbf'  => $issuedAt->getTimestamp(),
            'exp'  => $expire,
        ];

        return JWT::encode(
            $data,
            $secretKey,
            'HS256'
        );
    }

    static function Verify($SERVER)
    {
        $secretKey = getenv('JWTkey');

        if (isset($SERVER['HTTP_AUTHORIZATION'])) {
            if (!preg_match('/Bearer\s(\S+)/', $SERVER['HTTP_AUTHORIZATION'], $matches)) {
                header('HTTP/1.0 400 Bad Request');
                echo 'Token not found in request 1';
                exit;
            }
        }

        $jwt = $matches[1];
        if (!$jwt) {
            // No token was able to be extracted from the authorization header
            header('HTTP/1.0 400 Bad Request');
            exit;
        }

        try {
            $token = JWT::decode($jwt, $secretKey, ['HS256']);
        } catch (ExpiredException $e) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => ['message' => $e->getMessage()]]);
            die();
        }

        $now = new \DateTimeImmutable();
        $serverName = $_SERVER['HTTP_HOST'];

        if (
            $token->iss !== $serverName ||
            $token->nbf > $now->getTimestamp() ||
            $token->exp < $now->getTimestamp()
        ) {
            header('HTTP/1.1 401 Unauthorized');
            die();
        }
    }
}
