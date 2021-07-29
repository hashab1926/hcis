<?php

namespace App\Libraries\RequestApi\Lainnya;

use App\Libraries\Api;

class CostCenter
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getCostCenter($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('cost_center', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('cost_center', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }


    public function hapus($listIdCostCenter)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_cost_center' => json_encode($listIdCostCenter)
        ];

        $request = $this->api->post('cost_center/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("cost_center/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
