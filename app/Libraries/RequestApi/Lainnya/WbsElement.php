<?php

namespace App\Libraries\RequestApi\Lainnya;

use App\Libraries\Api;

class WbsElement
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getWbsElement($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('wbs_element', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('wbs_element', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }


    public function hapus($listIdWbsElement)
    {
        $this->api->jwtToken = getToken();
        $data = [
            'id_wbs_element' => json_encode($listIdWbsElement)
        ];

        $request = $this->api->post('wbs_element/multiple_delete', $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("wbs_element/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
