<?php

namespace App\Helpers\Template;

use Illuminate\Support\Facades\DB;

trait GetDataAuto
{

    private $allowKeywordAuto = [
        'DATE TIME NOW',
        'NOMOR SURAT'
    ];
    public function getDataAuto()
    {
        $display = $this->html;
        $pattern = "/\\$\{\{[a-zA-z0-9\s]*\}\}/";
        if (preg_match_all($pattern, $display, $hasil)) {
            $hasil = $hasil[0];
            $patternRemove = '/\\$\{\{|\}\}/';
            foreach ($hasil as $list) :
                // hapus kerwyord ${{ , }} hasilnya  : keyword
                $keyword = preg_replace($patternRemove, '', $list);
                // kalo keyword nya masuk kedalam daftar $allowKeyword
                if (in_array($keyword, $this->allowKeywordAuto)) {
                    $replace = $this->displayAuto($keyword);
                    $display = str_replace($list, $replace, $display);
                }
            endforeach;
        }
        $this->html = $display;
        return $this;
    }

    public function getDataAutoToArray()
    {
        $display = $this->html;
        $pattern = "/\\$\{\{[a-zA-z0-9\s]*\}\}/";
        $tampung = [];
        if (preg_match_all($pattern, $display, $hasil)) {
            $hasil = $hasil[0];
            $patternRemove = '/\\$\{\{|\}\}/';
            foreach ($hasil as $list) :
                // hapus kerwyord ${{ , }} hasilnya  : keyword
                $keyword = preg_replace($patternRemove, '', $list);
                // kalo keyword nya masuk kedalam daftar $allowKeyword
                if (in_array($keyword, $this->allowKeywordAuto)) {
                    $replace = $this->displayAuto($keyword);
                    $tampung[] = [
                        'keyword'  => $keyword,
                        'data'     => $replace
                    ];
                }
            endforeach;
        }
        return $tampung;
    }

    private function displayAuto($keyword)
    {
        $text = '';
        switch ($keyword) {
            case 'DATE TIME NOW':
                $text = date('d-M-y H:i:s');
                break;
            case 'NOMOR SURAT':
                $pengajuan = DB::table('pengajuan');
                $nomor = $pengajuan->count() + 1;

                if ($nomor <= 9) :
                    $text = "0000000000{$nomor}/" . date('Y');
                elseif ($nomor <= 99) :
                    $text = "000000000{$nomor}/" . date('Y');
                elseif ($nomor <= 999) :
                    $text = "00000000{$nomor}/" . date('Y');
                elseif ($nomor <= 9999) :
                    $text = "00000000{$nomor}/" . date('Y');
                elseif ($nomor <= 99999) :
                    $text = "0000000{$nomor}/" . date('Y');
                elseif ($nomor <= 999999) :
                    $text = "000000{$nomor}/" . date('Y');
                elseif ($nomor <= 9999999) :
                    $text = "00000{$nomor}/" . date('Y');
                elseif ($nomor <= 99999999) :
                    $text = "0000{$nomor}/" . date('Y');
                elseif ($nomor <= 999999999) :
                    $text = "000{$nomor}/" . date('Y');
                elseif ($nomor <= 9999999999) :
                    $text = "00{$nomor}/" . date('Y');
                elseif ($nomor <= 99999999999) :
                    $text = "0{$nomor}/" . date('Y');
                elseif ($nomor <= 999999999999) :
                    $text = "{$nomor}/" . date('Y');
                endif;
                break;
        }

        return $text;
    }
}
