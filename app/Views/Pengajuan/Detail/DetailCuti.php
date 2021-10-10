<?php
$library = new App\Libraries\Library();

$status = "";
if ($pengajuan->status == 'PROSES') :
    $status = "
        <span class='material-icons-outlined'>
            loop
        </span>
        <div>Sedang diproses</div>
        ";
elseif ($pengajuan->status == 'ACC') :
    $status = "
            <span class='material-icons text-success'>
                check_circle
            </span>
            <div class='margin-left-2 fweight-600 text-success'>ACC</div>
            ";

endif;
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
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <div class="card">
            <?= $this->include('Pengajuan/Menu') ?>

            <div class="card-body padding-y-2 padding-x-6">
                <br />
                <div class='d-flex justify-content-between align-items-center'>
                    <div class='d-flex'>
                        <span class="material-icons-outlined icon-lg-title text-muted">
                            account_circle
                        </span>
                        <div class='d-flex flex-column margin-left-2'>
                            <div class=' fweight-600 text-primary'><?= $pengaju->nama_karyawan ?></div>
                            <div class='text-muted text-sm-4'><?= $pengaju->email ?></div>
                            <div class='text-sm-4'>
                                <ul class='list-none p-0'>
                                    <li class='d-flex align-items-center text-primary fweight-600 hover-pointer' id='posisi'><?= $library->ucFirst($pengaju->nama_bagian ?? $pengaju->nama_divisi ?? $pengaju->nama_kepala) ?>
                                        <span class="material-icons-outlined" id='status_caret'>
                                            arrow_drop_down
                                        </span>
                                    </li>
                                    <ul class='list-none issub d-none'>
                                        <?php if (!empty($pengaju->nama_kepala)) : ?>
                                            <li class='d-flex align-items-center'>
                                                <span class="material-icons-outlined">
                                                    subdirectory_arrow_right
                                                </span>
                                                <?= $library->ucFirst($pengaju->nama_kepala) ?>
                                            </li>
                                        <?php endif; ?>
                                        <ul class='list-none '>
                                            <li class='d-flex align-items-center'>
                                                <span class="material-icons-outlined">
                                                    subdirectory_arrow_right
                                                </span>
                                                <?= $library->ucFirst($pengaju->nama_divisi) ?>
                                            </li>
                                            <ul class='list-none'>
                                                <li class='d-flex align-items-center'>
                                                    <span class="material-icons-outlined">
                                                        subdirectory_arrow_right
                                                    </span>
                                                    <?= $library->ucFirst($pengaju->nama_bagian) ?>
                                                </li>
                                            </ul>
                                        </ul>
                                    </ul>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class='d-flex flex-column align-items-end'>
                        <div class='fweight-600 text-primary'><?= $nama_jenis ?></div>
                        <div class='text-muted'>Nomor <?= $pengajuan->nomor ?></div>
                        <div class='text-muted text-right'>
                            <?= $library->timeToText($pengajuan->created_at) ?>
                        </div>
                    </div>
                </div>

                <Br />
                <div class='margin-top-4'>
                    <div class='row'>
                        <div class="col">
                            <div class='d-flex margin-top-3 justify-content-center flex-wrap'>
                                <div class='d-flex flex-column'>
                                    <div class='d-flex'>
                                        <div class='padding-x-2 padding-y-1 bg-primary box-shadow no-border' style="border-radius:5px">
                                            <span class="material-icons-outlined icon-title text-white">
                                                person_outline
                                            </span>
                                        </div>

                                        <div class='d-flex flex-column margin-left-3'>
                                            <div class='fweight-700'><?= $penandatangan->nama_karyawan ?></div>
                                            <small class='text-muted'><?= $library->ucFirst($penandatangan->nama_divisi) ?></small>

                                        </div>
                                    </div>

                                    <div class='justify-content-center d-flex margin-top-3'><?= $status ?></div>

                                    <?php if ($user->id == $penandatangan->id_user && $pengajuan->status == 'PROSES') : ?>

                                        <div class='d-flex margin-top-5'>
                                            <button class='btn btn-danger d-flex align-items-center rounded-pill padding-x-4 box-shadow' data-toggle="modal" data-target="#modalRevisi" id='batalButton' name='btnbatal' data-id="<?= $pengajuan->id ?>">
                                                <span class="material-icons-outlined">
                                                    highlight_off
                                                </span>
                                                <div class='margin-left-2'>Tolak</div>
                                            </button>
                                            <button class='btn btn-success d-flex align-items-center margin-left-3 rounded-pill padding-x-4 box-shadow' id='accButton' name='btnacc' data-id="<?= $pengajuan->id ?>">
                                                <span class="material-icons-outlined">
                                                    check_circle
                                                </span>
                                                <div class='margin-left-2'>ACC</div>
                                            </button>

                                        </div>

                                    <?php endif; ?>
                                </div>
                                <div class='margin-x-8'>&nbsp;</div>
                            </div>
                        </div>
                    </div>

                    <?php
                    // kalo pengajuan telah selesai semua
                    if ($pengajuan->status == 'SELESAI') : ?>
                        <div class=' margin-top-5'>
                            <div class='d-flex align-items-center justify-content-center'>
                                <span class='material-icons text-success'>
                                    check_circle
                                </span>
                                <div class='margin-left-2 fweight-600 text-success'>Telah Selesai</div>
                            </div>
                        </div>
                    <?php elseif ($pengajuan->status == 'TOLAK') : ?>

                        <div class=' margin-top-2 d-flex justify-content-center flex-column'>
                            <div class="text-center margin-bottom-3">
                                <div class="d-flex flex-column">
                                    <div class="fweight-600">Keterangan revisi</div>
                                    <i><?= $pengajuan->ket_revisi ?? '' ?></i>
                                </div>
                            </div>
                            <div class='d-flex align-items-center justify-content-center'>
                                <span class='material-icons text-danger'>
                                    close
                                </span>
                                <div class='margin-left-2 fweight-600 text-danger'>Ditolak</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- PRINT -->
                <?php if (($user->id == $pengaju->id_user && ($pengajuan->status == 'ACC' || $pengajuan->status == 'SELESAI')) || $user->id == $penandatangan->id_user || $user->level == 'DIR') : ?>

                    <br /><br />
                    <div class='margin-top-7'>
                        <div class='d-flex flex-wrap'>
                            <div>
                                <div class='fweight-600 text-dark'> Berkas Pengajuan</div>

                                <div class='d-flex margin-top-3  hover-pointer'>
                                    <span class="material-icons-outlined text-muted" style='font-size:70px'>
                                        description
                                    </span>
                                    <div class='d-flex flex-column margin-left-3'>
                                        <a href="<?= base_url("pengajuan/preview/{$pengajuan->id}") ?>" class='text-primary fweight-700' target="_blank"><?= $nama_jenis ?></a>
                                        <span>
                                            <div class='badge badge-pill bg-danger text-sm-3'>pdf</div>
                                        </span>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                <?php endif; ?>


                <!-- PRINT -->

                <br /><Br /><br />
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalRevisi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Revisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group margin-top-3">
                            <label for="">Keterangan Revisi</label>
                            <textarea class="form-control" name="ket_revisi"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer no-border">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="save-tolakpengajuan">Tolak Pengajuan</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js_files') ?>
<script src="<?= base_url('js/Pengajuan/DetailPengajuan.js') ?>"></script>
<?= $this->endSection() ?>