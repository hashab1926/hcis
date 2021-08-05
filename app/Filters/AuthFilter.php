<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\Credential;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            $this->credential = new Credential();
            $sesion = session();
            $this->credential->cekCredential();
            return true;
        } catch (\Exception | \Throwable $error) {
            $sesion->setFlashdata('pesan', "<script> warningMessage('Pesan','" . $error->getMessage() . "');</script>");
            return redirect()->to(base_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
