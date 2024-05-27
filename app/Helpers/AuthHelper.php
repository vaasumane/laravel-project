<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('generateAuthToken')) {
    function generateAuthToken($user)
    {
        $key = config("app.enc_key");
        $payload = [
            'exp' => time() + (int) config('app.auth_token_expire_time'),
            'iat' => $now = time(),
            'jti' => md5(($now) . mt_rand()),
            'username' => $user->username,
            'email' => $user->email,
            'user_id' => $user->id
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
}
