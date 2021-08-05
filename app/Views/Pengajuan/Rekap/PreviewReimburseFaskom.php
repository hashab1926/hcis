<?php
$library = new App\Libraries\Library();

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
                        PENGAJUAN REIMBURSE FASILITAS KOMUNIKASI
                    </span>
                    <div style='margin-top:7px; font-size:14px'>PASCA BAYAR</div>
                </td>
            </tr>
        </table>


        <div style="width:45%; float:left; margin-top:30px">
            <div style='margin-left:0px'>

                <table cellpadding=4 width='100%'>
                    <tr>
                        <td rowspan=4>
                            <?php if (isset($pengaju->mime)) : ?>
                                <img src="data:<?= $pengaju->mime; ?>;base64, <?= $pengaju->foto ?>" width=100 height=120>
                            <?php endif; ?>
                        </td>
                        <td style='font-weight:700'>NIP</td>
                        <td><?= $pengaju->nip ?></td>
                    </tr>
                    <tr>
                        <td style='font-weight:700'>Nama</td>
                        <td><?= $pengaju->nama_karyawan ?></td>
                    </tr>
                    <tr>
                        <td style='font-weight:700'>Jabatan</td>
                        <td><?= $pengaju->nama_jabatan ?></td>
                    </tr>
                    <tr>
                        <td style='font-weight:700'>Unit Kerja</td>
                        <td><?= $pengaju->nama_divisi ?></td>
                    </tr>

                </table>
            </div>
        </div>
        <div style="width:55%; float:right;">
            <table class='bordered' cellpadding=7 width='100%'>
                <tr style="font-weight:700; text-align:center">
                    <td width='2%'>NO</td>
                    <td width='10%'>NO PENGAJUAN</td>
                    <td>NILAI REIMBURSE</td>
                    <td>HP NOMOR</td>
                    <td width='25%'>NILAI (Rp.)</td>

                </tr>

                <?php
                $no = 1;
                $total = 0;
                foreach ($pengajuan as $list) :
                    if (!empty($list->data_template)) {

                        $template = json_decode($list->data_template);
                        $tgl = explode('-', $template->tahun_bulan);
                        $total += str_replace('.', '', $template->plafon_maximal);
                    }
                ?>
                    <tr>
                        <td style='text-align:center'><?= $no++ ?></td>
                        <td><?= $list->nomor ?></td>
                        <td style='text-align:center'><?= $library->bulanToText($tgl[1]) ?></td>
                        <td><?= $template->hp_nomor ?></td>
                        <td style='text-align:right;'><?= $template->plafon_maximal ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" style='text-align:right; font-weight:700'>
                        TOTAL YANG DIBAYARKAN
                    </td>
                    <td style='text-align:right;'>
                        <div style='float:left'>Rp.</div>
                        <div style='float:right'><?= number_format($total, 0, ',', '.') ?></div>

                    </td>
                </tr>
            </table>
        </div>

        <div style='clear:both; margin-top:20px'></div>


    </div>


</body>

</html>