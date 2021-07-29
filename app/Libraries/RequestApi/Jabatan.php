<?php

namespace App\Libraries\RequestApi;

use App\Libraries\Api;

class Jabatan
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getJabatan($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('jabatan', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('jabatan', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }


    public function hapus($listIdJabatan)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_jabatan' => json_encode($listIdJabatan)
        ];

        $request = $this->api->post('jabatan/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("jabatan/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
