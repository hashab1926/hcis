<?php

namespace App\Libraries\RequestApi\UnitKerja;

use App\Libraries\Api;

class Divisi
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getDivisi($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('unit_kerja_divisi', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('unit_kerja_divisi', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }

    public function hapus($listIdDivisi)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_divisi' => json_encode($listIdDivisi)
        ];

        $request = $this->api->post('unit_kerja_divisi/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("unit_kerja_divisi/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
