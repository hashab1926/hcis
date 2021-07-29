<?php

namespace App\Controllers\UnitKerja;

use App\Controllers\BaseController;
use App\Libraries\RequestApi\UnitKerja\Kepala;

class KepalaController extends BaseController
{

    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->kepala = new Kepala();
    }

    public function index()
    {
        return view('UnitKerja/Kepala/Data');
    }

    public function tambah()
    {
        return view("UnitKerja/Kepala/Tambah");
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();

            $param = [
                'page' => $input['page']
            ];
            // get 
            $kepala = $this->kepala->getKepala($param);
            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => $kepala->total_row,
                'recordsFiltered' => $kepala->total_row,
                'data'           => $kepala->data
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
                'kode_kepala' => $input['kode_kepala'],
                'nama_kepala' => $input['nama_kepala'],
            ];

            $request = $this->kepala->tambah($data);
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

    public function ubah($listIdKepala)
    {
        try {
            $input = $this->request->getGet();
            $listIdKepala = base64_decode($listIdKepala);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdKepala,
                'page'  => $page,
                'limit' => 50,
            ];
            $kepala = $this->kepala->getKepala($param);

            // default limitasi 
            $limitation = false;

            // kalo yang dipilih lebih dari 50, maka kena limitasi
            if ($kepala->total_row > 50)
                $limitation = true;

            $response = [
                'status_code'   => 200,
                'data'          => $kepala->data,
                'limitation'    => $limitation
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['menu'] = 'Ubah Kepala';
            return view('UnitKerja/Kepala/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();
            $list = $input['nama_kepala'];
            foreach ($list as $key => $id) {
                $data = [
                    'kode_kepala'             => $input['kode_kepala'][$key],
                    'nama_kepala'             => $input['nama_kepala'][$key],
                ];

                $this->kepala->ubah($key, $data);
            }

            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => base_url('unit_kerja/kepala')
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
            if (!is_array($input['id_kepala']))
                throw new \Exception("kepala tidak ditemukan");

            if (count($input['id_kepala']) <= 0)
                throw new \Exception("kepala tidak ditemukan");

            $request = $this->kepala->hapus($input['id_kepala']);
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
    public function ajaxDataKepala()
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
            $divisi = $this->kepala->getKepala($param);
            $data = $divisi->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => $list->nama_kepala
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
