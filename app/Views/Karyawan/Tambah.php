<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col">
        <?= $this->include('Karyawan/Menu') ?>
        <div class="card" style="border-top-left-radius:0;">
            <div class="card-body  padding-top-5 padding-bottom-10">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-7  offset-lg-2 ">
                            <div class="row margin-bottom-5">
                                <div class="col text-center">
                                    <h3>Tambah Karyawan</h3>
                                    <div class='text-muted'>isi kolom dibawah dengan benar dan lengkap</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col ">
                                    <img src="<?= base_url('img/undraw-karyawan.svg') ?>" width=300 class='d-block mx-auto d-xs-none d-sm-none d-md-none d-lg-block d-xl-block d-none'>

                                    <div class='text-center d-flex align-items-center flex-column margin-top-5'>
                                        <i class='text-muted'>hanya mendukung format file <code>.jpg</code> <code>.jpeg</code> <code>.png</code></i>
                                        <label class='btn btn-primary margin-top-2'>
                                            <input type="file" class='d-none fileupload' id="btn-upload">
                                            <div class='d-flex align-items-center'>
                                                <span class=" material-icons-outlined">
                                                    file_upload
                                                </span>
                                                <div class='margin-left-1 fweight-600'>Upload</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <form id="karyawan-store" method="POST">
                                <div class="row margin-top-10">

                                    <div class="col-md-6 col-12 padding-bottom-3">
                                        <div class="form-group padding-x-5">
                                            <label for="first-name-column">NIP</label>
                                            <input type="text" id="first-name-column" class="form-control custom-input-height" placeholder="Nomor Induk Pegawai" name="nip" id="nip">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 padding-bottom-3">
                                        <div class="form-group padding-x-5">
                                            <label for="last-name-column">Nama Lengkap</label>
                                            <input type="text" id="nama_karyawan" oninput="this.value = this.value.toUpperCase()" class=" form-control custom-input-height" placeholder="Nama lengkap" name="nama_karyawan">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 padding-bottom-3">
                                        <div class="form-group padding-x-5 d-flex flex-column">
                                            <label for="last-name-column">Pangkat</label>
                                            <select name="id_pangkat" data-name="id_pangkat" class="w-100" id="id_pangkat"></select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 padding-bottom-3">
                                        <div class="form-group padding-x-5 d-flex flex-column">
                                            <label for="last-name-column">Jabatan</label>
                                            <select name="id_jabatan" data-name="id_jabatan" class="w-100" id="id_jabatan"></select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 padding-bottom-3">
                                        <div class="form-group padding-x-5 d-flex flex-column">
                                            <label for="last-name-column">Kepala</label>
                                            <select name="id_kepala" data-name="id_kepala" class="w-100" id="id_kepala"></select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 padding-bottom-3">
                                        <div class="form-group padding-x-5 d-flex flex-column">
                                            <label for="last-name-column">Divisi</label>
                                            <select name="id_divisi" data-name="id_divisi" class="w-100" id="id_divisi"></select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 padding-bottom-3">
                                        <div class="form-group padding-x-5 d-flex flex-column">
                                            <label for="last-name-column">Bagian</label>
                                            <select name="id_bagian" data-name="id_bagian" class="w-100" id="id_bagian"></select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 padding-bottom-3">
                                        <div class="form-group padding-x-5">
                                            <label for="last-name-column">E-mail aktif</label>
                                            <input type="text" id="email" class="form-control custom-input-height" placeholder="Email" name="email">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col padding-left-8">
                                            <button class='btn btn-primary btn-block padding-y-2 d-flex align-items-center justify-content-center' type="submit" name="tambah">
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
<script src="<?= base_url('js/Karyawan/TambahKaryawan.js') ?>"></script>
<script src="<?= base_url('js/Karyawan/KaryawanSelect2.js') ?>"></script>
<?= $this->endSection() ?>