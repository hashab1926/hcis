<?php

namespace App\Libraries\RequestApi;

use App\Libraries\Api;

class JenisPengajuan
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('jenis_pengajuan', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }

    public function getJenisPengajuan($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('jenis_pengajuan', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
    public function preview($id, $data = [])
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post("jenis_pengajuan/preview/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function getTemplateInput($id)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->get("jenis_pengajuan/template_input/{$id}");
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
