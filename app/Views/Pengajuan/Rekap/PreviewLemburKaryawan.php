<?php
$library = new App\Libraries\Library();

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
                </td>
            </tr>
        </table>
        <div style="margin-top:20px">
            <table style="width:100%">
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

        <div style="width:80%; float:left; margin-top:30px">
            <div style='margin-left:0px'>

                <table cellpadding=4 width='100%'>
                    <tr>
                        <td>1.&nbsp; NIP/Nama Karyawan</td>
                        <td>:</td>
                        <td><?= "{$pengaju->nip} / " . strtoupper($pengaju->nama_karyawan) ?></td>
                    </tr>

                    <tr>
                        <td>2.&nbsp; Pangkat/Jabatan</td>
                        <td>:</td>
                        <td><?= "{$pengaju->nama_pangkat} / {$pengaju->nama_jabatan}" ?></td>
                    </tr>

                    <tr>
                        <td>3.&nbsp; Divisi</td>
                        <td>:</td>
                        <td><?= $pengaju->nama_divisi ?></td>
                    </tr>

                </table>
            </div>
            <br /><br />

        </div>

        <div style='clear:both;'></div>

        <table style="margin-top:50px; width:100%; border-collapse:collapse" cellpadding='4' border="1">
            <tr>
                <th width='2%'>NO</th>
                <th width='10%'>NO.Doct</th>
                <th>Tanggal Lembur</th>
                <th>Lama Lembur</th>
                <th>Keterangan</th>
                <th>Pengawas</th>
            </tr>
            <?php
            $no = 1;
            foreach ($pengajuan as $list) :
                $template = json_decode($list->data_template);

            ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td><?= $list->nomor ?></td>
                    <td><?= $template->tgl_lembur ?></td>
                    <td><?= $template->lama_lembur ?> Jam</td>
                    <td><?= $template->keterangan ?></td>
                    <td><?= $list->nama_penandatangan ?></td>

                </tr>

            <?php endforeach; ?>
        </table>



    </div>


</body>

</html>