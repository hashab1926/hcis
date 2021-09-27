<?php
$library = new App\Libraries\Library();

?>
<html>
<style>
    * {
        font-size: 12px;
        font-family: Arial, Helvetica, sans-serif;
    }

    @page {
        margin-top: 10px;
        margin-bottom: 0;
        margin-left: 20px;
        margin-right: 20px;
    }

    table {
        border-collapse: collapse;

    }

    table tr th {
        border: none;
    }

    .color-ccc {
        background-color: #ccc;
    }
</style>

<body>
    <div style=" font-size: 12px;">

        <table width=100%>
            <tr>
                <td width='5%'></td>
                <td width='' style='text-align: center; font-weight:700; width:95%'>
                    <span style='padding-bottom:5px; padding:5px; font-size:16px;'>
                        DAFTAR PERDIN YANG SUDAH VALIDASI REALISASI LANGSUNG
                    </span>
                    <?php $input = $_GET;
                    if (isset($input['tgl_awal']) && isset($input['tgl_akhir'])) :
                        $explodeAwal =  explode('-', $input['tgl_awal']);
                        $explodeAkhir =  explode('-', $input['tgl_akhir']);

                        $bulanAwal =  $library->bulanToText($explodeAwal[1]) . ' ' . $explodeAwal[0];
                        $bulanAkhir =  $library->bulanToText($explodeAkhir[1]) . ' ' . $explodeAkhir[0];

                    ?>
                        <div style='margin-top:10px'>Tanggal Posting : <?= $bulanAwal == $bulanAkhir ? $bulanAwal : "{$bulanAwal} s/d {$bulanAkhir}" ?> </div>
                    <?php else :  ?>
                        <div style='margin-top:10px'>Keseluruhan</div>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <div style='margin-top:20px'>
            <table width='100%' style="font-weight:700">
                <tr>
                    <td>Kas Jurnal : KD11</td>
                    <?php if (isset($input['id_divisi'])) : ?>
                        <td>DIVISI : <?= $pengaju->nama_divisi ?></td>
                    <?php endif; ?>
                </tr>
            </table>

        </div>

        <div style='margin-top:10px'>
            <table width='100%' cellpadding=7 border=1>
                <tr style='background:#73b4f5'>
                    <th>NO</th>
                    <th>NO PERDIN</th>
                    <th>NIP</th>
                    <th>NAMA</th>
                    <th>TGL BERANGKAT</th>
                    <th>TGL KEMBALI</th>
                    <th>LAMA</th>
                    <th>PROPINSI TUJUAN</th>
                    <th>TOTAL PENGAJUAN</th>
                    <th>TOTAL REALISASI</th>
                    <th>JENIS FASILITAS</th>
                    <th>NILAI RP</th>
                    <th>REAL RP</th>
                </tr>

                <?php
                $no = 1;
                $grandTotalPengajuan = 0;
                $grandTotalRealisasi = 0;

                foreach ($pengajuan as $list) :
                    $template = json_decode($list->data_template);
                    $explodeTgl = isset($template->lama_perdin_realisasi) ? explode(' - ', $template->lama_perdin_realisasi) : [];
                    $tglAwal = $explodeTgl[0] ?? '';
                    $tglAkhir = $explodeTgl[1] ?? '';
                    $selisih = $library->dateDiff($tglAwal, $tglAkhir);
                    $countFasilitas = isset($template->jenis_fasilitas) ? count($template->jenis_fasilitas) : 1;

                ?>
                    <tr>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countFasilitas ?>"><?= $no++ ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countFasilitas ?>"><?= $list->nomor ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countFasilitas ?>"><?= $list->nip_pengaju ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countFasilitas ?>"><?= strtoupper($list->nama_pengaju) ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countFasilitas ?>"><?= $tglAwal; ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countFasilitas ?>"><?= $tglAkhir ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countFasilitas ?>"><?= $selisih ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countFasilitas ?>"><?= strtoupper($template->kategori_wilayah) ?></td>
                        <!-- NILAI PENGAJUAN  -->
                        <?php
                        $totalPengajuan = 0;
                        if (isset($template->nilai_pengajuan) && !empty($template->nilai_pengajuan)) {
                            foreach ($template->nilai_pengajuan as $nilai) :
                                if (!empty($nilai)) {
                                    $totalPengajuan += str_replace('.', '', $nilai);
                                    $grandTotalPengajuan += str_replace('.', '', $nilai);
                                } ?>
                        <?php
                            endforeach;
                        } ?>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countFasilitas ?>">
                            <div style='float:left; font-size:10px;'>Rp.</div>
                            <div style='float:right; font-size:10px;'> <?= number_format($totalPengajuan, 0, ',', '.') ?></div>
                            <div style='clear:both'></div>
                        </td>
                        <!-- /NILAI PENGAJUAN  -->

                        <!-- NILAI REALISASI  -->
                        <?php
                        $totalRealisasi = 0;
                        if (isset($template->nilai_realisasi)) {
                            if (isset($template->nilai_realisasi)) {
                                foreach ($template->nilai_realisasi as $nilai) :
                                    if (!empty($nilai)) {

                                        $totalRealisasi += str_replace('.', '', $nilai);
                                        $grandTotalRealisasi += str_replace('.', '', $nilai);
                                    }
                                endforeach;
                            }
                        } ?>
                        <td style="font-size:10px" rowspan="<?= $countFasilitas ?>">
                            <div style='float:left;  font-size:10px;'>Rp.</div>
                            <div style='float:right;  font-size:10px;'> <?= number_format($totalRealisasi, 0, ',', '.') ?></div>
                            <div style='clear:both'></div>
                        </td>
                        <!-- /NILAI REALISASI  -->
                        <td style="font-size:10px" width='13%'><?= isset($template->jenis_fasilitas) ? $template->jenis_fasilitas[0] : '0'  ?></td>
                        <td style="font-size:10px" width='7%'>
                            <div style='float:left;  font-size:10px;'>Rp.</div>
                            <div style='float:right;  font-size:10px;'> <?= isset($template->nilai_pengajuan) ? $template->nilai_pengajuan[0] : '0'  ?></div>
                            <div style='clear:both'></div>

                        </td>
                        <td style="font-size:10px" width='7%'>
                            <div style='float:left;  font-size:10px;'>Rp.</div>
                            <div style='float:right;  font-size:10px;'> <?= isset($template->nilai_realisasi) ? $template->nilai_realisasi[0] : '0'  ?></div>
                            <div style='clear:both'></div>

                        </td>

                    </tr>

                    <?php for ($x = 1; $x < $countFasilitas; $x++) { ?>
                        <tr>
                            <td style="font-size:10px"><?= isset($template->jenis_fasilitas[$x]) ? $template->jenis_fasilitas[$x] : ''  ?></td>
                            <td style="font-size:10px">
                                <div style='float:left;  font-size:10px;'>Rp.</div>
                                <div style='float:right;  font-size:10px;'> <?= isset($template->nilai_pengajuan[$x]) ? $template->nilai_pengajuan[$x] : '0'  ?></div>
                                <div style='clear:both'></div>


                            </td>
                            <td style="font-size:10px">
                                <div style='float:left;  font-size:10px;'>Rp.</div>
                                <div style='float:right;  font-size:10px;'> <?= isset($template->nilai_realisasi[$x]) ? $template->nilai_realisasi[$x] : '0'  ?></div>
                                <div style='clear:both'></div>
                            </td>

                        </tr><?php } ?>
                <?php endforeach; ?>
            </table>
        </div>

        <div style='margin-left:20px; margin-top:20px'>
            <table width='30%' cellpadding=5>
                <tr style="font-weight:700">
                    <td>TOTAL PENGAJUAN</td>
                    <td>
                        <div style='float:left;  font-size:14px; font-weight:700;'>Rp.</div>
                        <div style='float:right;  font-size:14px; font-weight:700;'><?= number_format($grandTotalPengajuan, 2, ',', '.') ?></div>
                        <div style='clear:both'></div>
                    </td>
                </tr>

                <tr style="font-weight:700">
                    <td>TOTAL REALISASI</td>
                    <td>
                        <div style='float:left;  font-size:14px; font-weight:700;'>Rp.</div>
                        <div style='float:right;  font-size:14px; font-weight:700;'><?= number_format($grandTotalRealisasi, 2, ',', '.') ?></div>
                    </td>
                </tr>
            </table>
        </div>

    </div>


</body>

</html>