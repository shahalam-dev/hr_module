<?php

$PUBLIC_KEY = getenv('PUBLIC_KEY');
// $keyFilePath = $ROOT_PATH . '/secrets/app_public.key';
$app_public_key_path = $ROOT_PATH . '/secrets/app_public.key';
$user_public_key_path = $ROOT_PATH . '/secrets/user_public.key';


require_once $ROOT_PATH . '/assets/core/lib/jwt/src/JWT.php';
require_once $ROOT_PATH . '/assets/core/lib/jwt/src/Key.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;


class JWToken {
    

    public static function decodeToken($token, $tag)  {
        // global $keyFilePath;
        global $app_public_key_path;
        global $user_public_key_path;

        if ($tag == 'app') {
            $appKey = trim(file_get_contents($app_public_key_path));
            return JWT::decode($token, new Key($appKey, 'RS256'));
        }

        if ($tag == 'user') {
            $usrKey = trim(file_get_contents($user_public_key_path));
            return JWT::decode($token, new Key($usrKey, 'RS256'));
        }

        // $secretKey = trim(file_get_contents($keyFilePath));
        
    }

}

