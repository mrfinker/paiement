<?php
declare(strict_types=1);

require_once('vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class PhpJwt {
    private  $secretKey  = SECRET_KEY_AT;
    private  $issuedAt;
    private  $expire; 
    private  $serverName = URL;
    
    public function __construct()
    {
 
    }

    public function guard()
    {
        # code...
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            # code...
            if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
                header('HTTP/1.1 400 Bad Request');
                echo 'Token not found in request';
                exit;
            }else{
                $jwt = $matches[1];
                if (!$jwt) {
                    // No token was able to be extracted from the authorization header
                    header('HTTP/1.1 400 Bad Request');
                    echo 'Token not found in request';
                    exit;
                }else{
                    return $this->validate($jwt);
                }
            }
        }else {
            # code...
            header('HTTP/1.1 400 Bad Request');
            echo 'Token not found in request';
            exit;

        }
    }

    public function validate($jwt)
    {
        # code...
        try {
            //code...
            $token = JWT::decode($jwt,new Key($this->secretKey,'HS256'));
            return $token;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
       
      
        
    }

}