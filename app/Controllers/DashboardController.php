<?php

namespace App\Controllers;

use App\Libraries\RequestApi\FBCJ;
use App\Libraries\RequestApi\Pengajuan;

class DashboardController extends BaseController
{

    public function __construct()
    {
        $this->pengajuan = new Pengajuan();
        $this->fbcj = new FBCJ();
    }

    private function statistikPengajuanHariIni()
    {
        $semuaPengajuan = $this->pengajuan->getPengajuan(['created_at' => date('Y-m-d')])->total_row;
        $perjalananDinas = $this->pengajuan->getPengajuan([
            'created_at'         => date('Y-m-d'),
            'jenis_pengajuan'    => 'perjalanan_dinas',
        ])->total_row;
        $perdinLuarKota = $this->pengajuan->getPengajuan([
            'created_at'         => date('Y-m-d'),
            'jenis_pengajuan'    => 'perdin_luar_kota',
        ])->total_row;
        $perdinDalamKota = $this->pengajuan->getPengajuan([
            'created_at'         => date('Y-m-d'),
            'jenis_pengajuan'    => 'perdin_dalam_kota',
        ])->total_row;
        $perdinLuarNegri = $this->pengajuan->getPengajuan([
            'created_at'         => date('Y-m-d'),
            'jenis_pengajuan'    => 'perdin_luar_negri',
        ])->total_row;
        $cuti = $this->pengajuan->getPengajuan([
            'created_at'         => date('Y-m-d'),
            'jenis_pengajuan'    => 'cuti',
        ])->total_row;
        $lembur = $this->pengajuan->getPengajuan([
            'created_at'         => date('Y-m-d'),
            'jenis_pengajuan'    => 'lembur',
        ])->total_row;
        $reimburseFaskom = $this->pengajuan->getPengajuan([
            'created_at'         => date('Y-m-d'),
            'jenis_pengajuan'    => 'reimburse_faskom',
        ])->total_row;


        return [
            'semua_pengajuan'   => $semuaPengajuan,
            'perjalanan_dinas'  => $perjalananDinas,
            'perdin_luarkota'   => $perdinLuarKota,
            'perdin_dalamkota'  => $perdinDalamKota,
            'perdin_luarnegri'  => $perdinLuarNegri,
            'cuti'              => $cuti,
            'lembur'            => $lembur,
            'reimburse'         => $reimburseFaskom,

        ];
    }

    private function statistikPengajuanBulanIni()
    {
        $perdinLuarKota = $this->pengajuan->getPengajuan([
            'created_at_bulan'   => date('Y-m'),
            'jenis_pengajuan'    => 'perdin_luar_kota',
        ])->total_row;
        $perdinDalamKota = $this->pengajuan->getPengajuan([
            'created_at_bulan'   => date('Y-m'),
            'jenis_pengajuan'    => 'perdin_dalam_kota',
        ])->total_row;
        $perdinLuarNegri = $this->pengajuan->getPengajuan([
            'created_at_bulan'   => date('Y-m'),
            'jenis_pengajuan'    => 'perdin_luar_negri',
        ])->total_row;
        $cuti = $this->pengajuan->getPengajuan([
            'created_at_bulan'   => date('Y-m'),
            'jenis_pengajuan'    => 'cuti',
        ])->total_row;
        $lembur = $this->pengajuan->getPengajuan([
            'created_at_bulan'   => date('Y-m'),
            'jenis_pengajuan'    => 'lembur',
        ])->total_row;
        $reimburseFaskom = $this->pengajuan->getPengajuan([
            'created_at_bulan'   => date('Y-m'),
            'jenis_pengajuan'    => 'reimburse_faskom',
        ])->total_row;


        return [
            'perdin_luarkota'   => $perdinLuarKota,
            'perdin_dalamkota'  => $perdinDalamKota,
            'perdin_luarnegri'  => $perdinLuarNegri,
            'reimburse'         => $reimburseFaskom,
            'cuti'              => $cuti,
            'lembur'            => $lembur,

        ];
    }

