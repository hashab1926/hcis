<?php
$library = new App\Libraries\Library();
$explodeTahBul = explode('-', $template->tahun_bulan);
$tahun = $explodeTahBul[0];
$bulan = $explodeTahBul[1];

?>
<html>
<style>
    * {
        font-size: 12px;
        font-family: Arial, Helvetica, sans-serif;
        color: blue;
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
        margin-left: 10px;
        margin-right: 10px;
    }

    table.border-reimburse,
    table.border-reimburse tr,
        {
        border: 1px solid black;
    }

    table.border-reimburse tr td {
        border-bottom: 1px solid black;
    }

    .color-ccc {
        background-color: #ccc;
    }
</style>

<body>
    <div style=" font-size: 12px; height:1050px">

        <table width=100%>
            <tr>
                <td width='5%'><img src="https://recruitment.inti.co.id/images/logo_inti2.png" width=75></td>
                <td width='' style='text-align: center; font-weight:600; width:95%'>
                    <span style='border-bottom:1px solid black; padding-bottom:5px; padding:5px; font-size:14px;'>
                        PENGAJUAN REIMBURSE FASILITAS KOMUNIKASI
                    </span>
                    <div style='margin-top:7px; font-size:14px'>PASCA BAYAR</div>
                </td>
            </tr>
        </table>

        <div style="margin-top:40px; margin-left:190px background:red;">
            <table cellpadding=5 style='font-weight:700'>
                <tr>
                    <td style=''>NO.PENGAJUAN</td>
                    <td>:</td>
                    <td><?= $pengajuan->nomor ?></td>
                </tr>
                <tr>
                    <td>TGL.PENGAJUAN</td>
                    <td>:</td>
                    <td><?= $template->tgl_pengajuan ?></td>
                </tr>
                <tr>
                    <td>TAHUN/BULAN</td>
                    <td>:</td>
                    <td><?= $tahun . ' &nbsp; &nbsp; ' . $bulan ?></td>
                </tr>
                <tr>
                    <td>DIVISI</td>
                    <td>:</td>
                    <td><?= $template->divisi ?></td>
                </tr>
            </table>

        </div>

        <div style='margin-top:20px'>
            <table class='border-reimburse' cellpadding=4 width='100%' style='border-collapse:collapse'>
                <tr>
                    <td style='text-align:center'>NO.</td>
                    <td>NIP</td>
                    <td>NAMA</td>
                    <td>PANGKAT</td>
                    <td>PLAFON MAXIMAL</td>
                    <td>NILAI TOTAL</td>
                    <td style=' font-weight:700'><i>SELISIH PLAFON</i></td>
                    <td>HP NOMOR</td>
                    <td>NILAI (Rp.)</td>
                </tr>

                <tr>
                    <td style='text-align:center'><?= $template->no ?></td>
                    <td><?= $template->nip ?></td>
                    <td><?= strtoupper($template->nama_karyawan) ?></td>
                    <td><?= $template->nama_pangkat ?></td>
                    <td><?= $template->plafon_maximal ?></td>
                    <td><?= $template->plafon_maximal ?></td>
                    <td></td>
                    <td><?= $template->hp_nomor ?></td>
                    <td><?= $template->plafon_maximal ?></td>
                </tr>
            </table>
        </div>

        <div style='margin-top:100px'>
            <table style="width:100%">
                <tr>
                    <td width="60%" style="text-align:left;">
                        <div style="text-align: center; width:200px; ">
                            <div>
                                <?= strtoupper($pengaju->nama_bagian) ?>
                            </div>
                            <br /><br /><br /><br /><br /><Br /><br />
                            <span style="border-bottom:1px solid black; padding-bottom:5px">
                                <?= strtoupper($pengaju->nama_karyawan) ?>
                            </span>
                            <div style="margin-top:10px">NIP.<?= $pengaju->nip ?></div>

                        </div>

                    </td>

                    <td width="40%">
                        <div style="text-align: center; ">
                            <div>YANG MENGAJUKAN</div>
                            <div style='margin-top:5px'><?= $penandatangan->nama_jabatan ?></div>

                            <br /><br /><br /><br /><br /><Br /><br />
                            <span>
                                <span style="border-bottom:1px solid black; padding-bottom:5px">
                                    <?= strtoupper($penandatangan->nama_karyawan) ?></span>
                            </span>
                            <div style="margin-top:10px">NIP. <?= $penandatangan->nip ?></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div style='clear:both; margin-top:20px'></div>


    </div>
    <div style="width:100%; text-align:center; font-family: monospace; font-size:10px; margin-top:20px; color:black;">
        Dicetak Oleh : <?= strtoupper($pengaju->nama_karyawan) ?> <?= $library->tanggalToText(date('Y-m-d H:i:s')) ?> </div>

</body>

</html>