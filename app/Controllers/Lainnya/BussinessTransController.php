<?php

namespace App\Controllers\Lainnya;

use App\Controllers\BaseController;
use App\Libraries\RequestApi\Lainnya\BussinessTrans;

class BussinessTransController extends BaseController
{

    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->bussiness_trans = new BussinessTrans();
    }

    public function index()
    {
        return view('Lainnya/BussinessTrans/Data');
    }

    public function tambah()
    {
        return view("Lainnya/BussinessTrans/Tambah");
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();

            $param = [
                'page' => $input['page']
            ];
            // get 
            $get = $this->bussiness_trans->getBussinessTrans($param);
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

    public function store()
    {
        try {
            $input = $this->request->getPost();

            $data = [
                'kode_bussiness_trans' => $input['kode_bussiness_trans'],
                'nama_bussiness_trans' => $input['nama_bussiness_trans'],
            ];

            $request = $this->bussiness_trans->tambah($data);
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

    public function ubah($listIdBussinessTrans)
    {
        try {
            $input = $this->request->getGet();
            $listIdBussinessTrans = base64_decode($listIdBussinessTrans);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdBussinessTrans,
                'page'  => $page,
                'limit' => 50,
            ];
            $get = $this->bussiness_trans->getBussinessTrans($param);

            // default limitasi 
            $limitation = false;

            // kalo yang dipilih lebih dari 50, maka kena limitasi
            if ($get->total_row > 50)
                $limitation = true;

            $response = [
                'status_code'   => 200,
                'data'          => $get->data,
                'limitation'    => $limitation
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['menu'] = 'Ubah Cost Center';
            return view('Lainnya/BussinessTrans/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();
            $list = $input['kode_bussiness_trans'];
            foreach ($list as $key => $id) {
                $data = [
                    'kode_bussiness_trans'             => $input['kode_bussiness_trans'][$key],
                    'nama_bussiness_trans'             => $input['nama_bussiness_trans'][$key],
                ];

                $this->bussiness_trans->ubah($key, $data);
            }

            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => base_url('bussiness_trans')
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

    public function hapus()
    {
        try {
            $input = $this->request->getPost();
            if (!is_array($input['id_bussiness_trans']))
                throw new \Exception("kepala tidak ditemukan");

            if (count($input['id_bussiness_trans']) <= 0)
                throw new \Exception("kepala tidak ditemukan");

            $request = $this->bussiness_trans->hapus($input['id_bussiness_trans']);
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
}



trait AjaxData
{
    public function ajaxDataBussinessTrans()
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
            $get = $this->bussiness_trans->getBussinessTrans($param);
            $data = $get->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => "{$list->kode_bussiness_trans} - {$list->nama_bussiness_trans}"
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $get->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo json_encode([]);
        }
    }
}