    private function statistikPengajuanTahunIni()
    {
        $semuaPengajuan = $this->pengajuan->getPengajuan(['created_at_tahun' => date('Y')])->total_row;
        $perjalananDinas = $this->pengajuan->getPengajuan([
            'created_at_tahun'   => date('Y'),
            'jenis_pengajuan'    => 'perjalanan_dinas',
        ])->total_row;
        $perdinLuarKota = $this->pengajuan->getPengajuan([
            'created_at_tahun'   => date('Y'),
            'jenis_pengajuan'    => 'perdin_luar_kota',
        ])->total_row;
        $perdinDalamKota = $this->pengajuan->getPengajuan([
            'created_at_tahun'   => date('Y'),
            'jenis_pengajuan'    => 'perdin_dalam_kota',
        ])->total_row;
        $perdinLuarNegri = $this->pengajuan->getPengajuan([
            'created_at_tahun'   => date('Y'),
            'jenis_pengajuan'    => 'perdin_luar_negri',
        ])->total_row;
        $cuti = $this->pengajuan->getPengajuan([
            'created_at_tahun'   => date('Y'),
            'jenis_pengajuan'    => 'cuti',
        ])->total_row;
        $lembur = $this->pengajuan->getPengajuan([
            'created_at_tahun'   => date('Y'),
            'jenis_pengajuan'    => 'lembur',
        ])->total_row;
        $reimburseFaskom = $this->pengajuan->getPengajuan([
            'created_at_tahun'   => date('Y'),
            'jenis_pengajuan'    => 'reimburse_faskom',
        ])->total_row;


        return [
            'semua_pengajuan'   => $semuaPengajuan,
            'perjalanan_dinas'  => $perjalananDinas,
            'perdin_luarkota'   => $perdinLuarKota,
            'perdin_dalamkota'  => $perdinDalamKota,
            'perdin_luarnegri'  => $perdinLuarNegri,
            'reimburse'         => $reimburseFaskom,
            'cuti'              => $cuti,
            'lembur'            => $lembur,

        ];
    }

    private function totalPengajuanPerdin($param)
    {
        $get = $this->pengajuan->getPengajuan($param);

        $source = $get->data;
        $totalNilaiRealisasi = 0;
        foreach ($source as $list) :
            $template = json_decode($list->data_template);
            if (isset($template->nilai_realisasi)) {
                foreach ($template->nilai_realisasi as $harga) {
                    if (!empty($harga))
                        $totalNilaiRealisasi += str_replace('.', '', $harga);
                }
            }
        endforeach;

        return $totalNilaiRealisasi;
    }

    private function totalPengajuanFaskom($param)
    {
        $get = $this->pengajuan->getPengajuan($param);

        $source = $get->data;
        $total = 0;
        foreach ($source as $list) :
            $template = json_decode($list->data_template);
            if (isset($template->plafon_maximal) && !empty($template->plafon_maximal)) {
                $total += str_replace('.', '', $template->plafon_maximal);
            }
        endforeach;

        return $total;
    }

    private function totalFBCJ($param)
    {
        $get = $this->fbcj->getFBCJ($param);
        $source = $get->data;
        $total = 0;
        foreach ($source as $list) :
            $detail = $this->fbcj->getFBCJDetail([], $list->id);

            if ($detail->total_row > 0) {
                $dataDetail = $detail->data;
                foreach ($dataDetail as $list) :
                    $total += $list->amount;
                endforeach;
            }
        endforeach;

        return $total;
    }

    private function listKonfirmasi()
    {
        $idKaryawan = $this->credential->get('id_karyawan');
        $konfirmasi = $this->pengajuan->getPengajuan([
            'id_penandatangan'  => $idKaryawan,
            'limit'             => 50,
            'order_by'          => 'desc',
            'status'            => 'proses'
        ]);

        return $konfirmasi->data;
    }

