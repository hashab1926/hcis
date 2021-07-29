<?php

namespace App\Helpers\Template;

use Illuminate\Support\Facades\DB;

trait InputTemplate
{
    private $allowInput = [
        'Text',
        'List',
        'DateRange',
        'Table'
    ];


    private function concatAllowInput()
    {
        $allowInput = $this->allowInput;
        $length = count($allowInput) - 1;
        $tampung = '';
        $x = 0;
        foreach ($allowInput as $list) :
            if ($x == $length)
                $tampung .= '\\$' . $list . '->';
            else
                $tampung .= '\\$' . $list . '->|';
            $x++;

        endforeach;

        return $tampung;
    }

    public function listKeywordInput()
    {
        $display = $this->html;
        $concatAllowInput = $this->concatAllowInput();
        $pattern = "/({$concatAllowInput})\{[a-zA-z0-9\s]*\}/";

        $tampungInput = [];
        // kalo ada keyword $Text->{KEYWORD} atau $List->{KEYWORD}
        if (preg_match_all($pattern, $display, $hasil)) {
            $hasil =  $hasil[0];
            $patternRemove = '/\\$|\{|\}/';
            // tampilkan tiap keywordnya
            foreach ($hasil as $list) :
                // hapus kerwyord $,{ , } hasilnya  : type->keyword
                $removeKeyword = preg_replace($patternRemove, '', $list);

                // hasil dari keyword, dipecan jadi 2 bagian
                $keyword = explode('->', $removeKeyword);

                // pertama jadi tipe inputan 
                $tipeInputan = $keyword[0];

                // kedua jadi nama inputan 
                $namaInputan = $keyword[1];

                // ubah nama inputan yang mengandung spasi menjadi underscode '_' dan diubah jadi huruf kecil semua
                $dataNama = str_replace(' ', '_', strtolower($namaInputan));

                // kalo tipe inputannya 'Text'
                if ($tipeInputan == 'Text') :
                    $tagInputan = "
                        <div class='form-group margin-top-2 margin-bottom-3'>
                            <label class='text-muted fweight-700'>{$namaInputan}</label>
                            <input type='text' name='templating[{$dataNama}]' class='form-control' placeholder='{$namaInputan}'>
                        </div>
                    ";
                    $tampungInput[] = [
                        'tipe'      => $tipeInputan,
                        'keyword'   => $namaInputan,
                        'display'   => base64_encode($tagInputan)
                    ];

                // kalo tipe inputannya 'List'
                elseif ($tipeInputan == 'List') :
                    $tampungInput[] = [
                        'tipe'      => $tipeInputan,
                        'keyword'   => $namaInputan,
                        'display'   => $this->displayInputList($namaInputan)
                    ];

                // kalo tipe inputannya 'DateRange'
                elseif ($tipeInputan == 'DateRange') :
                    $defaultTag = "
                    <div class='form-group margin-top-2 margin-bottom-3'>
                        <label class='text-muted fweight-700'>{$namaInputan}</label>
                        <input type='text' name='templating[{$dataNama}]' class='form-control' placeholder='{$namaInputan}'>
                    </div>
                ";
                    $tampungInput[] = [
                        'tipe'      => $tipeInputan,
                        'keyword'   => $namaInputan,
                        'display'   => $this->displayInputDateRange($namaInputan, $defaultTag)
                    ];

                // kalo tipe inputannya 'Table'
                elseif ($tipeInputan == 'Table') :
                    $tampungInput[] = [
                        'tipe'      => $tipeInputan,
                        'keyword'   => $namaInputan,
                        'display'   => $this->displayInputTable($namaInputan)
                    ];
                endif;
            endforeach;

            return $tampungInput;
        }

        return [];
    }
}

