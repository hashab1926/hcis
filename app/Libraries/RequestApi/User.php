<?php

namespace App\Libraries\RequestApi;

use App\Libraries\Api;

class User
{
    public function __construct()
    {
        $this->api = new Api();
    }


    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('user', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }
}
