<?php

namespace App\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTToken
{
    public static function CreateToken($userEmail,$userID, $userRole):string
    {
        $key =env('JWT_KEY');
        $payload=[
            'iss'=>'laravel-token',
            'iat'=>time(),
            'exp'=>time()+24*60*60,
            'userEmail'=>$userEmail,
            'userID'=>$userID,
            'role' => $userRole
        ];
        return JWT::encode($payload,$key,'HS256');
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
