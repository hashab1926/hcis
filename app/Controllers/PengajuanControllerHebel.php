<?php

namespace App\Controllers;

use App\Libraries\RequestApi\Pengajuan;
use App\Libraries\RequestApi\JenisPengajuan;
use App\Libraries\Pdf;

class PengajuanController extends BaseController
{
    public function __construct()
    {
        $this->request = service('request');
        $this->pengajuan = new Pengajuan();
        $this->jenis_pengajuan = new JenisPengajuan();
    }

    public function index()
    {
        try {
            $view = 'Pengajuan/Tambah';

            $input = $this->request->getGet();
            $userLogin = $this->credential->cekCredential();
            $data = [
                // 'full_page'         => true,
                'user'              => $userLogin,
                'buat_pengajuan'    => true
            ];

            if (isset($input['jenis_pengajuan'])) {
                switch ($input['jenis_pengajuan']) {
                    case 'perdin_luarkota':
                        $view = 'Pengajuan/Jenis/PerdinLuarKota';
                }
            }
        } catch (\Exception | \Throwable $error) {
            $data = [
                'status_code'    => 400,
                'message'        => $error->getMessage()
            ];
        } finally {
            // printr($data);
            return view($view, $data);
        }
    }

    public function preview($id)
    {
        try {
            $post = $this->request->getPost();

            $dataTemplating = [];
            // data templating input
            if (isset($post['templating'])) {
                $dataTemplating = [
                    'templating' => json_encode($post['templating'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)
                ];
            }

            // printr($dataTemplating);
            $request = $this->jenis_pengajuan->preview($id, $dataTemplating);

            $template = base64_decode($request->encode_template);

            $pdf = new Pdf();
            $pdf->htmlToPdf([
                'paper'  => 'A4',
                'title'  => 'Print',
                'author' => 'Fikri',
                'html'   => $template
            ]);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage() . $error->getFile();
        }
    }

    public function store()
    {
        try {
            $input = $this->request->getPost();
            // cek nama_jenis 
            if (!isset($input['nama_jenis']))
                throw new \Exception('Nama jenis surat tidak terdaftar');

            $data = [
                'nama_jenis'    =>  $this->namaJenis($input['nama_jenis']),
                'data_template' =>  json_encode($input['templating'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)
            ];
            $this->pengajuan->tambah($data);

            $response = [
                'status_code'   => 201,
                'message'       => 'Pengajuan telah ditambahkan',
                'action'        => base_url('pengajuan/tambah')
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    private function namaJenis($nama)
    {
        $text = '';
        switch ($nama) {
            case 'perdin_luarkota':
                $text = 'PD_LKOTA';
                break;
        }

        return $text;
    }
}
