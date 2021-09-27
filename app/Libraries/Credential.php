<?php

namespace App\Libraries;

use App\Libraries\Api;

class Credential
{
    private $tokenName = 'access_token';

    private $salt = true;

    private $session;

    public function __construct()
    {
        $this->addSalt = '';
        if ($this->salt == true)
            $this->addSalt = sha1('hcis-master') . '_';

        $this->api = new Api();
        $this->session = session();
    }

    public function cekCredential()
    {
        try {
            // printr($_SESSION);
            // var_dump($this->has($this->tokenName));
            // cek kalo ada tokennya
            if (!$this->has($this->tokenName))
                throw new \Exception('Anda belum login, silahkan login terlebih dahulu');

            // get token
            $token = $this->get($this->tokenName);

            // request api 
            $this->api->jwtToken = trim($token);
            $request = $this->api->get('cek_credential');
            // printr($request);
            // cek response
            if ($request->status_code != 200)
                throw new \Exception($request->message);

            // kalo lulus, ambil datanya
            return $request->data;
        } catch (\Exception | \Throwable $error) {
            throw new \Exception($error->getMessage());
        }
    }

    public function set($name, $value)
    {
        if (!is_array($name))
            $this->session->set($this->addSalt . $name, $value);
    }

    public function get($name)
    {
        return $this->session->get($this->addSalt . $name);
    }

    public function has($name)
    {
        if ($this->get($name) == null)
            return false;

        return true;
    }
}
