<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col">
        <?= $this->include('UnitKerja/Divisi/Menu') ?>
        <div class="card" style="border-top-left-radius:0;">
            <div class="card-body padding-top-5 padding-bottom-10">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-7 offset-lg-2">
                            <div class="row margin-bottom-5">
                                <div class="col text-center">
                                    <h3>Tambah Divisi</h3>
                                    <div class='text-muted'>isi kolom dibawah dengan benar dan lengkap</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col ">
                                    <img src="<?= base_url('img/undraw-add.svg') ?>" width=300 class='d-block mx-auto d-xs-none d-sm-none d-md-none d-lg-block d-xl-block d-none'>

                                </div>
                            </div>
                            <form id="divisi-store" method="POST">
                                <div class="row">
                                    <div class="col-12 padding-bottom-1 margin-top-4">
                                        <div class="form-group padding-x-5">
                                            <label for="first-name-column">Kepala / Direktur </label>
                                            <select name="id_kepala" data-name="id_kepala" class="w-100" id="id_kepala"></select>
                                        </div>
                                    </div>

                                    <div class="col-12 padding-bottom-1 margin-top-2">
                                        <div class="form-group padding-x-5">
                                            <label for="first-name-column">Kode Unit </label>
                                            <input type="text" id="first-name-column" class="form-control custom-input-height" placeholder="Kode Unit" name="kode_divisi">
                                        </div>
                                    </div>

                                    <div class="col-12 padding-bottom-3 margin-top-2 padding-x-7">
                                        <label for="first-name-column">Nama Unit </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Nama Unit" name="nama_divisi">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">
                                                    <input type="text" class="form-control" placeholder="Singkatan / Alias" name="singkatan" oninput="this.value = this.value.toUpperCase()">
                                                </span>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row margin-top-3">
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

<?= $this->endSection() ?>

<?= $this->section('js_files') ?>
<script src="<?= base_url('template/vendors/select2/select2.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('js/UnitKerja//Divisi/DivisiSelect2.js') ?>"></script>
<script src="<?= base_url('js/UnitKerja/Divisi/TambahDivisi.js') ?>"></script>
<?= $this->endSection() ?>