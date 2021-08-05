<?php

namespace App\Controllers;

use App\Libraries\RequestApi\Pengajuan;

class DashboardController extends BaseController
{

    public function __construct()
    {
        $this->pengajuan = new Pengajuan();
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

    private function listKonfirmasi()
    {
        $idKaryawan = $this->credential->get('id_karyawan');
        $konfirmasi = $this->pengajuan->getPengajuan([
            'id_penandatangan'  => $idKaryawan,
            'limit'             => 50,
            'order_by'          => 'desc',
            'status'            => 'PROSES'
        ]);

        return $konfirmasi->data;
    }
    public function index()
    {
        $data = [];

        // kalo yang login direktur
        if ($this->credential->get('level') == 'DIR') {
            $dataSetBulanIni = ("'" . implode("','", $this->statistikPengajuanBulanIni()) . "'");
            $data = [
                'login'               => 'dir',
                'pengajuan_tahunini'  => $this->statistikPengajuanTahunIni(),
                'pengajuan_bulanini'  => $dataSetBulanIni,
                'pengajuan_harini'    => $this->statistikPengajuanHariIni(),
                'list_konfirmasi'     => $this->listKonfirmasi()
            ];
        }

        return view("Dashboard", $data);
    }
}
