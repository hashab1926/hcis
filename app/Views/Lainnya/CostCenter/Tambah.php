<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col">
        <?= $this->include('Lainnya/CostCenter/Menu') ?>
        <div class="card" style="border-top-left-radius:0;">
            <div class="card-body padding-top-5 padding-bottom-10">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-7 offset-lg-2">
                            <div class="row margin-bottom-5">
                                <div class="col text-center">
                                    <h3>Tambah Cost Center</h3>
                                    <div class='text-muted'>isi kolom dibawah dengan benar dan lengkap</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col ">
                                    <img src="<?= base_url('img/undraw-option.svg') ?>" width=300 class='d-block mx-auto d-xs-none d-sm-none d-md-none d-lg-block d-xl-block d-none'>

                                </div>
                            </div>
                            <form id="costcenter-store" method="POST">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-xs-12 col-md-12 padding-bottom-3 margin-top-4">
                                        <div class="form-group padding-x-5">
                                            <label for="first-name-column">Kode Cost Center</label>
                                            <input type="text" id="first-name-column" class="form-control custom-input-height" placeholder="Kode" name="kode_cost_center">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-xs-12 col-md-12 padding-bottom-3 margin-top-4">
                                        <div class="form-group padding-x-5">
                                            <label for="first-name-column">Nama </label>
                                            <input type="text" id="first-name-column" class="form-control custom-input-height" placeholder="Nama" name="nama_cost_center">
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

<?= $this->endSection() ?>

<?= $this->section('js_files') ?>
<script src="<?= base_url('template/vendors/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('js/Lainnya/CostCenter/TambahCostCenter.js') ?>"></script>
<?= $this->endSection() ?>