    private function tampungTotalPengajuanPerdin()
    {

        // luar kota
        $monthTotalPerdinLuarKota = $this->totalPengajuanPerdin([
            'jenis_pengajuan'   => 'perdin_luar_kota',
            'created_at_bulan'   => date('Y-m'),
        ]);

        $todayTotalPerdinLuarKota = $this->totalPengajuanPerdin([
            'jenis_pengajuan'   => 'perdin_luar_kota',
            'created_at'        => date('Y-m-d'),
        ]);


        // Dalam kota
        $monthTotalPerdinDalamKota = $this->totalPengajuanPerdin([
            'jenis_pengajuan'   => 'perdin_dalam_kota',
            'created_at_bulan'   => date('Y-m'),
        ]);

        $todayTotalPerdinDalamKota = $this->totalPengajuanPerdin([
            'jenis_pengajuan'   => 'perdin_dalam_kota',
            'created_at'        => date('Y-m-d'),
        ]);


        // Luar negri
        $monthTotalPerdinLuarNegri = $this->totalPengajuanPerdin([
            'jenis_pengajuan'   => 'perdin_luar_negri',
            'created_at_bulan'   => date('Y-m'),
        ]);

        $todayTotalPerdinLuarNegri = $this->totalPengajuanPerdin([
            'jenis_pengajuan'   => 'perdin_luar_negri',
            'created_at'        => date('Y-m-d'),
        ]);


        return [
            'total_perdinluarkota_hariini'    => $todayTotalPerdinLuarKota,
            'total_perdinluarkota_bulanini'   => $monthTotalPerdinLuarKota,

            'total_perdindalamkota_hariini'    => $todayTotalPerdinDalamKota,
            'total_perdindalamkota_bulanini'   => $monthTotalPerdinDalamKota,

            'total_perdinluarnegri_hariini'    => $todayTotalPerdinLuarNegri,
            'total_perdinluarnegri_bulanini'   => $monthTotalPerdinLuarNegri,
        ];
    }

    private function tampungTotalPengajuanFaskom()
    {

        $monthTotalFaskom = $this->totalPengajuanFaskom([
            'jenis_pengajuan'   => 'reimburse_faskom',
            'created_at_bulan'   => date('Y-m'),
        ]);

        $todayTotalFaskom = $this->totalPengajuanFaskom([
            'jenis_pengajuan'   => 'reimburse_faskom',
            'created_at'        => date('Y-m-d'),
        ]);


        return [
            'total_perdinluarkota_hariini'    => $todayTotalFaskom,
            'total_perdinluarkota_bulanini'   => $monthTotalFaskom,
        ];
    }

    private function tampungTotalPengajuanFBCJ()
    {
        $fbcjHariIni = $this->totalFBCJ([
            'created_at'    => date('Y-m-d')
        ]);

        $fbcjBulanIni = $this->totalFBCJ([
            'created_at_bulan'    => date('Y-m')
        ]);

        return [
            'fbcj_bulanini' => $fbcjBulanIni,
            'fbcj_hariiini' => $fbcjHariIni
        ];
    }


    public function index()
    {
        $data = [];
        // echo $this->allTotalPerdinLuarKota();
        // kalo yang login direktur
        if ($this->credential->get('level') == 'DIR') {
            $dataSetBulanIni = ("'" . implode("','", $this->statistikPengajuanBulanIni()) . "'");
            $data = [
                'login'               => 'dir',
                'pengajuan_tahunini'  => $this->statistikPengajuanTahunIni(),
                'pengajuan_bulanini'  => $dataSetBulanIni,
                'pengajuan_harini'    => $this->statistikPengajuanHariIni(),
                'list_konfirmasi'     => $this->listKonfirmasi(),
                'total_perdin'        => $this->tampungTotalPengajuanPerdin(),
                'total_fbcj'          => $this->tampungTotalPengajuanFBCJ(),
                'total_faskom'        => $this->tampungTotalPengajuanFaskom()
            ];
        }

        // printr($data);

        return view("Dashboard", $data);
    }
}
