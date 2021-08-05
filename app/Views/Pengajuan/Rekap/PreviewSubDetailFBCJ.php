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
                        REKAPITULASI FBCJ DETAIL
                    </span>

                </td>
            </tr>
        </table>

        <div style='margin-top:20px'>
            <table width='100%' style="font-weight:700">
                <tr>
                    <td style="font-size:17px">NO.BUNDLE : <?= $fbcj->nomor ?></td>
                </tr>
            </table>

        </div>

        <div style='margin-top:10px'>
            <table width='100%' cellpadding=7 border=1>
                <tr style='background:#ccc'>
                    <th>No</th>
                    <th>Doc No</th>
                    <th>Bussiness Transaction</th>
                    <th>Wbs Element</th>
                    <th>Cost Center</th>
                    <th style="text-align:right">Amount</th>
                    <th>Recepient</th>
                    <?php if ($empty_sub_detail == false) : ?>
                        <th>No</th>
                        <th>Keterangan</th>
                        <th>Tanggal BON</th>
                        <th>Amount Detail</th>
                    <?php endif ?>
                </tr>
                <?php
                $no = 1;
                $totalAmount = 0;
                foreach ($detail as $list) :
                    $subDetail = $library->filterArrayKey($library->objectToArray($sub_detail), 'id_fbcj_detail', $list->id);
                    $countRowspan =  count($subDetail);

                ?>
                    <tr>
                        <td style="font-size:10px; vertical-align: text-top; text-align:center" rowspan="<?= $countRowspan ?>"><?= $no++ ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countRowspan ?>"><?= $list->doc_no ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countRowspan ?>"><?= $list->kode_bussiness_trans . ' ' . $list->nama_bussiness_trans ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countRowspan ?>"><?= $list->kode_wbs_element ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countRowspan ?>"><?= $fbcj->kode_cost_center ?></td>
                        <td style="font-size:10px; vertical-align: text-top; text-align:right" rowspan="<?= $countRowspan ?>"><?= number_format($list->amount, 0, ',', '.') ?></td>
                        <td style="font-size:10px; vertical-align: text-top;" rowspan="<?= $countRowspan ?>"><?= strtoupper($list->nama_karyawan) ?></td>
                        <?php if ($empty_sub_detail == false) {
                            $totalAmount +=  $subDetail[0]['amount_detail'];
                        ?>
                            <td style="font-size:10px; text-align:center; ">1</td>
                            <td style="font-size:10px"><?= $subDetail[0]['keterangan'] ?> s</td>
                            <td style="font-size:10px"><?= $subDetail[0]['tanggal_bon'] ?></td>
                            <td style='text-align:right; font-size:10px'><?= number_format($subDetail[0]['amount_detail'], 0, ',', '.') ?></td>

                        <?php } ?>
                    </tr>
                    <?php if ($empty_sub_detail == false) {
                        $subNo = 2;
                        for ($x = 1; $x < $countRowspan; $x++) {
                            $totalAmount +=  $subDetail[$x]['amount_detail']; ?>
                            <tr>
                                <td style='text-align:center; font-size:10px'><?= $subNo++ ?></td>
                                <td style=" font-size:10px"><?= $subDetail[$x]['keterangan'] ?></td>
                                <td style=" font-size:10px"><?= $subDetail[$x]['tanggal_bon'] ?></td>
                                <td style='text-align:right;  font-size:10px'><?= number_format($subDetail[$x]['amount_detail'], 0, ',', '.') ?></td>
                            </tr>
                <?php }
                    }
                endforeach; ?>
                <tfoot>
                    <tr>
                        <td colspan=10 style="font-weight:700; text-align:right;"> TOTAL AMOUNT</td>
                        <td>
                            <div style="font-weight:700; float:left; ">Rp.</div>
                            <div style="font-weight:700; float:right;"><?= number_format($totalAmount, 0, ',', '.') ?></div>
                            <div style='clear:both'></div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div style='width:100%; margin-top:40px'>
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