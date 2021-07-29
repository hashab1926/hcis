<?php

namespace App\Helpers\Template;

use Illuminate\Support\Facades\DB;

trait GetDataInput
{
    public function getDataInput($templating)
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
                if ($tipeInputan == 'Text') {
                    // cek keywordnya ada ga
                    if (isset($templating[$dataNama])) {
                        $display = str_replace($list, $templating[$dataNama], $display);
                    }
                }
                // kalo tipe inputannya 'List'
                elseif ($tipeInputan == 'List') {
                    if (isset($templating[$dataNama])) {
                        $replace = $this->displayDataList($namaInputan, $templating[$dataNama]);
                        // kalo return nya array, maka ada 'keyword link nya'
                        if (is_array($replace)) {

                            $display = str_replace($list, $replace['text'], $display);
                            // replace link
                            foreach ($replace['link_list'] as $list) :
                                $display = str_replace($list['keyword'], $list['data'], $display);
                            endforeach;
                        } else {

                            $display = str_replace($list, $replace, $display);
                        }
                    }
                }
                // kalo tipe inputannya 'DateRange'
                elseif ($tipeInputan == 'DateRange') {
                    if (isset($templating[$dataNama])) {
                        $replace = $this->displayDataDateRange($namaInputan, $templating[$dataNama]);
                        $display = str_replace($list, $replace, $display);
                    }
                }
                // kalo tipe inputannya 'Table'
                elseif ($tipeInputan == 'Table') {
                    $replace = $this->displayDataTable($namaInputan, $templating);
                    $display = str_replace($list, $replace, $display);
                }

