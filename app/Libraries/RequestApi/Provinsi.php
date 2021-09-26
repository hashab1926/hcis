<?php

namespace App\Libraries\RequestApi;

use App\Libraries\Api;

class Provinsi
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getProvinsi($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('provinsi', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('provinsi', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }


    public function hapus($listIdProvinsi)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_provinsi' => json_encode($listIdProvinsi)
        ];

        $request = $this->api->post('provinsi/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("provinsi/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