trait DisplayInput
{
    private function displayinputList($keyword)
    {
        $text = '';
        switch ($keyword) {
            case 'Unit Kerja Kepala':
                $kepala = DB::table('unit_kerja__kepala')->get()->toArray();
                $html = "
                <fieldset class='form-group margin-bottom-3'>
                    <label class='text-muted fweight-600'>Unit kerja kepala</label>
                    <select name='templating[unit_kerja_kepala]' class='form-select'>
                    <option value=''>- Pilih Unit kerja kepala -</option>
                    ";
                foreach ($kepala as $list) :
                    $html .= "<option value='{$list->id}'>{$list->nama}</option>";
                endforeach;
                $html .= "</select></fieldset>";
                $text = base64_encode($html);
                break;

            case 'Unit Kerja Divisi':
                $kepala = DB::table('unit_kerja__divisi')->get()->toArray();
                $html = "
                    <fieldset class='form-group margin-bottom-3'>
                        <label class='text-muted fweight-600'>Unit kerja divisi</label>
                        <select name='templating[unit_kerja_divisi]' class='form-select'>
                        <option value=''>- Pilih Unit kerja divisi -</option>
                        ";
                foreach ($kepala as $list) :
                    $html .= "<option value='{$list->id}'>{$list->nama}</option>";
                endforeach;
                $html .= "</select></fieldset>";
                $text = base64_encode($html);
                break;

            case 'Unit Kerja Bagian':
                $kepala = DB::table('unit_kerja__bagian')->get()->toArray();
                $html = "
                    <fieldset class='form-group margin-bottom-3'>
                        <label class='text-muted fweight-600'>Unit kerja bagian</label>
                        <select name='templating[unit_kerja_bagian]' class='form-select'>
                        <option value=''>- Pilih Unit kerja bagian -</option>
                        ";
                foreach ($kepala as $list) :
                    $html .= "<option value='{$list->id}'>{$list->nama}</option>";
                endforeach;
                $html .= "</select></fieldset>";
                $text = base64_encode($html);
                break;

            case 'Pejabat':
                $pejabat = DB::table('karyawan')->where('status', '2')->get()->toArray();
                $html = "
                        <fieldset class='form-group margin-bottom-3'>
                            <label class='text-muted fweight-600'>Pejabat</label>
                            <select name='templating[pejabat]' class='form-select'>
                            <option value=''>- Pilih Pejabat -</option>
                            ";
                foreach ($pejabat as $list) :
                    $html .= "<option value='{$list->id}'>{$list->nama_karyawan}</option>";
                endforeach;
                $html .= "</select></fieldset>";
                $text = base64_encode($html);
                break;
        }

        return $text;
    }

    private function displayinputDateRange($keyword, $default)
    {
        $html = '';

        switch ($keyword) {
            case 'Lama Perdin':
                $html = "<div class='form-group margin-top-2 margin-bottom-3'>
                            <label class='text-muted fweight-700'>Lama Perdin</label>
                            <input type='text' name='templating[lama_perdin]' class='form-control datelightpick-lama-perdin' placeholder='Lama perjalanan dinas'>
                        </div>";
                break;
            case 'Lama Perdin Realisasi':
                $html = "<div class='form-group margin-top-2 margin-bottom-3'>
                            <label class='text-muted fweight-700'>Lama Perdin Realisasi</label>
                            <input type='text' name='templating[lama_perdin_realisasi]' class='form-control datelightpick-lama-perdin' placeholder='Lama perjalanan dinas realisasi'>
                        </div>";
                break;
        }
        return base64_encode($html);
    }

    private function displayinputTable($keyword)
    {
        $html = '';
        switch ($keyword) {
            case 'Biaya Perjalanan Dinas':
                $html = "
                <style>
                table{
                    border-spacing: 0 .5em;
                    border-collapse:separate;
                }
                </style>
                <table class='table table-borderless'>
                    <tr class='fweight-700' style='opacity:0.5'>
                        <td class='text-center text-muted'>No</td>
                        <td class=' text-center text-muted'>Jenis Fasilitas</td>
                        <td class='text-right text-muted'>Nilai Pengajuan</td>
                        <td class='text-right text-muted'>Nilai Realisasi</td>
                    </tr>
                    <tbody id='tbody-rincian-biaya'>
                        <tr class='box-shadow'>
                            <td class='padding-3'>1</td>
                            <td class='padding-3'><input type='text' name='templating[jenis_fasilitas][]' class='form-control no-border text-muted ' placeholder='Jenis fasilitas'></td>
                            <td class='padding-3'><input type='text' dir='rtl' name='templating[nilai_pengajuan][]' class='form-control text-muted currency-number nilai_pengajuan no-border' placeholder='Nilai Pengajuan'></td>
                            <td class='padding-3'><input type='text' dir='rtl' name='templating[nilai_realisasi][]' class='form-control text-muted currency-number nilai_realisasi no-border' placeholder='Nilai Realisasi'></td>
                            <td class='padding-3'>
                                <button class='no-border no-background text-muted padding-x-1 hapus-rincian d-flex align-items-center padding-top-1'>
                                    <span class='material-icons-outlined'>
                                        highlight_off
                                    </span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class='text-center fweight-700' colspan=2>TOTAL NILAI</td>
                            <td class='text-center fweight-700'>
                                <div class=' d-flex justify-content-between'>
                                    <div>Rp.</div>
                                    <div  id='total-nilai-pengajuan'>0</div>
                                </div>
                            </td>
                            <td class='text-center fweight-700' >
                                <div class=' d-flex justify-content-between'>
                                    <div>Rp.</div>
                                    <div id='total-nilai-realisasi'>0</div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <div class='margin-top-2'>
                    <button class='btn btn-primary padding-y-2 fweight-700 btn-block d-flex align-items-center justify-content-center' id='templating-tambah-rincian'>
                        <span class='material-icons-outlined'>
                            add
                        </span>
                        <div class='margin-left-2'>Tambah Baris Rincian</div>
                    </button>
                </div>
                ";
                break;
        }

        return base64_encode($html);
    }
}
