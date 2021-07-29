<?php

namespace App\Helpers;

use \Illuminate\Support\Str;
use Firebase\JWT\JWT;

class JwtHelper
{

    private static function getToken($request)
    {
        $header = $request->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }

    private static function getDecodeToken($token)
    {
        return JWT::decode($token, env('APP_KEY'), array('HS256'));
    }

    public static function getDataToken($request)
    {
        if ($request->header('Authorization') == null)
            return false;

        // get token
        $token = self::getToken($request);

        // kalo ada token nya, di decode dulu
        $decodeJwt = self::getDecodeToken($token);

        // cek masa berlaku token nya
        if ($decodeJwt->exp < time())
            return false;

        // kalo lulus validasi
        return [
            'token' => $token,
            'decode' => $decodeJwt
        ];
    }

    public static function getUserToken($token)
    {
        $getToken = self::getDecodeToken($token);

        // ambil data berdasarkan 'id_user', yang ada di token yang sudah di decode
        $user = \App\Models\User::getUser(['id' => $getToken->sub]);

        // kalo user nya ga ada
        if ($user == null)
            return false;

        // kalo ada, maka return data usernya
        return $user;
    }
}
