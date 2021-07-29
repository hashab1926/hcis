<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Libraries\Api;
use Exception;

class SeedKaryawan extends Seeder
{
    private $api;

    public function __construct()
    {
        $this->api = new Api();
    }
    public function run()
    {
        try {

            $kodeNip = ["PK", "IL", "UZ", "UK", "YG", "GL", "RT", "RE"];
            $idPangkat = [1, 2, 3, 4, 5, 6, 7];
            $idJabatan = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
            $idDivisi = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            $this->api->jwtToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlhdCI6MTYyNTEyMTU3NiwiZXhwIjoxNjI1MTM5NTc2fQ.l80_-Df95Tf7024iFuNNUBzgPSnefH6OZhT1Nf_eu2g";
            for ($x = 1; $x < 1000; $x++) {
                $data = [
                    'nip'                   => "{$kodeNip[rand(0, count($kodeNip) - 1)]}." . rand(100000, 1000000),
                    'nama_karyawan'         => static::faker()->name,
                    'id_pangkat'            => $idPangkat[rand(0, count($idPangkat) - 1)],
                    'id_jabatan'            => $idJabatan[rand(0, count($idJabatan) - 1)],
                    'id_unit_kerja_divisi'  => $idDivisi[rand(0, count($idDivisi) - 1)],
                    'email'                 => static::faker()->email,

                ];
                $request = $this->api->post("karyawan", $data);
                if ($request->status_code != 201)
                    throw new \Exception($request->message);
            }
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage();
        }
    }
}
