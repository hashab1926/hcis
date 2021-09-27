<?php

$library = new App\Libraries\Library();
$credential = new App\Libraries\Credential(); ?>
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
                        SURAT PENGAJUAN LEMBUR KARYAWAN
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
                    <td width='35%'>Tanggal Lembur</td>
                    <td>:</td>
                    <td width='60%'><?= $template->tgl_lembur ?></td>
                </tr>
                <tr>
                    <td width='0.2%'>4.</td>
                    <td width='35%'>Lama Lembur</td>
                    <td>:</td>
                    <td width='60%'><?= $template->lama_lembur ?> Jam</td>
                </tr>
                <tr>
                    <td width='0.2%'>5.</td>
                    <td width='35%'>Keterangan</td>
                    <td>:</td>
                    <td width='60%'><?= $template->keterangan ?> Jam</td>
                </tr>

            </table>
        </div>


        <div style='margin-top:70px'>
            <table style="width:100%">
                <tr>
                    <td width="60%" style="text-align:left;">
                        <div style="text-align: center; width:200px; ">
                            <div> Pengawas Lembur</div>
                            <div style='margin-top:5px'><?= $penandatangan->nama_jabatan ?></div>

                            <br /><br /><br /><br /><br /><Br /><br />
                            <span>
                                <span style="border-bottom:1px solid black; padding-bottom:5px">
                                    <?= $penandatangan->nama_karyawan ?></span>
                            </span>
                            <div style="margin-top:10px">NIP. <?= $penandatangan->nip ?></div>
                        </div>

                    </td>
                    <td width="40%">
                        <div style="text-align: center; ">
                            <div>Pemohon</div>
                            <br /><br /><br /><br /><br /><Br /><br />
                            <span style="border-bottom:1px solid black; padding-bottom:5px">
                                <?= $pengaju->nama_karyawan ?>
                            </span>
                            <div style="margin-top:10px">NIP.<?= $pengaju->nip ?></div>

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
        Dicetak Oleh :<?= strtoupper($credential->get('nama_user')) ?> <?= $library->tanggalToText(date('Y-m-d H:i:s')) ?> </div>

</body>

</html>