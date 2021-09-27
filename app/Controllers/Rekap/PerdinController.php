<?php

namespace App\Controllers\Rekap;

use App\Controllers\BaseController;
use App\Libraries\RequestApi\Pengajuan;
use App\Libraries\Library;
use App\Libraries\Pdf as Pdf;
use App\Libraries\RequestApi\Karyawan;

class PerdinController extends BaseController
{

    use ParamDatatable;

    public function __construct()
    {
        $this->request = service('request');
        $this->pengajuan = new Pengajuan();
        $this->karyawan = new Karyawan();
    }

    public function index()
    {
        return view('Pengajuan/Rekap/PerjalananDinas');
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();


            // param datatable
            $param = $this->paramDatatable($input);


            $get = $this->pengajuan->getPengajuanKaryawan($param);

            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => $get->total_row,
                'recordsFiltered' => $get->total_row,
                'data'           => $get->data
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => 0,
                'recordsFiltered' => 0,
                'data'           => [],
                'message'        => $error->getMessage()
            ];
        } finally {
            echo json_encode($response);
        }
    }



    public function preview($id = null)
    {
        try {
            $input = $this->request->getGet();


            $param = [
                'jenis_pengajuan'       => 'perjalanan_dinas',
                'status'                => 'selesai'
            ];

            // kalo ada tanggal between
            if (isset($input['tgl_awal']) && isset($input['tgl_akhir'])) {
                $param['tgl_realisasi'] = trim($input['tgl_awal']) . '|' . trim($input['tgl_akhir']);
            }


            // kalo ada id_divisi
            if (isset($input['id_divisi'])) {
                $param['id_unit_kerja_divisi'] = $input['id_divisi'];
            }

            $action = 'PreviewPerjalananDinasAll';
            if ($id != null) {
                $param['id_user'] = $id;
                $action = 'PreviewPerjalananDinas';
            }

            // get karyawan
            // printr(arrayToGet($param));
            $pengajuan = $this->pengajuan->getPengajuan($param);
            if ($pengajuan->total_row <= 0)
                throw new \Exception('Pengajuan tidak ditemukan');

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


            // printr($response);
            $preview = view("Pengajuan/Rekap/{$action}", $response);
            // return $preview;
            // echo $preview;
            // exit(1);

            $pdf = new Pdf();
            $pdf->htmlToPdf([
                'paper'  => 'A4',
                'layout' => 'landscape',
                'title'  => 'Berkas',
                'author' => 'PT.INTI',
                'html'   => $preview,
            ]);
        } catch (\Exception | \Throwable $error) {
            echo "<a href='" . base_url('rekap/perdin') . "'>Kembali</a> <br/>";
            echo $error->getMessage();
        }
    }
}




trait ParamDatatable
{
    private function paramDatatable($input)
    {
        $param = [
            'page'      => @$input['page'] ?? 1,
            'order_by'  => @$input['order_by'] ?? 'desc',
            'jenis_pengajuan'   => 'perjalanan_dinas'
        ];

        $param = array_merge($param, $this->paramOrderBy($input));
        return $param;
    }

    private function paramOrderBy($input)
    {
        $param = [];
        $indexOrder = $input['order'][0]['column'];
        $type = $input['order'][0]['dir'];

        $namaKolom = $input['columns'][$indexOrder]['data'];
        // nama_karyawan_asc / nama_karyawan_desc
        $orderBy = $namaKolom . "_" . $type;
        $param['order_by'] = $orderBy;
        return $param;
    }
}
