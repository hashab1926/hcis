<?php

namespace App\Controllers;

use App\Libraries\RequestApi\User;
use App\Libraries\RequestApi\Karyawan;

class UserController extends BaseController
{
    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->user = new User();
        $this->karyawan = new Karyawan();
    }

    private function getMenu()
    {
        $currentUrl = $this->request->getPath();
        $menu = 'Karyawan';
        if (strpos($currentUrl, 'direktorat') !== false)
            $menu = 'Direktorat';
        return $menu;
    }

    public function tambah($listIdKaryawan)
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
            // printr($response);
            return view('User/Tambah', $response);
        }
    }

    public function store()
    {
        try {
            $input = $this->request->getPost();
            // printr($input);
            $list = $input['id_karyawan'];
            foreach ($list as $key => $id) {
                $data = [
                    'id_karyawan'          => $id,
                    'username'             => $input['username'][$key],
                    'password'             => $input['password'][$key],
                    'level'                => $input['level'][$key],
                ];
                // printr($data);
                $this->user->tambah($data);
            }

            $response = [
                'status_code'   => 201,
                'message'       => 'Akun telah dibuat',
                'action'        => base_url('karyawan')
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage(),
                // 'message'       => $error->getMessage() . ' - ' . $error->getFile() . ' line : ' . $error->getLine()

            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }
}

trait AjaxData
{


    public function ajaxDataNotResigterKaryawan()
    {
        try {

            // set default param
            $param = [
                'status'    => 'not_register'
            ];

            // get method
            $input = $this->request->getGet();

            // param 'page' kalo ada
            if (!empty($input['page']))
                $param['page'] = $input['page'];

            // param 'q' kalo ada
            if (!empty($input['search']))
                $param['q'] = $input['search'];


            // get 
            $karyawan = $this->karyawan->getKaryawan($param);
            $dataJabatan = $karyawan->data;
            $response = [];

            foreach ($dataJabatan as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => $list->nip . ' - ' . $list->nama_karyawan
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $karyawan->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo json_encode([]);
        }
    }
}
