<?php

namespace App\Controllers;

use App\Libraries\RequestApi\Karyawan;
use Exception;
use Throwable;

class KaryawanController extends BaseController
{
    use ParamDatatable;
    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->karyawan = new Karyawan();
    }

    public function index()
    {
        $menu = $this->getMenu();
        return view('Karyawan/Data', ['menu' => $menu]);
    }

    public function indexDirektorat()
    {
        $menu = $this->getMenu();
        return view('Karyawan/DataDirektorat', ['menu' => $menu]);
    }

    public function tambah()
    {
        $menu = $this->getMenu();
        return view("Karyawan/Tambah", ['menu' => $menu]);
    }
    public function tambahDirektorat()
    {
        return view("Karyawan/TambahDirektorat");
    }

    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();


            // param datatable
            $param = $this->paramDatatable($input);
            $param['status'] = 'except_pejabat';
            // get karyawan
            $karyawan = $this->karyawan->getKaryawan($param);
            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => $karyawan->total_row,
                'recordsFiltered' => $karyawan->total_row,
                'data'           => $karyawan->data
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

    public function getDatatableDirektorat()
    {
        try {
            $input = $this->request->getGet();


            // param datatable
            $param = $this->paramDatatable($input);
            $param['status'] = 'direktorat';

            // get karyawan
            $karyawan = $this->karyawan->getKaryawan($param);
            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => $karyawan->total_row,
                'recordsFiltered' => $karyawan->total_row,
                'data'           => $karyawan->data
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
            // printr($input);
            $data = [
                'nip'                    => $input['nip'],
                'nama_karyawan'          => $input['nama_karyawan'],
                'id_pangkat'             => $input['id_pangkat'],
                'id_jabatan'             => $input['id_jabatan'],
                'email'                  => $input['email'],
            ];

            if (!empty($input['id_kepala']))
                $data['id_unit_kerja_kepala'] = $input['id_kepala'];

            if (!empty($input['nomor_hp']))
                $data['nomor_hp'] = $input['nomor_hp'];

            if (!empty($input['id_divisi']))
                $data['id_unit_kerja_divisi'] = $input['id_divisi'];

            if (!empty($input['id_bagian']))
                $data['id_unit_kerja_bagian'] = $input['id_bagian'];

            // kalo status nya ada dan sesuai, maka dia pejabat
            if (!empty($input['status']) && $input['status'] == sha1(3))
                $data['status'] = '3';

            $foto = $_FILES['foto'] ?? [];
            // printr($_FILES);
            if (!empty($foto['name']))
                $data['foto'] = $this->library->addFile($foto['tmp_name'], $foto['type'], $foto['name']);
            // printr($data);
            $request = $this->karyawan->tambah($data);
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
            if (!is_array($input['id_karyawan']))
                throw new \Exception("karyawan tidak ditemukan");

            if (count($input['id_karyawan']) <= 0)
                throw new \Exception("karyawan tidak ditemukan");

            $request = $this->karyawan->hapus($input['id_karyawan']);
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

    public function detail($listIdKaryawan)
    {
        try {

            $menu = $this->getMenu();
            $input = $this->request->getGet();
            $listIdKaryawan = base64_decode($listIdKaryawan);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdKaryawan,
                'page'  => $page,
                'limit' => 50,
            ];
            $karyawan = $this->karyawan->getKaryawan($param);

            // default limitasi 
            $limitation = false;

            // kalo yang dipilih lebih dari 50, maka kena limitasi
            if ($karyawan->total_row > 50)
                $limitation = true;

            $response = [
                'status_code'   => 200,
                'data'          => $karyawan->data,
                'limitation'    => $limitation
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['menu'] = $menu;
            return view('Karyawan/Detail', $response);
        }
    }

    private function getMenu()
    {
        $currentUrl = $this->request->getPath();
        $menu = 'Karyawan';
        if (strpos($currentUrl, 'direktorat') !== false)
            $menu = 'Direktorat';
        return $menu;
    }

    public function ubah($listIdKaryawan)
    {
        try {
            $menu = $this->getMenu();
            $input = $this->request->getGet();
            $listIdKaryawan = base64_decode($listIdKaryawan);

            $page = @$input['page'];
            if (!isset($page) || $page <= 0)
                $page = 1;

            $param = [
                'id'    => $listIdKaryawan,
                'page'  => $page,
                'limit' => 50,
            ];
            $karyawan = $this->karyawan->getKaryawan($param);

            // default limitasi 
            $limitation = false;

            // kalo yang dipilih lebih dari 50, maka kena limitasi
            if ($karyawan->total_row > 50)
                $limitation = true;

            $response = [
                'status_code'   => 200,
                'data'          => $karyawan->data,
                'limitation'    => $limitation
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['menu'] = $menu;
            $response['menu_edit'] = $menu;
            // printr($response);
            return view('Karyawan/Ubah', $response);
        }
    }

    public function ubahStore()
    {
        try {
            $input = $this->request->getPost();

            $listNip = $input['nip'];
            $file = $_FILES['foto'] ?? [];

            foreach ($listNip as $key => $id) {
                $data = [
                    'nip'             => $input['nip'][$key],
                    'nama_karyawan'   => $input['nama_karyawan'][$key],
                    'email'           => $input['email'][$key],
                ];

                // cek kalo ada 'id_pangkat'
                if (isset($input['id_pangkat'][$key]))
                    $data['id_pangkat'] = $input['id_pangkat'][$key];

                if (isset($input['id_jabatan'][$key]))
                    $data['id_jabatan'] = $input['id_jabatan'][$key];
                if (isset($input['nomor_hp'][$key]))
                    $data['nomor_hp'] = $input['nomor_hp'][$key];
                if (isset($input['id_kepala'][$key]))
                    $data['id_unit_kerja_kepala'] = $input['id_kepala'][$key];
                if (isset($input['id_divisi'][$key]))
                    $data['id_unit_kerja_divisi'] = $input['id_divisi'][$key];
                if (isset($input['id_bagian'][$key]))
                    $data['id_unit_kerja_bagian'] = $input['id_bagian'][$key];
                if (isset($input['id_user'][$key]))
                    $data['id_user'] = $input['id_user'][$key];
                if (isset($input['password'][$key]))
                    $data['password'] = $input['password'][$key];
                if (isset($input['level'][$key]))
                    $data['level'] = $input['level'][$key];

                // upload foto, kalo ada
                if (isset($file['name'][$key])) {
                    $data['foto'] = $this->library->addFile($file['tmp_name'][$key], $file['type'][$key], $file['name'][$key]);
                }

                $this->karyawan->ubah($key, $data);
            }

            $status = $input['status'];
            $action =  base_url('karyawan');
            if ($status == '3')
                $action = base_url('direktorat');
            $response = [
                'status_code'   => 200,
                'message'       => 'data telah di perbarui',
                'action'        => $action
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage() . $error->getLine()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    public function fotoKaryawan($id)
    {
        try {
            $karyawan = $this->karyawan->getKaryawan(['id' => $id]);

            if ($karyawan->total_row <= 0)
                throw new \Exception("gambar tidak ditemukan");

            $source = $karyawan->data[0];

            //  cek ada ga fotonya
            if ($source->foto == null)
                throw new \Exception("gambar tidak ditemukan");

            $finfo = new \finfo(FILEINFO_MIME);
            $fileInfo = $finfo->buffer(base64_decode($source->foto));
            $mimeType = explode('; ', $fileInfo)[0] ?? 'Tidak Diketahui';


            header("Content-type: {$mimeType}");
            $content = base64_decode($source->foto);
            echo $content;
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage();
        }
    }
}

trait ParamDatatable
{
    private function paramDatatable($input)
    {

        // printr($input);
        $param = [
            'page'      => @$input['page'] ?? 1,
            'order_by'  => @$input['order_by'] ?? 'desc',
            'q'         => @$input['search']['value']
        ];

        $param = array_merge($param, $this->paramOrderBy($input));
        // printr($param);
        return $param;
    }

    private function paramOrderBy($input)
    {
        $param = [];
        // 2 => nama karyawan
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
    public function ajaxDataPejabat()
    {
        try {

            // set default param
            $param = [
                'status' => 'pejabat'
            ];

            // get method
            $input = $this->request->getGet();

            // param 'page' kalo ada
            if (!empty($input['page']))
                $param['page'] = $input['page'];
            // get karyawan
            $jabatan = $this->karyawan->getKaryawan($param);
            $dataJabatan = $jabatan->data;
            $response = [];

            foreach ($dataJabatan as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => $list->nama_karyawan . ' - ' . $list->nama_jabatan
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $jabatan->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage();
        }
    }
    public function ajaxDataKaryawan()
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
            $jabatan = $this->karyawan->getKaryawan($param);
            $dataJabatan = $jabatan->data;
            $response = [];

            foreach ($dataJabatan as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => "{$list->nip} - {$list->nama_karyawan}"
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $jabatan->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage();
        }
    }

    public function get()
    {
        try {
            // get method
            $input = $this->request->getGet();
            // set default param
            $param = [
                'status' => 'pengaju',
                'limit'  => 100,
                'q'      => $input['q']
            ];


            // get karyawan
            $jabatan = $this->karyawan->getKaryawan($param);
            $dataJabatan = $jabatan->data;
            $tampung = [];

            foreach ($dataJabatan as $list) :
                $tampung[] = [
                    'id'        => $list->id,
                    'id_user'   => $list->id_user,
                    'nip'       => $list->nip,
                    'nama'      => $list->nama_karyawan,
                    'pangkat'   => $list->nama_pangkat,
                    'jabatan'   => $list->nama_jabatan,

                ];
            endforeach;

            $response = [
                'status_code' => 200,
                'message'     => 'ok',
                'results'     => $tampung
            ];
        } catch (\Exception | \Throwable $error) {

            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage(),
            ];
        } finally {
            echo json_encode($response);
        }
    }
}
