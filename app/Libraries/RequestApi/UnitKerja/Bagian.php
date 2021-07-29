<?php

namespace App\Libraries\RequestApi\UnitKerja;

use App\Libraries\Api;

class Bagian
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getBagian($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('unit_kerja_bagian', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }


    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('unit_kerja_bagian', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }

    public function hapus($listIdBagian)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_bagian' => json_encode($listIdBagian)
        ];

        $request = $this->api->post('unit_kerja_bagian/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("unit_kerja_bagian/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
