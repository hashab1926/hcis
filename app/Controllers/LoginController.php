<?php

namespace App\Controllers;

use App\Libraries\RequestApi\Login;

class LoginController extends BaseController
{
    public function __construct()
    {
        $this->request = service('request');
        $this->login = new login();
    }
    public function index()
    {
        // session_destroy();
        return view('Login');
    }

    public function store()
    {
        try {
            $input = $this->request->getPost();
            $data = [
                'username' => $input['username'],
                'password' => $input['password'],
            ];

            // request auth_login 
            $request = $this->login->authLogin($data);

            // set session
            $this->credential->set('access_token', $request->access_token);

            $dataAuth = $request->data;
            $level = $dataAuth->level;
            $this->credential->set('id', $dataAuth->id);
            $this->credential->set('id_karyawan', $dataAuth->id_karyawan);
            $this->credential->set('nama_user', $dataAuth->nama_karyawan);
            $this->credential->set('level', $level);

            $action = 'dashboard';
            if ($level == '2')
                $action = 'pengajuan';
            elseif ($level == '4')
                $action = 'karyawan';
            elseif ($level == '3')
                $action = 'pengajuan/inbox';
            elseif ($level == '1')
                $action = 'pengajuan/saya';
            // response success
            $response = [
                'status_code' => 200,
                'action'     => base_url($action)
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'    => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    public function logout()
    {
        session_destroy();
        return redirect()->route('login');
    }
}
