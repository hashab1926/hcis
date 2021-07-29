<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;

class AuthLogin
{

    public function handle($request, Closure $next)
    {
        try {
            // kalo token nya ga ada
            if ($request->header('Authorization') == null)
                throw new \Exception('Forbidden Access : anda tidak punya hak akses untuk mengakses halaman ini', 403);

            // get token
            $token = $this->getToken($request);

            // kalo ada token nya, di decode dulu
            $decodeJwt = JWT::decode($token, env('APP_KEY'), array('HS256'));

            // cek masa berlaku token nya
            if ($decodeJwt->exp < time())
                throw new \Exception('Masa belaku token habis, silahkan login kembali', 403);

            return $next($request);
        } catch (\Exception $Error) {
            return [
                'status_code' => 403,
                'message'     => $Error->getMessage()
            ];
        }
    }

    public function getToken($request)
    {
        $header = $request->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }
}
