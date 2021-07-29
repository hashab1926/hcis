<?php

namespace App\Helpers\Template;

use Illuminate\Support\Facades\DB;

trait GetDataLogin
{
    private $allowKeyword = [
        'NIP',
        'Nama Karyawan',
        'Pangkat',
        'Jabatan',
        'Unit Kerja Kepala',
        'Unit Kerja Divisi',
        'Unit Kerja Bagian'
    ];

    private $dataLogin = null;

    public $request;

    public function getDataLogin()
    {
        $display = $this->html;
        $pattern = "/\\\$Login->\{\{[a-zA-z0-9\s]*\}\}/";
        if (preg_match_all($pattern, $display, $hasil)) {
            $hasil = $hasil[0];
            $patternRemove = '/\\\$Login->|\{|\}/';
            foreach ($hasil as $list) :
                // hapus kerwyord $Login->{ , } hasilnya  : login->keyword
                $removeKeyword = preg_replace($patternRemove, '', $list);

                // hasil dari keyword, dipecan jadi 2 bagian
                $keyword = explode('->', $removeKeyword);
                $keyword = $keyword[1];

                // kalo keyword nya masuk kedalam daftar $allowKeyword
                if (in_array($keyword, $this->allowKeyword)) {
                    $replace = $this->displayLogin($keyword);
                    $display = str_replace($list, $replace, $display);
                }
            endforeach;
        }
        $this->html = $display;
        return $this;
    }

    private function displayLogin($keyword)
    {
        $text = '';
        if ($this->dataLogin == null) {
            // token berdasarkan login
            $dataLogin = \App\Helpers\JwtHelper::getDataToken($this->request);
            // $user = \App\Helpers\JwtHelper::getUserToken($dataLogin['token']);
            $idUser = $dataLogin['decode']->sub;

            $user = DB::table('user')->where('id', $idUser)->first();
            $idKaryawan = $user->id_karyawan;

            // cari karyawan
            $karyawan = DB::table('karyawan')
                ->select(
                    'karyawan.*',
                    'unit_kerja__kepala.nama_kepala',
                    'unit_kerja__divisi.nama_divisi',
                    'unit_kerja__bagian.nama_bagian',
                    'jabatan.nama_jabatan',
                    'pangkat.nama_pangkat',

                )
                ->leftJoin('jabatan', 'jabatan.id', '=', 'karyawan.id_jabatan')
                ->leftJoin('pangkat', 'pangkat.id', '=', 'karyawan.id_pangkat')
                ->leftJoin('unit_kerja__kepala', 'unit_kerja__kepala.id', '=', 'karyawan.id_unit_kerja_kepala')
                ->leftJoin('unit_kerja__divisi', 'unit_kerja__divisi.id', '=', 'karyawan.id_unit_kerja_divisi')
                ->leftJoin('unit_kerja__bagian', 'unit_kerja__bagian.id', '=', 'karyawan.id_unit_kerja_bagian')

                ->where('karyawan.id', $idKaryawan)->first();

            $this->dataLogin = $karyawan;

            // dd($karyawan);
        }

        switch ($keyword) {
            case 'NIP':
                $text = $this->dataLogin->nip;
                break;
            case 'Nama Karyawan':
                $text = $this->dataLogin->nama_karyawan;
                break;
            case 'Pangkat':
                $text = $this->dataLogin->nama_pangkat;
                break;
            case 'Jabatan':
                $text = $this->dataLogin->nama_jabatan;
                break;
            case 'Unit Kerja Kepala':
                $text = $this->dataLogin->nama_kepala;
                break;
            case 'Unit Kerja Divisi':
                $text = $this->dataLogin->nama_divisi;
                break;
            case 'Unit Kerja Bagian':
                $text = $this->dataLogin->nama_bagian;
                break;
        }

        return $text;
    }
}
