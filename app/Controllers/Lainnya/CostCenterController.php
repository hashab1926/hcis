<?php

namespace App\Controllers\Lainnya;

use App\Controllers\BaseController;
use App\Libraries\RequestApi\Lainnya\CostCenter;

class CostCenterController extends BaseController
{

    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->cost_center = new CostCenter();
    }

    public function index()
    {
        return view('Lainnya/CostCenter/Data');
    }

    public function tambah()
    {
        return view("Lainnya/CostCenter/Tambah");
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();

            $param = [
                'page' => $input['page']
            ];
            // get 
            $get = $this->cost_center->getCostCenter($param);
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
                'kode_cost_center' => $input['kode_cost_center'],
                'nama_cost_center' => $input['nama_cost_center'],
            ];

            $request = $this->cost_center->tambah($data);
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

    public function ubah($listIdCostCenter)
    {
        try {
            $input = $this->request->getGet();
            $listIdCostCenter = base64_decode($listIdCostCenter);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdCostCenter,
                'page'  => $page,
                'limit' => 50,
            ];
            $get = $this->cost_center->getCostCenter($param);

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
            return view('Lainnya/CostCenter/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();
            $list = $input['kode_cost_center'];
            foreach ($list as $key => $id) {
                $data = [
                    'kode_cost_center'             => $input['kode_cost_center'][$key],
                    'nama_cost_center'             => $input['nama_cost_center'][$key],
                ];

                $this->cost_center->ubah($key, $data);
            }

            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => base_url('cost_center')
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
            if (!is_array($input['id_cost_center']))
                throw new \Exception("kepala tidak ditemukan");

            if (count($input['id_cost_center']) <= 0)
                throw new \Exception("kepala tidak ditemukan");

            $request = $this->cost_center->hapus($input['id_cost_center']);
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
    public function ajaxDataCostCenter()
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

            // get 
            $get = $this->cost_center->getCostCenter($param);
            $data = $get->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => "{$list->kode_cost_center} - {$list->nama_cost_center}"
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $get->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo json_encode([]);
        }
    }

    public function ajaxDataCostCenterKode()
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

            // get 
            $get = $this->cost_center->getCostCenter($param);
            $data = $get->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->kode_cost_center,
                    'text'  => "{$list->kode_cost_center} - {$list->nama_cost_center}"
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
