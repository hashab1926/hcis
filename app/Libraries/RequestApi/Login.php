<?php

namespace App\Libraries\RequestApi;

use App\Libraries\Api;

class Login
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function authLogin($data)
    {
        $request = $this->api->post('auth_login', $data);

        if ($request->status_code != 200)
            throw new \Exception($request->message);

        $this->api->jwtToken =  $request->access_token;
        $cekCredential = $this->api->get('cek_credential');
        if ($cekCredential->status_code != 200)
            throw new \Exception($request->message);

        // $resultMerge = array_merge($cekCredential->data, $request);
        $cekCredential->access_token = $request->access_token;
        return $cekCredential;
    }
}
