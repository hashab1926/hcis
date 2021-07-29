<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$library = new \App\Libraries\Library;
?>
<div class="row">
    <div class="col">
        <?= $this->include('Karyawan/Menu') ?>
        <div class="" style="border-top-left-radius:0;">
            <div class="card-body padding-x-1 pt-0">

                <div class="row">
                    <?php
                    $col = count($data) >= 3 ? 'col-lg-4' : 'col-lg-6';
                    foreach ($data as $list) :
                    ?>
                        <div class="<?= $col ?>">
                            <div class="card box-shadow">

                                <?php if ($list->id_user != null) : ?>
                                    <div class='position-absolute' style='top:15px; right:15px'>
                                        <div class='d-flex align-items-center'>
                                            <span class="material-icons-outlined text-success">
                                                verified
                                            </span>
                                            <div class='margin-left-2 text-success'>Akun Tersedia</div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="card-body">
                                    <div class='d-flex flex-column '>
                                        <!-- ICON -->
                                        <div class='text-center'>
                                            <span class="material-icons-outlined text-muted" style="font-size:150px">
                                                perm_identity
                                            </span>
                                        </div>
                                        <!-- ICON -->

                                        <div class='row'>
                                            <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                <label class='fweight-700'>NIP</label>
                                                <div class="text-muted"><?= $list->nip ?></div>
                                            </div>
                                            <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                <label class='fweight-700'>Nama Karyawan</label>
                                                <div class="text-muted"><?= $list->nama_karyawan ?></div>
                                            </div>
                                        </div>
                                        <div class='row margin-top-2'>

                                            <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                <label class='fweight-700'>Pangkat</label>
                                                <div class="text-muted"><?= $list->nama_pangkat ?></div>
                                            </div>
                                            <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                <label class='fweight-700'>Jabatan</label>
                                                <div class="text-muted"><?= $list->nama_jabatan ?></div>
                                            </div>
                                        </div>

                                        <div class='row margin-top-2'>

                                            <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                <label class='fweight-700'>Kepala</label>
                                                <div class="text-muted"><?= $list->nama_kepala ?></div>
                                            </div>
                                            <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                <label class='fweight-700'>Divisi</label>
                                                <div class="text-muted"><?= $list->nama_divisi ?></div>
                                            </div>
                                        </div>
                                        <div class='row margin-top-2'>

                                            <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                <label class='fweight-700'>Bagian</label>
                                                <div class="text-muted"><?= $list->nama_bagian ?></div>
                                            </div>
                                            <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                <label class='fweight-700'>Email</label>
                                                <div class="text-muted"><?= $list->email ?></div>
                                            </div>
                                        </div>
                                        <div class='row margin-top-2'>

                                            <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                <label class='fweight-700'>Nomor HP</label>
                                                <div class="text-muted"><?= $list->nomor_hp ?></div>
                                            </div>
                                            <?php if ($list->id_user != null) : ?>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Username</label>
                                                    <div class="text-muted"><?= $list->username ?></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class='row margin-top-2'>
                                            <?php if ($list->id_user != null) : ?>
                                                <div class='col margin-top-2'>
                                                    <label class='fweight-700'>Level</label>
                                                    <div class="text-muted"><?= $library->levelUser($list->level) ?></div>
                                                </div>

                                            <?php endif; ?>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>