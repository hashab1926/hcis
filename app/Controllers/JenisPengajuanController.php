<?php

namespace App\Controllers;

use App\Libraries\RequestApi\JenisPengajuan;
use App\Libraries\Pdf;

class JenisPengajuanController extends BaseController
{
    use AjaxData;
    use ParamDatatable;

    public function __construct()
    {
        $this->request = service('request');
        $this->jenis_pengajuan = new JenisPengajuan();
    }

    public function index()
    {
        return view('JenisPengajuan/Data');
    }

    public function tambah()
    {
        return view("JenisPengajuan/Tambah");
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();


            // param datatable
            $param = $this->paramDatatable($input);

            // get karyawan
            $jenisPengajuan = $this->jenis_pengajuan->getJenisPengajuan($param);
            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => $jenisPengajuan->total_row,
                'recordsFiltered' => $jenisPengajuan->total_row,
                'data'           => $jenisPengajuan->data
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
            $file = $_FILES['template_file'];

            // cek error file
            $this->library->validationFile($file);

            $templateFile = $this->library->addFile($file['tmp_name'], $file['type'], $file['name']);

            $data = [
                'nama_jenis'    => $input['nama_jenis'],
                'template_file' => $templateFile
            ];

            $request = $this->jenis_pengajuan->tambah($data);
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

    public function lihatTemplate($id)
    {
        try {
            $request = $this->jenis_pengajuan->getJenisPengajuan(['id' => $id]);

            // cek ada ga datanya
            if ($request->total_row <= 0)
                throw new \Exception("template tidak ditemukan");

            $source = $request->data[0];

            // get 'template_file'
            $contents = base64_decode($source->template_file);

            // cek berkas
            if ($contents == null)
                throw new \Exception('temporary kosong!');

            header("Content-type: text/html");
            echo $contents;
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage();
        }
    }

    public function hapus()
    {
        try {
            $input = $this->request->getPost();
            if (!is_array($input['id_jabatan']))
                throw new \Exception("jabatan tidak ditemukan");

            if (count($input['id_jabatan']) <= 0)
                throw new \Exception("jabatan tidak ditemukan");

            $request = $this->jabatan->hapus($input['id_jabatan']);
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

    public function ubah($listIdJabatan)
    {
        try {
            $input = $this->request->getGet();
            $listIdJabatan = base64_decode($listIdJabatan);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdJabatan,
                'page'  => $page,
                'limit' => 50,
            ];
            $jabatan = $this->jabatan->getJabatan($param);

            // default limitasi 
            $limitation = false;

            // kalo yang dipilih lebih dari 50, maka kena limitasi
            if ($jabatan->total_row > 50)
                $limitation = true;

            $response = [
                'status_code'   => 200,
                'data'          => $jabatan->data,
                'limitation'    => $limitation
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['menu'] = 'Ubah Jabatan';
            return view('Jabatan/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();
            $list = $input['nama_jabatan'];
            foreach ($list as $key => $id) {
                $data = [
                    'nama_jabatan'             => $input['nama_jabatan'][$key],
                ];

                $this->jabatan->ubah($key, $data);
            }

            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => base_url('jabatan')
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
    public function ajaxDataJenis()
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


            // get jenis pengajuan
            $jenis = $this->jenis_pengajuan->getJenisPengajuan($param);
            $dataJenis = $jenis->data;
            $response = [];

            foreach ($dataJenis as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => $list->nama_jenis
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $jenis->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo json_encode(['message' => $error->getMessage()]);
        }
    }
}
