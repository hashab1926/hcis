<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use App\Helpers\JwtHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Laravel\Lumen\Routing\Controller as BaseController;

class CredentialController extends BaseController
{
    public function cekCredential(Request $request)
    {
        try {
            $getToken =  JwtHelper::getDataToken($request);

            // cek token nya dulu
            if ($getToken === false)
                throw new \Exception('Forbidden Access : anda tidak punya hak akses untuk mengakses halaman ini', 403);

            // ambil 'id_user' dari hasil decode token
            // $idUser = $getToken['decode']->sub;

            $userToken = JwtHelper::getUserToken($getToken['token']);

            // cek datanya, ada atau ga
            if ($userToken === null)
                throw new \Exception('Token anda sepertinya kadaluarsa, silahkan login kembali', 403);

            if (count($userToken['data']) <= 0)
                throw new \Exception('User tidak ditemukan');

            // set message response
            $Response = [
                'status_code' => 200,
                'data'        => $userToken['data'][0]
            ];
        } catch (\Throwable $Error) {
            $Response = [
                'status_code' => 400,
                'message' => $Error->getMessage()
            ];
        } catch (\Exception $Error) {
            $Response = [
                'status_code' => $Error->getCode(),
                'message' => $Error->getMessage()
            ];
        } finally {
            return response()->json($Response);
        }
    }
}
