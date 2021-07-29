<?php

namespace App\Libraries\RequestApi;

use App\Libraries\Api;

class Karyawan
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getKaryawan($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('karyawan', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('karyawan', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }

    public function hapus($listIdKaryawan)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_karyawan' => json_encode($listIdKaryawan)
        ];

        $request = $this->api->post('karyawan/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post("karyawan/update/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
