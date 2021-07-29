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

            $this->credential->set('id', $dataAuth->id);
            $this->credential->set('id_karyawan', $dataAuth->id_karyawan);
            $this->credential->set('nama_user', $dataAuth->nama_karyawan);
            $this->credential->set('level', $dataAuth->level);

            // response success
            $response = [
                'status_code' => 200,
                'action'     => base_url('dashboard')
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'    => $error->getMessage() . ' - ' . $error->getLine() . ' - ' . $error->getFile()
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
