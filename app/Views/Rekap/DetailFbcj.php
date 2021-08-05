<?php
$library = new App\Libraries\Library();
?>
<?= $this->extend('Layout/Page') ?>
<?= $this->section('css_files') ?>
<style>
    .nav-link {
        padding: 20px;
        color: #6c757d;
    }

    .nav-link.active {
        background: transparent !important;
        color: black;
        font-weight: 700;

    }

    .nav-tabs .nav-link.active:after {
        width: 50%;
        left: 52%;
        transform: translate(-50%, -50%);
        height: 3px;
    }

    .list-none {
        list-style: none;
    }

    .list-style li {
        list-style: none;
    }

    tfoot tr,
    tfoot tr td {
        border: none;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <div class="card">
            <?= $this->include('Rekap/MenuFbcj') ?>

            <div class="card-body padding-y-2 padding-x-6">
                <br />
                <div class="row margin-top-5">
                    <div class="col-lg-6">

                        <div class="row margin-top-2">
                            <div class="col-lg-2 d-flex justify-content-between align-items-center">
                                <div class='fweight-700'>Nomor</div>
                                <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                            </div>
                            <div class="col-lg-4">
                                <?= $fbcj->nomor ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6"></div>

                    <div class="col-lg-6">

                        <div class="row margin-top-2">
                            <div class="col-lg-2 d-flex justify-content-between align-items-center">
                                <div class='fweight-700'>Tanggal</div>
                                <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                            </div>
                            <div class="col-lg-4">
                                <?= $fbcj->tanggal ?>
                            </div>
                        </div>

                        <div class="row  margin-top-2">
                            <div class="col-lg-2 d-flex justify-content-between  align-items-center">
                                <div class='fweight-700'>Divisi</div>
                                <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                            </div>
                            <div class="col-lg-7">
                                <?= $fbcj->nama_divisi ?> / <?= $fbcj->kode_divisi ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="row  margin-top-2">
                            <div class="col-lg-2 d-flex justify-content-between align-items-center">
                                <div class='fweight-700'>Kas Jurnal</div>
                                <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                            </div>
                            <div class="col-lg-4">
                                <?= $fbcj->kas_jurnal ?>
                            </div>
                        </div>

                        <div class="row margin-top-2">
                            <div class="col-lg-2 d-flex justify-content-between  align-items-center">
                                <div class='fweight-700'>Cost Center</div>
                                <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                            </div>
                            <div class="col-lg-7">
                                <?= $fbcj->kode_cost_center ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- PRINT -->
                <br /><br />
                <div class='margin-top-7'>
                    <table class='table table-bordered'>
                        <tr>
                            <th>No</th>
                            <th>Doc No</th>
                            <th>Bussiness Transaction</th>
                            <th>Wbs Element</th>
                            <th style="text-align:right">Amount</th>
                            <th>Recepient</th>
                        </tr>

                        <?php
                        $no = 1;
                        $totalAmount = 0;
                        foreach ($detail as $list) :
                            $totalAmount += $list->amount;
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $list->doc_no ?></td>
                                <td><?= $list->kode_bussiness_trans . ' ' . $list->nama_bussiness_trans ?></td>
                                <td><?= $list->kode_wbs_element ?></td>
                                <td style="text-align:right"><?= number_format($list->amount, 0, ',', '.') ?></td>
                                <td><?= strtoupper($list->nama_karyawan) ?></td>

                            </tr>
                        <?php endforeach; ?>
                        <tfoot>
                            <tr style='border:none'>
                                <td colspan=4 style="text-align:right" class="fweight-700">TOTAL AMOUNT</td>
                                <td class='d-flex justify-content-between padding-3'>
                                    <div class="fweight-700">Rp.</div>
                                    <div class="fweight-700"><?= number_format($totalAmount, 0, ',', '.') ?></div>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>


                <!-- PRINT -->

                <div class='margin-top-7'>
                    <div class='fweight-600 text-dark'> Berkas Rekapitulasi</div>
                    <div class='d-flex flex-wrap'>
                        <div>

                            <div class='d-flex margin-top-3  hover-pointer'>
                                <span class="material-icons-outlined text-muted" style='font-size:70px'>
                                    description
                                </span>
                                <div class='d-flex flex-column margin-left-3 margin-top-1'>
                                    <a href="<?= base_url("rekap/fbcj/preview/{$fbcj->id}") ?>" class='text-primary fweight-700' target="_blank">Rekapitulasi FBCJ</a>
                                    <span>
                                        <div class='badge badge-pill bg-danger text-sm-3'>pdf</div>
                                    </span>
                                </div>

                            </div>
                        </div>

                        <?php if ($empty_sub_detail == false) : ?>
                            <div class='margin-left-9'>

                                <div class='d-flex margin-top-3  hover-pointer'>
                                    <span class="material-icons-outlined text-muted" style='font-size:70px'>
                                        description
                                    </span>
                                    <div class='d-flex flex-column margin-left-3  margin-top-1'>
                                        <a href="<?= base_url("rekap/fbcj/sub_detail/preview/{$fbcj->id}") ?>" class='text-primary fweight-700' target="_blank">Rekapitulasi Detail FBCJ</a>
                                        <span>
                                            <div class='badge badge-pill bg-danger text-sm-3'>pdf</div>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>

                <div class='margin-top-7'>
                    <div class='fweight-600 text-dark'> Bukti Transaksi / BON</div>


                    <?php if (count($fbcj_bukti) > 0) : ?>

                        <div class='d-flex flex-wrap'>
                            <?php
                            $finfo = new finfo(FILEINFO_MIME);
                            foreach ($fbcj_bukti as $list) : ?>
                                <div class='d-flex margin-top-3 <?= $no != 1 ? 'margin-right-7' : '' ?> hover-pointer'>
                                    <span class="material-icons-outlined text-muted" style='font-size:70px'>
                                        description
                                    </span>
                                    <div class='d-flex flex-column margin-left-3'>
                                        <a href="<?= base_url("rekap/fbcj_bukti/preview/{$fbcj->id}/{$list->id}") ?>" class='text-primary fweight-700' target="_blank">Bukti 000<?= $no++ ?></a>
                                        <span>
                                            <?php
                                            $fileInfo = $finfo->buffer(base64_decode($list->bukti_file));
                                            $mimeType = explode('; ', $fileInfo)[0] ?? 'Tidak Diketahui';
                                            ?>
                                            <div class='badge badge-pill <?= $library->mimeToExt($mimeType) == 'pdf' ? 'bg-danger' : 'bg-success' ?> text-sm-3'>
                                                <?= $library->mimeToExt($mimeType); ?>
                                            </div>
                                        </span>

                                    </div>

                                </div>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

            <br /><Br /><br />
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js_files') ?>
<script src="<?= base_url('js/Pengajuan/DetailPengajuan.js') ?>"></script>
<?= $this->endSection() ?>