<?php

namespace App\Libraries\RequestApi;

use App\Libraries\Api;

class Pangkat
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getPangkat($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('pangkat', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('pangkat', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }


    public function hapus($listIdJabatan)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_pangkat' => json_encode($listIdJabatan)
        ];

        $request = $this->api->post('pangkat/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("pangkat/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
