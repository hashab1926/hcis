<?php

namespace App\Libraries\RequestApi\Lainnya;

use App\Libraries\Api;

class Negara
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getNegara($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('negara', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('negara', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }


    public function hapus($listIdNegara)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_negara' => json_encode($listIdNegara)
        ];

        $request = $this->api->post('negara/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("negara/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
