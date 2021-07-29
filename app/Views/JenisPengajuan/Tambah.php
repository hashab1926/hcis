<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/kartik-upload/fileinput.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col">
        <?= $this->include('JenisPengajuan/Menu') ?>
        <div class="card" style="border-top-left-radius:0;">
            <div class="card-body padding-top-5 padding-bottom-10">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-lg-10 offset-lg-1">
                            <div class="row margin-bottom-5">
                                <div class="col text-center">
                                    <h3>Tambah Jenis pengajuan</h3>
                                    <div class='text-muted'>isi kolom dibawah dengan benar dan lengkap</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-5 margin-top-5">
                                    <img src="<?= base_url('img/undraw-pengajuan.svg') ?>" width=450 class='d-block mx-auto d-xs-none d-sm-none d-md-none d-lg-block d-xl-block d-none'>

                                </div>
                                <div class="col-lg-7">
                                    <form id="jenispengajuan-store" method="POST">
                                        <div class="row">
                                            <div class="col-12 padding-bottom-3 margin-top-4">
                                                <div class="form-group padding-x-5">
                                                    <label for="first-name-column">Nama Jenis Pengajuan</label>
                                                    <input type="text" id="first-name-column" class="form-control custom-input-height" placeholder="Jenis pengajuan" name="nama_jenis">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group padding-x-5">
                                                    <label for="first-name-column">File template</label>
                                                    <div class="file-loading">
                                                        <input id="fileUpload" name="template_file" type="file" data-browse-on-zone-click="true" class="file" data-allowed-file-extensions='["html"]'>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col padding-left-8">
                                                    <button class='btn btn-primary btn-block padding-y-2 d-flex align-items-center justify-content-center' name="tambah" type="submit">
                                                        <span class="material-icons-outlined">
                                                            add
                                                        </span>
                                                        <div class='margin-left-2'>Tambahkan</div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js_files') ?>
<script src="<?= base_url('template/vendors/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/kartik-upload/piexif.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/kartik-upload/sortable.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/kartik-upload/custom_fileinput.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/kartik-upload/theme.js') ?>"></script>
<script src="<?= base_url('js/JenisPengajuan/TambahJenisPengajuan.js') ?>"></script>

<?= $this->endSection() ?>