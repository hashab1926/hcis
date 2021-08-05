<?php

namespace App\Controllers\Rekap;

use App\Controllers\BaseController;
use App\Libraries\RequestApi\Pengajuan;
use App\Libraries\Library;
use App\Libraries\Pdf as Pdf;
use App\Libraries\RequestApi\Karyawan;

class ReimburseFaskomController extends BaseController
{

    public function __construct()
    {
        $this->request = service('request');
        $this->pengajuan = new Pengajuan();
        $this->karyawan = new Karyawan();
    }

    public function index()
    {
        try {
            $input = $this->request->getGet();
            $data = [];
            if (isset($input['id'])) {

                $pengajuan = $this->pengajuan->getPengajuan(['id_user' => $input['id']]);
                // cek karyawan
                if ($pengajuan->total_row <= 0)
                    throw new \Exception('Belum ada riwayat pengajuan');

                $source = $pengajuan->data;

                $data = [
                    'pengajuan'  => $source
                ];
            }

            $data = array_merge($data, [
                'status_code'  => 200,
            ]);
        } catch (\Exception | \Throwable $error) {
            $data = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            return view('Pengajuan/Rekap/ReimburseFaskom', $data);
        }
    }



    public function preview($id)
    {
        try {
            $input = $this->request->getGet();

            $id = base64_decode($id);

            $param = [
                'id_user'               => $id,
                'jenis_pengajuan'       => 'reimburse_faskom',
            ];

            // kalo ada tanggal between
            if (isset($input['tgl_awal']) && isset($input['tgl_akhir'])) {
                $param['date_range'] = trim($input['tgl_awal']) . '|' . trim($input['tgl_akhir']);
                $param['reimburse_tahunbulan'] =  'yes';
            }
            // get karyawan
            $pengajuan = $this->pengajuan->getPengajuan($param);
            if ($pengajuan->total_row <= 0)
                throw new \Exception("Belum ada riwayat pengajuan ini");

            $source = $pengajuan->data[0];
            // printr($source);
            // id_pengaju
            $idPengaju = $source->id_pengaju;

            $pengaju = $this->karyawan->getKaryawan(['id' => $idPengaju]);
            // cek pengaju
            if ($pengaju->total_row <= 0)
                throw new \Exception('Pengaju tidak ditemukan');

            $response = [
                'pengajuan'        => $pengajuan->data,
                'pengaju'          => $pengaju->data[0]
            ];

            if ($response['pengaju']->foto != null) {

                $mime = $this->library->mimeTypeBase64Code($response['pengaju']->foto);
                $response['pengaju']->mime = $mime;
            }

            // printr($response);
            $preview = view('Pengajuan/Rekap/PreviewReimburseFaskom', $response);
            // return $preview;
            // echo $preview;
            // exit(1);

            $pdf = new Pdf();
            $pdf->htmlToPdf([
                'paper'  => 'A4',
                'title'  => 'Berkas',
                'author' => 'PT.INTI',
                'html'   => $preview
            ]);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage();
        }
    }
}
