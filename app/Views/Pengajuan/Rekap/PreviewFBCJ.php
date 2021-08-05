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
        border-collapse: separate;
    }

    table.bordered tr td,
    table.bordered tr th {
        border: 1px solid black;
    }

    .color-ccc {
        background-color: #ccc;
    }
</style>

<body>
    <div style=" font-size: 12px; height:850px">

        <table width=100%>
            <tr>
                <td width='5%'></td>
                <td width='' style='text-align: center; font-weight:700; width:95%'>
                    <span style='padding-bottom:5px; padding:5px; font-size:16px;'>
                        REKAPITULASI FBCJ
                    </span>

                </td>
            </tr>
        </table>

        <div style='margin-top:20px'>
            <table width='100%' style="font-weight:700">
                <tr>
                    <td style="font-size:14px">NO.BUNDLE : <?= $fbcj->nomor ?></td>
                </tr>
            </table>

        </div>

        <div style='margin-top:10px'>
            <table class='bordered' width='100%' cellpadding=5>
                <tr>
                    <th width=2%>No</th>
                    <th>Doc No</th>
                    <th>Bussiness Transaction</th>
                    <th>Wbs Element</th>
                    <th>Amount</th>
                    <th>Recipient</th>
                </tr>
                <tr style="border:none">
                    <td style="border:none" colspan="6"></td>
                </tr>
                <?php
                $no = 1;
                $totalAmount = 0;
                foreach ($detail as $list) :
                    $totalAmount += $list->amount;

                ?>
                    <tr>
                        <td style="font-size:10px; vertical-align: text-top; text-align:center"><?= $no++ ?></td>
                        <td style="font-size:10px; vertical-align: text-top;"><?= $list->doc_no ?></td>
                        <td style="font-size:10px; vertical-align: text-top;"><?= $list->kode_bussiness_trans . ' ' . $list->nama_bussiness_trans ?></td>
                        <td style="font-size:10px; vertical-align: text-top;"><?= $list->kode_wbs_element ?></td>
                        <td style="font-size:10px; vertical-align: text-top; text-align:right"><?= number_format($list->amount, 0, ',', '.') ?></td>
                        <td style="font-size:10px; vertical-align: text-top;"><?= strtoupper($list->nama_karyawan) ?></td>

                    </tr>
                <?php

                endforeach; ?>
                <tr style="border:none">
                    <td colspan=4 style="font-weight:700; text-align:right; border:none"> TOTAL AMOUNT</td>
                    <td style="border:none">
                        <div style="font-weight:700; float:left; ">Rp.</div>
                        <div style="font-weight:700; float:right;"><?= number_format($totalAmount, 0, ',', '.') ?></div>
                        <div style='clear:both'></div>
                    </td>
                    <td style="border:none"></td>
                </tr>
            </table>
        </div>


    </div>


    <div>
        <div style='width:100%;'>
            <div style='width:300px; text-align:center;'>
                <div style=" font-size:14px">Mengetahui,</div>
                <div style='margin-top:10px; font-weight:700; font-size:14px'><?= strtoupper($fbcj->jabatan_penandatangan) ?></div>
                <div style='margin:100px 0;'></div>
                <div style=" font-size:14px; font-weight:700;">( <?= strtoupper($fbcj->nama_penandatangan) ?> )</div>
            </div>
        </div>

    </div>

</body>

</html>