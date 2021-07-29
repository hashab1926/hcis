<?php

namespace App\Helpers\Template;

use Illuminate\Support\Facades\DB;

trait GetDataInit
{

    private $allowKeywordInit = [
        'BASE_URL',
    ];
    public function getDataInit()
    {
        $display = $this->html;
        $pattern = "/\\$\\$[a-zA-z0-9\s\w]*/";
        if (preg_match_all($pattern, $display, $hasil)) {
            $hasil = $hasil[0];
            $patternRemove = '/\\$\\$/';
            foreach ($hasil as $list) :
                // hapus kerwyord ${{ , }} hasilnya  : keyword
                $keyword = preg_replace($patternRemove, '', $list);
                // kalo keyword nya masuk kedalam daftar $allowKeyword
                if (in_array($keyword, $this->allowKeywordInit)) {
                    $replace = $this->displayInit($keyword);
                    $display = str_replace($list, $replace, $display);
                }
            endforeach;
        }
        $this->html = $display;
        return $this;
    }

    private function displayInit($keyword)
    {
        $text = '';
        switch ($keyword) {
            case 'BASE_URL':
                $text = url();
                break;
        }

        return $text;
    }
}
