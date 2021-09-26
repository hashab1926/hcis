<?php

namespace App\Controllers\Lainnya;

use App\Controllers\BaseController;
use App\Libraries\RequestApi\Lainnya\Negara;

class NegaraController extends BaseController
{

    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->negara = new Negara();
    }

    public function index()
    {
        return view('Lainnya/Negara/Data');
    }

    public function tambah()
    {
        return view("Lainnya/Negara/Tambah");
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();

            $param = [
                'page' => $input['page']
            ];
            // get 
            $get = $this->negara->getNegara($param);
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
                'nama_negara' => $input['nama_negara'],
            ];

            $request = $this->negara->tambah($data);
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

    public function ubah($listIdNegara)
    {
        try {
            $input = $this->request->getGet();
            $listIdNegara = base64_decode($listIdNegara);
            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdNegara,
                'page'  => $page,
                'limit' => 50,
            ];
            $get = $this->negara->getNegara($param);
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
            $response['menu'] = 'Ubah Negara';

            // printr($response);
            return view('Lainnya/Negara/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();
            $list = $input['nama_negara'];
            foreach ($list as $key => $id) {
                $data = [
                    'nama_negara'             => $input['nama_negara'][$key],
                ];

                $this->negara->ubah($key, $data);
            }

            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => base_url('negara')
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
            if (!is_array($input['id_negara']))
                throw new \Exception("negara tidak ditemukan");

            if (count($input['id_negara']) <= 0)
                throw new \Exception("negara tidak ditemukan");

            $request = $this->negara->hapus($input['id_negara']);
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
    public function ajaxDataNegara()
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
            $get = $this->negara->getNegara($param);
            $data = $get->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => "{$list->nama_negara}"
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $get->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo json_encode([]);
        }
    }

    public function ajaxDataNamaNegara()
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
            $get = $this->negara->getNegara($param);
            $data = $get->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->nama_negara,
                    'text'  => "{$list->nama_negara}"
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