            endforeach;
            $this->html = $display;
            // echo $display;
            // exit(1);
        }

        return $this;
    }

    private function displayDataList($keyword, $data)
    {
        $text = '';
        switch ($keyword) {
            case 'Unit Kerja Kepala':
                $kepala = DB::table('unit_kerja__kepala')->where('id', $data)->first();
                if ($kepala != null) {
                    $text = $kepala->nama;
                }

                break;
            case 'Unit Kerja Divisi':
                $divisi = DB::table('unit_kerja__divisi')->where('id', $data)->first();
                if ($divisi != null) {
                    $text = $divisi->nama;
                }

                break;

            case 'Unit Kerja Bagian':
                $bagian = DB::table('unit_kerja__bagian')->where('id', $data)->first();
                if ($bagian != null) {
                    $text = $bagian->nama;
                }

                break;

            case 'Pejabat':

                $pejabat = DB::table('karyawan')
                    ->leftJoin('jabatan', 'jabatan.id', '=', 'karyawan.id_jabatan')
                    ->leftJoin('pangkat', 'pangkat.id', '=', 'karyawan.id_pangkat')
                    ->where('status', '2')
                    ->where('karyawan.id', $data)
                    ->first();

                $patternLink = "/\\\$Link->{$keyword}->\{\{[a-zA-Z0-9\s]*\}\}/";
                if (preg_match_all($patternLink, $this->html, $hasil) and $pejabat != null) {
                    $hasil = $hasil[0];

                    $tampung = [];
                    foreach ($hasil as $list) :
                        $patternRemove = "/\\\$Link->{$keyword}->\{\{|\}\}/";
                        $keywordLink = preg_replace($patternRemove, '', $list);
                        switch ($keywordLink) {
                            case 'NIP':
                                $tampung[] = [
                                    'keyword'   => $list,
                                    'data'      => $pejabat->nip
                                ];
                                break;
                            case 'Nama Pejabat':
                                $tampung[] = [
                                    'keyword'   => $list,
                                    'data'      => $pejabat->nama_karyawan
                                ];
                                break;
                        }
                    endforeach;

                    return [
                        'text'        => $pejabat->nama_jabatan,
                        'link_list'   => $tampung
                    ];
                }
                break;
        }

        return $text;
    }

    private function displayDataDateRange($keyword, $data)
    {
        $text = '';
        switch ($keyword) {
            case $keyword  == 'Lama Perdin' || $keyword == 'Lama Perdin Realisasi':
                $split = explode(' - ', $data);

                $tanggalAwal = $split[0] ?? null;
                $tanggalAkhir = $split[1] ?? null;
                if ($tanggalAkhir != null && $tanggalAkhir != null) {
                    $selisih = $this->dateDiff($tanggalAwal, $tanggalAkhir);
                    if ($selisih == 0)
                        $selisih = 1;
                    $selisihHari = $selisih . ' Hari';
                    $text = $tanggalAwal . ' s/d ' . $tanggalAkhir . ' / ' . $selisihHari;
                }
                break;
        }

        return $text;
    }

    private function displayDataTable($keyword, $data)
    {
        // dd($data);
        $html = '';
        switch ($keyword) {
            case 'Biaya Perjalanan Dinas':
                if (!isset($data['jenis_fasilitas']) || !isset($data['nilai_pengajuan']) || !isset($data['nilai_realisasi']))
                    return $html;
                $fasilitas = $data['jenis_fasilitas'];
                $html = " <tbody style='font-family:mnospace; '>";
                $totalPengajuan = 0;
                $totalRealisasi = 0;
                $nilaiRealisasi = 0;
                $nilaiPengajuan = 0;
                // dd($data);
                $no = 1;
                foreach ($fasilitas as $key => $list) :
                    $totalPengajuan += (int) str_replace('.', '', $data['nilai_pengajuan'][$key]);
                    $totalRealisasi += (int) str_replace('.', '', $data['nilai_realisasi'][$key]);
                    $nilaiPengajuan = '0.00';
                    $nilaiRealisasi = '110.00';
                    if (!empty($data['nilai_pengajuan'][$key]))
                        $nilaiPengajuan = $data['nilai_pengajuan'][$key] . '.00';
                    if (!empty($data['nilai_realisasi'][$key]))
                        $nilaiRealisasi = $data['nilai_realisasi'][$key] . '.00';
                    $html .= "
                        <tr class='border' >    
                            <td style='text-align: center;' width='3%'>{$no}</td>
                            <td>{$list}</td>
                            <td>
                                <div style='float:left'>Rp.</div>
                                <div style='float:right;'>{$nilaiPengajuan}</div>
                            </td>
                            <td style='position:relative; '>
                                <div style='position:absolute; left:-10px;'>Rp.</div>
                                <div style='position:absolute; right:26px;'>{$nilaiRealisasi}</div>
                            </td>
                        </tr>
                        ";
                    $no++;
                endforeach;
                $formatTotalPengajuan = number_format($totalPengajuan, 2, ',', '.');
                $formatTotalRealisasi = number_format($totalRealisasi, 2, ',', '.');
                $selisih = number_format($totalRealisasi - $totalPengajuan, 2, ',', '.');

                $html .= "</tbody>";
                $html .= "
                    <tr class='border'>
                        <td colspan='2' style='text-align:center; font-weight:600'>TOTAL NILAI</td>
                        <td style=' font-weight:600'>
                            <div style='float:left'>Rp.</div>
                            <div style='float:right; text-align:right;'>{$formatTotalPengajuan}</div>
                        </td>
                        <td style=' font-weight:600; position:relative;'>
                            <div style='position:absolute; left:-11px;'>Rp.</div>
                            <div style='position:absolute; right:26px;'>{$formatTotalRealisasi}</div>
                        </td>
                    </tr>
                ";

                $html .= "
                <tr style='border:none'>
                    <td  style='border:none; font-size:12px; font-weight:700; padding-top:5px;' colspan=2>
                        <div style='margin-top:5px'>
                            SELISIH BIAYA PERJALANAN DINAS
                        </div>
                    </td>
                    <td  style='border:none font-size:12px; font-weight:700;'>
                        <div style='font-weight-700'>
                            Rp. &nbsp; &nbsp; &nbsp; &nbsp; {$selisih}
                        </div>
                    </td>
                    <td>&nbsp;</td>

                </tr>
                ";
                break;
        }

        return $html;
    }
    private function dateDiff($tglAwal, $tglAkhir)
    {
        $timeTglAwal = strtotime($tglAwal); // or your date as well
        $timeTglAkhir = strtotime($tglAkhir);
        $dateDiff =  $timeTglAkhir - $timeTglAwal;
        return round($dateDiff / (60 * 60 * 24));;
    }
}
