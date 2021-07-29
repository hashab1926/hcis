<?php

namespace App\Controllers\UnitKerja;

use App\Controllers\BaseController;
use App\Libraries\RequestApi\UnitKerja\Bagian;

class BagianController extends BaseController
{

    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->bagian = new Bagian();
    }

    public function index()
    {
        return view('UnitKerja/Bagian/Data');
    }

    public function tambah()
    {
        return view("UnitKerja/Bagian/Tambah");
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();

            $param = [
                'page' => $input['page']
            ];
            // get karyawan
            $pangkat = $this->bagian->getBagian($param);
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
                'id_unit_kerja_divisi'  => $input['id_divisi'],
                'kode_bagian'           => $input['kode_bagian'],
                'nama_bagian'           => $input['nama_bagian'],
            ];

            $request = $this->bagian->tambah($data);
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
            if (!is_array($input['id_bagian']))
                throw new \Exception("bagian tidak ditemukan");

            if (count($input['id_bagian']) <= 0)
                throw new \Exception("bagian tidak ditemukan");

            $request = $this->bagian->hapus($input['id_bagian']);
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

    public function ubah($listIdBagian)
    {
        try {
            $input = $this->request->getGet();
            $listIdBagian = base64_decode($listIdBagian);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdBagian,
                'page'  => $page,
                'limit' => 50,
            ];
            $bagian = $this->bagian->getBagian($param);

            // default limitasi 
            $limitation = false;

            // kalo yang dipilih lebih dari 50, maka kena limitasi
            if ($bagian->total_row > 50)
                $limitation = true;

            $response = [
                'status_code'   => 200,
                'data'          => $bagian->data,
                'limitation'    => $limitation
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['menu'] = 'Ubah Bagian';
            // printr($response);
            return view('UnitKerja/Bagian/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();
            $list = $input['nama_bagian'];
            foreach ($list as $key => $id) {
                $data = [
                    'kode_bagian'             => $input['kode_bagian'][$key],
                    'nama_bagian'             => $input['nama_bagian'][$key],
                ];

                if (!empty($input['id_divisi'][$key]))
                    $data['id_unit_kerja_divisi'] = $input['id_divisi'][$key];

                $this->bagian->ubah($key, $data);
            }

            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => base_url('unit_kerja/bagian')
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



trait AjaxData
{
    public function ajaxDataBagian()
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
            $divisi = $this->bagian->getBagian($param);
            $data = $divisi->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => $list->nama_bagian
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $divisi->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo json_encode([]);
        }
    }
}
