<?php

namespace App\Helper;

// to use firebase JWT library, command: (composer require firebase/php-jwt)
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTToken
{
    public static function CreateToken($userEmail,$userID, $userRole):string
    {
        $key =env('JWT_KEY');
        $payload=[
            //mendory keys
            'iss'=>'laravel-token',// who (issued) the token [laravel-token is just a string you can change as wished]
            'iat'=>time(), //(Issued At)  when this token was generated (time() unix timestamp since 1970)
            'exp'=>time()+24*60*60,// from now after 24 hours the token will be expired

            //custom key // 'name'=>variable
            'userEmail'=>$userEmail,
            'userID'=>$userID,
            'role' => $userRole
        ];
        return JWT::encode($payload,$key,'HS256');// ne token return
        // HS256	Symmetric	 Uses one secret key (like your JWT_KEY) for both signing and verify
        //RS256	Asymmetric	Uses private key to sign, public key to verify
        //ES256	Asymmetric	Uses Elliptic Curve Cryptography (more secure but slower)
    }

    public static function ReadToken($token): ?object
    {
        try {
            if ($token == null) {
                return null;
            } else {
                $key = env('JWT_KEY');
                return JWT::decode($token, new Key($key, 'HS256'));
            }
        } catch (Exception $e) {
            return null;
        }
    }

}
