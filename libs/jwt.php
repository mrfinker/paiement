<?php
declare (strict_types = 1);

require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class PhpJwt
{
    private $secretKey;
    private $issuedAt;
    private $expire;
    private $serverName = URL;

    public function __construct()
    {
        $this->secretKey = getenv('JWT_SECRET_KEY');
    }

    public function guard()
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
                header('HTTP/1.1 400 Bad Request');
                echo 'Token not found in request';
                exit;
            } else {
                $jwt = $matches[1];
                if (!$jwt) {
                   header('HTTP/1.1 400 Bad Request');
                    echo 'Token not found in request';
                    exit;
                } else {
                    return $this->validate($jwt);
                }
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo 'Token not found in request';
            exit;

        }
    }

    public function validate($jwt)
    {
        try {
            $token = JWT::decode($jwt, new Key($this->secretKey, 'HS256'));
            return $token;
        } catch (\Exception $e) {
            error_log("Erreur JWT: " . $e->getMessage());
            return false;
        }
    }

}
