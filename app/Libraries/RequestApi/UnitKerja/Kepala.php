<?php

namespace App\Libraries\RequestApi\UnitKerja;

use App\Libraries\Api;

class Kepala
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getKepala($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('unit_kerja_kepala', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }


    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('unit_kerja_kepala', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }

    public function hapus($listIdKepala)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_kepala' => json_encode($listIdKepala)
        ];

        $request = $this->api->post('unit_kerja_kepala/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("unit_kerja_kepala/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
