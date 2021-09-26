<?php

$library = new App\Libraries\Library();
$title = '';
if ($pengajuan->nama_jenis == 'PD_LKOTA') :
    $title = "LUAR KOTA";
elseif ($pengajuan->nama_jenis == 'PD_DKOTA') :
    $title = "DALAM KOTA";
elseif ($pengajuan->nama_jenis == 'PD_LNGRI') :
    $title = "LUAR NEGRI";

endif;
?>
<html>
<style>
    * {
        font-size: 12px;
    }

    @page {
        margin-top: 10px;
        margin-bottom: 0;
        margin-left: 20px;
        margin-right: 10px;
    }

    body {
        margin-top: 10px;
        margin-bottom: 0;
        margin-left: 20px;
        margin-right: 10px;
    }

    table.border {
        border-collapse: collapse;
    }

    tr.border,
    tr.border td,
    tr.border th {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .color-ccc {
        background-color: #ccc;
    }
</style>

<body>
    <div style="border:1px solid black; height:990px; padding-left:15px; padding-top:5px; font-family:Arial; font-size: 12px;">

        <table width=100%>
            <tr>
                <td width='3%'><img src="https://recruitment.inti.co.id/images/logo_inti2.png" width=75></td>
                <td width='' style='text-align: center; font-weight:600; width:95%'>
                    <span style='border-bottom:1px solid black; padding-bottom:5px; padding:5px; font-size:14px;'>
                        REALISASI LANGSUNG PERJALANAN DINAS <?= $title ?>
                    </span>
                    <div style='margin-top:7px'>NOMOR : <?= $pengajuan->nomor ?></div>
                </td>
            </tr>
        </table>

        <div style="margin-top:20px">
            <table>
                <tr>
                    <td style="padding-left: 20px;">Unit Kerja &nbsp;&nbsp;&nbsp;&nbsp; : &nbsp; &nbsp; &nbsp; </td>
                    <td style="text-align: center;"><?= $pengaju->nama_kepala ?></td>
                    <td style="vertical-align: top;">/</td>
                    <td style="text-align: center;"><?= $pengaju->nama_divisi ?></td>
                    <td style="vertical-align: top;">/</td>
                    <td style="text-align: center;"><?= $pengaju->nama_bagian ?></td>
                </tr>
            </table>

        </div>

        <div style="margin-top:30px">
            <table cellpadding=5>
                <tr>
                    <td width='0.2%'>1.</td>
                    <td width='35%'>NIP/Nama Karyawan</td>
                    <td>:</td>
                    <td width='60%'><?= $pengaju->nip ?></td>
                </tr>
                <tr>
                    <td width='0.2%'>2.</td>
                    <td width='35%'>Pangkat / Jabatan</td>
                    <td>:</td>
                    <td width='60%'><?= $pengaju->nama_pangkat ?> / <?= $pengaju->nama_jabatan ?></td>
                </tr>
                <tr>
                    <td width='0.2%'>3.</td>
                    <td width='35%'>Kategori Wilayah Perjalanan Dinas</td>
                    <td>:</td>
                    <td width='60%'><?= $template->kategori_wilayah ?? '' ?></td>
                </tr>
                <tr>
                    <td width='0.2%'>4.</td>
                    <td width='35%'>Kota</td>
                    <td>:</td>
                    <td width='60%'><?= $template->kota ?? '' ?></td>
                </tr>
                <tr>
                    <td width='0.2%'>5.</td>
                    <td width='35%'>Pekerjaan</td>
                    <td>:</td>
                    <td width='60%'><?= $template->pekerjaan ?? '' ?></td>
                </tr>
                <tr>
                    <td width='0.2%'>6.</td>
                    <td width='35%'>Lama Perdin</td>
                    <td>:</td>
                    <td width='60%'><?= $template->lama_perdin ?? '' ?></td>
                </tr>
                <tr>
                    <td width='0.2%'>7.</td>
                    <td width='35%'>Lama Perdin Realisasi</td>
                    <td>:</td>
                    <td width='60%'><?= $template->lama_perdin_realisasi ?? '' ?></td>
                </tr>
                <tr>
                    <td width='0.2%'>8.</td>
                    <td width='35%'>WBS Element</td>
                    <td>:</td>
                    <td width='60%'><?= $template->wbs_element ?? '' ?></td>
                </tr>
                <tr>
                    <td width='0.2%'>9.</td>
                    <td width='35%'>Cost Center</td>
                    <td>:</td>
                    <td width='60%'><?= $template->cost_center ?? '' ?></td>
                </tr>
                <tr>
                    <td width='0.2%'>10.</td>
                    <td width='35%'>Business Trans</td>
                    <td>:</td>
                    <td width='60%'><?= $template->bussiness_trans ?? '' ?> </td>
                </tr>
            </table>
        </div>

        <div style="text-align: center; margin-top:20px;">
            <div style="font-weight:600; margin-bottom:10px;">Biaya Perjalanan Dinas</div>
            <table class='border' cellpadding=5 width="95%" style="margin-left:5px; ">
                <tr class="border color-ccc">
                    <th>No</th>
                    <th>Jenis Fasilitas</th>
                    <th>Nilai Pengajuan</th>

                    <?php if (isset($template->nilai_realisasi)) : ?>
                        <th>Nilai Realisasi</th>
                    <?php endif; ?>
                </tr>
                <tbody>
                    <?php



                    $fasilitas = $template->jenis_fasilitas ?? [];
                    $nilaiPengajuan = $template->nilai_pengajuan ?? [];
                    $nilaiRealisasi = $template->nilai_realisasi ?? [];
                    $no = 0;
                    $totalPengajuan = 0;
                    $totalRealisasi = 0;

                    foreach ($fasilitas as $key => $list) :
                        $totalPengajuan += str_replace('.', '', $nilaiPengajuan[$no]);
                        if (isset($nilaiRealisasi[$no]) && !empty($nilaiRealisasi[$no]))
                            $totalRealisasi += str_replace('.', '', $nilaiRealisasi[$no]);
                    ?>
                        <tr class='border'>
                            <td style='text-align: center;' width='3%'><?= $no + 1; ?></td>
                            <td><?= $list ?></td>
                            <td>
                                <div style='float:left'>Rp.</div>
                                <div style='float:right;'><?= $nilaiPengajuan[$no] ?></div>
                            </td>
                            <?php if (isset($nilaiRealisasi[$no])) : ?>
                                <td>
                                    <div style='float:left'>Rp.</div>
                                    <div style='float:right;'><?= $nilaiRealisasi[$no] ?></div>
                                </td>
                            <?php endif; ?>
                        </tr>

                    <?php $no++;

                    endforeach;
                    $totalPengajuan = number_format($totalPengajuan, 0, ',', '.');
                    $totalRealisasi = number_format($totalRealisasi, 0, ',', '.');

                    ?>
                    <tr class='border'>
                        <td colspan='2' style='text-align:center; font-weight:600'>TOTAL NILAI</td>
                        <td style=' font-weight:600'>
                            <div style='float:left'>Rp.</div>
                            <div style='float:right; text-align:right;'><?= $totalPengajuan ?></div>
                        </td>
                        <?php if (count($nilaiRealisasi)) : ?>
                            <td style=' font-weight:600'>
                                <div style='float:left'>Rp.</div>
                                <div style='float:right; text-align:right;'><?= $totalRealisasi ?></div>
                            </td>

                        <?php endif; ?>
                    </tr>
                </tbody>

            </table>

        </div>

        <div style='margin-top:100px'>
            <table style="width:100%">
                <tr>
                    <td width="60%" style="text-align:left;">
                        <div style="text-align: center; width:200px; ">
                            <div>Dibuat oleh yang melakukan perjalanan dinas </div>
                            <br /><br /><br /><br /><br /><Br /><br />
                            <span style="border-bottom:1px solid black; padding-bottom:5px">
                                <?= $pengaju->nama_karyawan ?>
                            </span>
                            <div style="margin-top:10px">NIP.<?= $pengaju->nip ?></div>

                        </div>

                    </td>
                    <td width="40%">
                        <div style="text-align: center; ">
                            <div>Pejabat Yang Memberi Perintah </div>
                            <div style='margin-top:5px'><?= $penandatangan->nama_jabatan ?></div>

                            <br /><br /><br /><br /><br /><Br /><br />
                            <span>
                                <span style="border-bottom:1px solid black; padding-bottom:5px">
                                    <?= $penandatangan->nama_karyawan ?></span>
                            </span>
                            <div style="margin-top:10px">NIP. <?= $penandatangan->nip ?></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div style='clear:both; margin-top:20px'></div>

        <div style="font-family: monospace;">
            <div style="width:60%; float:left">Tanggal <?= $library->tanggalToText($pengajuan->created_at, true) ?></div>
            <div style="width:40%; float:right">Tanggal <?= !empty($pengajuan->waktu_diacc) ? $library->tanggalToText($pengajuan->waktu_diacc, true) :  '' ?></div>
        </div>
    </div>
    <div style="width:100%; text-align:center; font-family: monospace; font-size:10px; margin-top:20px;">
        Dicetak Oleh :<?= $library->tanggalToText(date('Y-m-d H:i:s')) ?> </div>

</body>

</html>