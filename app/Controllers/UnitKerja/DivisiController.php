<?php

namespace App\Controllers\UnitKerja;

use App\Controllers\BaseController;
use App\Libraries\RequestApi\UnitKerja\Divisi;

class DivisiController extends BaseController
{
    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->divisi = new Divisi();
    }

    public function index()
    {
        return view('UnitKerja/Divisi/Data');
    }

    public function tambah()
    {
        return view("UnitKerja/Divisi/Tambah");
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();

            $param = [
                'page' => $input['page']
            ];
            // get karyawan
            $pangkat = $this->divisi->getDivisi($param);
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
                'id_unit_kerja_kepala'  => $input['id_kepala'],
                'kode_divisi'           => $input['kode_divisi'],
                'nama_divisi'           => $input['nama_divisi'],
                'singkatan'             => $input['singkatan'],
            ];

            $request = $this->divisi->tambah($data);
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
            if (!is_array($input['id_divisi']))
                throw new \Exception("divisi tidak ditemukan");

            if (count($input['id_divisi']) <= 0)
                throw new \Exception("divisi tidak ditemukan");

            $request = $this->divisi->hapus($input['id_divisi']);
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

    public function ubah($listIdDivisi)
    {
        try {
            $input = $this->request->getGet();
            $listIdDivisi = base64_decode($listIdDivisi);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdDivisi,
                'page'  => $page,
                'limit' => 50,
            ];
            $divisi = $this->divisi->getDivisi($param);

            // default limitasi 
            $limitation = false;

            // kalo yang dipilih lebih dari 50, maka kena limitasi
            if ($divisi->total_row > 50)
                $limitation = true;

            $response = [
                'status_code'   => 200,
                'data'          => $divisi->data,
                'limitation'    => $limitation
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['menu'] = 'Ubah Divisi';
            return view('UnitKerja/Divisi/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();
            $list = $input['nama_divisi'];
            foreach ($list as $key => $id) {
                $data = [
                    'id_unit_kerja_divisi'    => $input['id_kepala'][$key],
                    'kode_divisi'             => $input['kode_divisi'][$key],
                    'nama_divisi'             => $input['nama_divisi'][$key],
                    'singkatan'               => $input['singkatan'][$key],
                ];

                $this->divisi->ubah($key, $data);
            }

            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => base_url('unit_kerja/divisi')
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
    public function ajaxDataDivisi()
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
            $divisi = $this->divisi->getDivisi($param);
            $data = $divisi->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => ($list->kode_divisi ?? 'Belum diisi') . ' - ' . $list->nama_divisi
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
