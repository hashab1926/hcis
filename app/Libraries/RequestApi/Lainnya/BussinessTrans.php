<?php

namespace App\Libraries\RequestApi\Lainnya;

use App\Libraries\Api;

class BussinessTrans
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getBussinessTrans($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('bussiness_trans', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('bussiness_trans', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }


    public function hapus($listIdCostCenter)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_bussiness_trans' => json_encode($listIdCostCenter)
        ];

        $request = $this->api->post('bussiness_trans/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("bussiness_trans/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
