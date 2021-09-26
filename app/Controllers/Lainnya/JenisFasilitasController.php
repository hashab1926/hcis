<?php

namespace App\Controllers\Lainnya;

use App\Controllers\BaseController;
use App\Libraries\RequestApi\Lainnya\JenisFasilitas;

class JenisFasilitasController extends BaseController
{

    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->jenis_fasilitas = new JenisFasilitas();
    }

    public function index()
    {
        return view('Lainnya/JenisFasilitas/Data');
    }

    public function tambah()
    {
        return view("Lainnya/JenisFasilitas/Tambah");
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();

            $param = [
                'page' => $input['page']
            ];
            // get 
            $get = $this->jenis_fasilitas->getJenisFasilitas($param);
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
                'kode_fasilitas' => $input['kode_fasilitas'],
                'jenis_fasilitas' => $input['jenis_fasilitas'],
            ];

            $request = $this->jenis_fasilitas->tambah($data);
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

    public function ubah($listIdJenisFasilitas)
    {
        try {
            $input = $this->request->getGet();
            $listIdJenisFasilitas = base64_decode($listIdJenisFasilitas);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdJenisFasilitas,
                'page'  => $page,
                'limit' => 50,
            ];
            $get = $this->jenis_fasilitas->getJenisFasilitas($param);

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
            $response['menu'] = 'Ubah Jenis Fasilitas';
            return view('Lainnya/JenisFasilitas/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();
            $list = $input['kode_fasilitas'];
            // printr($input);
            foreach ($list as $key => $id) {
                $data = [
                    'kode_fasilitas'             => $input['kode_fasilitas'][$key],
                    'jenis_fasilitas'            => $input['jenis_fasilitas'][$key],
                ];

                $this->jenis_fasilitas->ubah($key, $data);
            }

            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => base_url('jenis_fasilitas')
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
            if (!is_array($input['id_jenis_fasilitas']))
                throw new \Exception("fasilitas tidak ditemukan");

            if (count($input['id_jenis_fasilitas']) <= 0)
                throw new \Exception("fasilitas tidak ditemukan");

            $request = $this->jenis_fasilitas->hapus($input['id_jenis_fasilitas']);
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
    public function ajaxDataJenisFasilitas()
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
            $get = $this->jenis_fasilitas->getJenisFasilitas($param);
            $data = $get->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => "{$list->kode_fasilitas} - {$list->jenis_fasilitas}"
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $get->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo json_encode([]);
        }
    }

    public function ajaxDataJenisFasilitasNama()
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
            $get = $this->jenis_fasilitas->getJenisFasilitas($param);
            $data = $get->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->jenis_fasilitas,
                    'text'  => "{$list->kode_fasilitas} - {$list->jenis_fasilitas}"
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
