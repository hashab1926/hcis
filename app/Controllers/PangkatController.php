<?php

namespace App\Controllers;

use App\Libraries\RequestApi\Pangkat;

class PangkatController extends BaseController
{
    use AjaxData;
    use paramDatatable;

    public function __construct()
    {
        $this->request = service('request');
        $this->pangkat = new Pangkat();
    }

    public function index()
    {
        return view('Pangkat/Data');
    }

    public function tambah()
    {
        // printr($_SESSION);
        return view("Pangkat/Tambah");
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();


            // param datatable
            $param = $this->paramDatatable($input);

            // get karyawan
            $pangkat = $this->pangkat->getPangkat($param);
            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => $pangkat->total_row,
                'recordsFiltered' => $pangkat->total_row,
                'data'           => $pangkat->data
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

    public function store()
    {
        try {
            $input = $this->request->getPost();

            $data = [
                'nama_pangkat' => $input['nama_pangkat'],
            ];

            $request = $this->pangkat->tambah($data);
            $response = [
                'status_code' => 201,
                'message'     => $request->message
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }


    public function hapus()
    {
        try {
            $input = $this->request->getPost();
            if (!is_array($input['id_pangkat']))
                throw new \Exception("pangkat tidak ditemukan");

            if (count($input['id_pangkat']) <= 0)
                throw new \Exception("pangkat tidak ditemukan");

            $request = $this->pangkat->hapus($input['id_pangkat']);
            $response = [
                'status_code' => 200,
                'message'     => $request->message
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    public function ubah($listIdPangkat)
    {
        try {
            $input = $this->request->getGet();
            $listIdPangkat = base64_decode($listIdPangkat);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdPangkat,
                'page'  => $page,
                'limit' => 50,
            ];
            $pangkat = $this->pangkat->getPangkat($param);

            // default limitasi 
            $limitation = false;

            // kalo yang dipilih lebih dari 50, maka kena limitasi
            if ($pangkat->total_row > 50)
                $limitation = true;

            $response = [
                'status_code'   => 200,
                'data'          => $pangkat->data,
                'limitation'    => $limitation
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['menu'] = 'Ubah Pangkat';
            return view('Pangkat/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();
            $list = $input['nama_pangkat'];
            foreach ($list as $key => $id) {
                $data = [
                    'nama_pangkat'  => $input['nama_pangkat'][$key],
                ];

                $this->pangkat->ubah($key, $data);
            }

            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => base_url('pangkat')
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
}


trait ParamDatatable
{
    private function paramDatatable($input)
    {
        $param = [
            'page'      => @$input['page'] ?? 1,
            'order_by'  => @$input['order_by'] ?? 'desc'
        ];

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


trait AjaxData
{
    public function ajaxDataPangkat()
    {
        try {

            // set default param
            $param = [];

            // get method
            $input = $this->request->getGet();

            // param 'page' kalo ada
            if (!empty($input['page']))
                $param['page'] = $input['page'];

            // param 'q' kalo ada
            if (!empty($input['search']))
                $param['q'] = $input['search'];

            // get karyawan
            $pangkat = $this->pangkat->getPangkat($param);
            $dataPangkat = $pangkat->data;
            $response = [];

            foreach ($dataPangkat as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => $list->nama_pangkat
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $pangkat->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo json_encode([]);
        }
    }
}
