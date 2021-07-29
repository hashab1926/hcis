<?php

namespace App\Controllers;

use App\Libraries\RequestApi\Pengajuan;
use App\Libraries\Library;
use App\Libraries\RequestApi\Karyawan;
use App\Libraries\Pdf as Pdf;

class InboxPengajuanController extends BaseController
{
    use ParamDatatable;
    public function __construct()
    {
        $this->request = service('request');
        $this->pengajuan = new Pengajuan();
    }


    public function index()
    {
        // printr($_SESSION);
        return view('Pengajuan/Inbox');
    }

    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();


            // param datatable
            $param = $this->paramDatatable($input);

            // get karyawan
            $pengajuan = $this->pengajuan->getPengajuan($param);
            // printr($pengajuan->data);
            $library = new Library();
            $x = 0;
            $tempPengajuan = $pengajuan->data;
            foreach ($tempPengajuan as $list) :
                $pengajuan->data[$x++]->created_at = $library->timeToText($list->created_at);
            endforeach;
            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => $pengajuan->total_row,
                'recordsFiltered' => $pengajuan->total_row,
                'data'           => $pengajuan->data
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
}



trait ParamDatatable
{
    private function paramDatatable($input)
    {
        $user = $this->credential->cekCredential();
        $param = [
            'page'              => @$input['page'] ?? 1,
            'order_by'          => @$input['order_by'] ?? 'desc',
        ];
        if ($user->level == '3')
            $param['id_penandatangan'] = $user->id_karyawan;
        elseif ($user->level == '2') {
            $param['id_unit_kerja_divisi'] = $user->id_unit_kerja_divisi;
            $param['status'] = 'ACC';
        }

        $param = array_merge($param, $this->paramOrderBy($input));
        // printr($param);
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
