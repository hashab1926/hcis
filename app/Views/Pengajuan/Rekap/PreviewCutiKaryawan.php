<?php
$library = new App\Libraries\Library();
$bulanAwal = '';
$bulanAkhir = '';

if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {

    $explodeBulanAwal = explode('-', $_GET['tgl_awal']);
    $explodeBulanAkhir = explode('-', $_GET['tgl_akhir']);

    $bulanAwal = $library->bulanToText($explodeBulanAwal[1]) . ' ' . $explodeBulanAwal[0];
    $bulanAkhir = $library->bulanToText($explodeBulanAkhir[1]) . ' ' . $explodeBulanAkhir[0];
}

?>
<html>
<style>
    * {
        font-size: 12px;
        font-family: 'Times New Roman', Times, serif;
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

    table.bordered,
    table.bordered tr {
        border: 1px solid black;
        border-collapse: separate;
    }

    table.bordered tr td {
        border-right: 1px solid black;
        border-bottom: 1px solid black;

    }

    table.bordered tr td:last-child {
        border-right: none;
    }

    table.bordered tr:last-child td {
        border-bottom: none;
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
                        REKAPITULASI LEMBUR KARYAWAN
                    </span>
                    <br />
                    <?= $pengaju->nama_divisi ?>
                </td>
            </tr>
        </table>
        <div style="width:45%; float:left; margin-top:30px">
            <div style='margin-left:0px'>

                <table cellpadding=4 width='100%'>
                    <tr>
                        <td style='font-weight:700'>BULAN</td>
                        <td>:</td>
                        <td><?= $bulanAwal . ' - ' . $bulanAkhir ?></td>
                    </tr>


                </table>
            </div>
            <br /><br />

        </div>

        <div style='clear:both;'></div>

        <table style="margin-top:50px; width:100%; border-collapse:collapse" cellpadding='4' border="1">
            <tr>
                <th width='2%'>NO</th>
                <th width='10%'>NIK</th>
                <th>Nama</th>
                <th>Tanggal Cuti</th>
                <th>Lama Cuti</th>
                <th>Alasan Cuti</th>

            </tr>
            <?php
            $no = 1;
            foreach ($pengajuan as $list) :
                $template = json_decode($list->data_template);
                $explode = explode(' - ', $template->lama_cuti);
                $tglAwal = $explode[0];
                $tglAkhir = $explode[1];
                $lamaCuti = $library->dateDiff($tglAwal, $tglAkhir);

                $dmyToYmdAwal = date("Y-m-d", strtotime($tglAwal));
                $dmyToYmdAkhir = date("Y-m-d", strtotime($tglAkhir));

                $tglAwalToText = $library->tanggalToText($dmyToYmdAwal, false, true);
                $tglAkhirToText = $library->tanggalToText($dmyToYmdAkhir, false, true);

            ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td><?= $list->nip_pengaju ?></td>
                    <td><?= $list->nama_pengaju ?></td>
                    <td><?= "{$tglAwalToText} - {$tglAkhirToText}" ?></td>
                    <td><?= $lamaCuti == 0 ? 1 : $lamaCuti + 1 ?> Hari</td>
                    <td><?= $template->alasan_cuti ?></td>
                </tr>

            <?php endforeach; ?>
        </table>



    </div>


</body>

</html>