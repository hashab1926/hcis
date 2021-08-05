<?php

namespace App\Controllers\Lainnya;

use App\Controllers\BaseController;
use App\Libraries\RequestApi\Lainnya\WbsElement;

class WbsElementController extends BaseController
{

    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->wbs_element = new WbsElement();
    }

    public function index()
    {
        return view('Lainnya/WbsElement/Data');
    }

    public function tambah()
    {
        return view("Lainnya/WbsElement/Tambah");
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();

            $param = [
                'page' => $input['page']
            ];
            // get 
            $get = $this->wbs_element->getWbsElement($param);
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
                'kode_wbs_element' => $input['kode_wbs_element'],
                'nama_wbs_element' => $input['nama_wbs_element'],
            ];

            $request = $this->wbs_element->tambah($data);
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

    public function ubah($listIdWbsElement)
    {
        try {
            $input = $this->request->getGet();
            $listIdWbsElement = base64_decode($listIdWbsElement);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdWbsElement,
                'page'  => $page,
                'limit' => 50,
            ];
            $get = $this->wbs_element->getWbsElement($param);

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
            return view('Lainnya/WbsElement/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();
            $list = $input['kode_wbs_element'];
            foreach ($list as $key => $id) {
                $data = [
                    'kode_wbs_element'             => $input['kode_wbs_element'][$key],
                    'nama_wbs_element'             => $input['nama_wbs_element'][$key],
                ];

                $this->wbs_element->ubah($key, $data);
            }

            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => base_url('wbs_element')
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
            if (!is_array($input['id_wbs_element']))
                throw new \Exception("kepala tidak ditemukan");

            if (count($input['id_wbs_element']) <= 0)
                throw new \Exception("kepala tidak ditemukan");

            $request = $this->wbs_element->hapus($input['id_wbs_element']);
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
    public function ajaxDataWbsElement()
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
            $get = $this->wbs_element->getWbsElement($param);
            $data = $get->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => "{$list->kode_wbs_element} - {$list->nama_wbs_element}"
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
