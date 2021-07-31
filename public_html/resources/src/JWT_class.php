<?php

namespace UhppotePHP\JWT;

use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class WebAuth
{
    static function Create()
    {
        $secretKey = getenv('CRYPTO');
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
        $secretKey = getenv('CRYPTO');
        $matches = [];

        if (isset($SERVER['Authorization'])) {
            if (!preg_match('/Bearer\s(\S+)/', $SERVER['Authorization'], $matches)) {
                header('HTTP/1.0 400 Bad Request');
                echo 'Token not found in request 1';
                exit;
            }
        }

        if (!isset($matches[1])) {
            // No token was able to be extracted from the authorization header
            header('HTTP/1.0 400 Bad Request');
            throw new Exception(json_encode(getallheaders()));
            exit;
        }

        $jwt = $matches[1];

        try {
            $token = JWT::decode($jwt, $secretKey, ['HS256']);
        } catch (ExpiredException $e) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => ['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()]]);
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
