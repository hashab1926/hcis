<?php

namespace App\Libraries\RequestApi;

use App\Libraries\Api;

class Pengajuan
{

    public function __construct()
    {
        $this->api = new Api();
    }

    public function getPengajuan($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('pengajuan', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
    public function getPengajuanKaryawan($param)
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get('pengajuan/karyawan', arrayToGet($param));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }



    public function getLampiran($id, $data = [])
    {
        $this->api->jwtToken = getToken();
        $request = $this->api->get("lampiran_pengajuan/{$id}", arrayToGet($data));
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function tambah($data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post('pengajuan', $data);
        if ($request->status_code != 201)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubah($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->put("pengajuan/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }

    public function ubahLampiran($id, $data)
    {
        $this->api->jwtToken = getToken();

        $request = $this->api->post("pengajuan/ubah_lampiran/{$id}", $data);
        if ($request->status_code != 200)
            throw new \Exception($request->message);

        return $request;
    }
}
