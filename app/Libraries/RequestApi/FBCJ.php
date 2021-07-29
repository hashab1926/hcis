<?php

namespace App\Libraries\RequestApi;

use App\Libraries\Api;

class FBCJ
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getFBCJ($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('fbcj', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }


    public function getFBCJDetail($param, $id)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get("fbcj_detail/{$id}", arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function getFBCJSubDetail($param, $id)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get("fbcj_sub_detail/{$id}", arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('fbcj', $data);
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
