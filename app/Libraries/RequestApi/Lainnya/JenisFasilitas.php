<?php

namespace App\Libraries\RequestApi\Lainnya;

use App\Libraries\Api;

class JenisFasilitas
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getJenisFasilitas($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('jenis_fasilitas', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('jenis_fasilitas', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }


    public function hapus($listIdJenisFasilitas)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_jenis_fasilitas' => json_encode($listIdJenisFasilitas)
        ];

        $request = $this->api->post('jenis_fasilitas/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("jenis_fasilitas/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
