<?php
$library = new App\Libraries\Library();
$credential = new App\Libraries\Credential();
?>
<html>
<style>
    * {
        font-size: 13px;
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
        margin-left: 0px;
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

<body style='font-family:Arial, Helvetica, sans-serif'>
    <div style='height:990px;'>
        <!-- HEADER -->
        <div>
            <table width="100%" border="1" style='border-collapse:collapse; '>
                <tr>
                    <td rowspan="3" style='font-weight:700; text-align:center;font-size:14px'>
                        DIVISI
                        <br>
                        MSDM
                    </td>
                    <td rowspan="3" style='font-weight:700; text-align:center;font-size:14px'>
                        LAMPIRAN<BR />
                        SURAT KEPUTUSAN DIREKSI
                    </td>
                    <td>
                        <table width='100%'>
                            <tr style='font-weight:700; font-size:14px'>
                                <td width='50%'>No.</td>
                                <td width='2%'>:</td>
                                <td>KN.012/2020</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width='100%'>
                            <tr style='font-weight:700; font-size:14px'>
                                <td width='50%'>Edisi</td>
                                <td width='2%'>:</td>
                                <td><?= $lampiran->edisi ?></td>
                            </tr>
                        </table>
                    </td>

                </tr>
                <tr>
                    <td>
                        <table width='100%'>
                            <tr style='font-weight:700; font-size:14px'>
                                <td width='50%'>Halaman.</td>
                                <td width='2%'>:</td>
                                <td>1</td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </div>
        <!-- HEADER -->

        <!-- BODY -->
        <div style='margin-top:15px'>
            <table width='70%' cellpadding=5>
                <tr>
                    <td style='font-weight:700'>No.Perdin</td>
                    <td>:</td>
                    <td><?= $lampiran->no_perdin ?></td>
                </tr>

                <tr>
                    <td style='font-weight:700'>NIP</td>
                    <td>:</td>
                    <td><?= $pengaju->nip ?></td>
                </tr>

                <tr>
                    <td style='font-weight:700'>Divisi</td>
                    <td>:</td>
                    <td><?= $pengaju->nama_divisi ?></td>
                </tr>

                <tr>
                    <td style='font-weight:700'>Kota Tujuan</td>
                    <td>:</td>
                    <td><?= $lampiran->kota ?></td>
                </tr>


                <tr>
                    <td style='font-weight:700'>Tanggal</td>
                    <td>:</td>
                    <td><?= $lampiran->lama_perdin_realisasi ?></td>
                </tr>

                <tr>
                    <td style='font-weight:700'>Tujuan</td>
                    <td>:</td>
                    <td><?= $lampiran->tujuan ?></td>
                </tr>

                <tr>
                    <td style='font-weight:700'>Biaya</td>
                    <td>:</td>
                    <td>Rp.<?= $lampiran->biaya ?></td>
                </tr>

                <tr>
                    <td style='font-weight:700'>Kuitansi</td>
                    <td>:</td>
                    <td><?= $lampiran->bon ?></td>
                </tr>
            </table>
        </div>
        <!-- BODY -->

        <!-- RINCIAN -->
        <div style='margin-top:50px; width:100%;'>
            <div style='text-align:center; font-weight:700'><?= strtoupper($lampiran->judul_rincian) ?></div>
            <div style='text-align:center; font-weight:500'>PERJALANAN DINAS ADA BUKTI</div>

            <div style='margin-top:10px'>
                <table style='width:100%; border-collapse:collapse;' cellpadding=5 border="1">
                    <tr style='background:#ddd'>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Uraian</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>

                    <?php
                    $tanggal = $lampiran->tanggal;
                    $no = 0;
                    $total = 0;
                    $jumlahBiaya = 0;
                    foreach ($tanggal as $key => $list) :
                        $jumlah = str_replace('.', '', $lampiran->jumlah[$no]) ?? 0;
                        $hargaSatuan = str_replace('.', '', $lampiran->harga_satuan[$no]) ?? 0;
                        $total = $jumlah * $hargaSatuan;
                        $jumlahBiaya += $total;
                    ?>
                        <tr>
                            <td style='text-align:center'><?= ($no + 1) ?></td>
                            <td style='text-align:center'><?= $list ?></td>
                            <td><?= $lampiran->uraian[$no] ?></td>
                            <td style='text-align:center'><?= $lampiran->jumlah[$no] ?></td>
                            <td><?= ucfirst($lampiran->satuan[$no]) ?></td>
                            <td style='padding-top:13px'>
                                <div style='float:left'>Rp.</div>
                                <div style='float:right'>
                                    <?= $lampiran->harga_satuan[$no] ?>
                                </div>
                                <div style='clear:both'></div>
                            </td>
                            <td style='padding-top:13px'>
                                <div style='float:left'>Rp.</div>
                                <div style='float:right'>
                                    <?= number_format($total, 0, ',', '.') ?>
                                </div>
                                <div style='clear:both'></div>
                            </td>

                        </tr>
                    <?php $no++;
                    endforeach;
                    ?>
                    <tr>
                        <td style='text-align:right; font-weight:700; padding:10px 50px;' colspan=6>Jumlah Biaya</td>
                        <td style='font-weight:700; padding-top:10px'>
                            <div style='float:left'>Rp.</div>
                            <div style='float:right; '>
                                <?= number_format($jumlahBiaya, 0, ',', '.') ?>
                            </div>
                            <div style='clear:both'></div>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- RINCIAN -->

        <!-- TTD -->
        <div style='width:100%; margin-top:40px'>
            <div style='float:right; width:300px; text-align:center;'>
                <div>Disetujui Oleh,</div>
                <div style='margin-top:10px'><?= strtoupper($penandatangan->nama_divisi) ?></div>
                <div style='margin:100px 0;'></div>
                <div>( <?= strtoupper($penandatangan->nama_karyawan) ?> )</div>
            </div>
        </div>
        <!-- TTD -->
    </div>

    <div style='width:100%; text-align:center; margin-top:70px; font-size:12px; font-family:monospace'>
        Dicetak Oleh : <?= strtoupper($credential->get('nama_user')) ?>
        tgl <?= date('d-m-Y') ?> pkl <?= date('H:i:s') ?>
    </div>
</body>

</html>