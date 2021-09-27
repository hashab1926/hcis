<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('template/vendors/LightPick/lightpick.css') ?>">
<style>
    table {
        border-spacing: 0 0.8em;
        border-collapse: separate;
    }

    table tr {
        border: none !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<input type="hidden" name='nama_jenis' value="<?= $_GET['jenis_pengajuan'] ?>">
<div class="row">
    <div class="col-lg-4">
        <div class="card box-shadow">
            <div class="card-body">
                <h5 class="card-title">Data diri Pengaju</h5>
                <div class='text-center'>
                    <span class="material-icons-outlined icon-xxl-title text-muted">
                        account_circle
                    </span>
                </div>

                <div class='row margin-top-3'>
                    <div class='col'>
                        <div class="form-group">
                            <label class='fweight-700'>NIP</label>
                            <div><?= $user->nip ?></div>
                        </div>
                    </div>
                    <div class='col'>

                        <div class="form-group margin-left-3">
                            <label class='fweight-700'>NAMA KARYAWAN</label>
                            <div><?= strtoupper($user->nama_karyawan) ?></div>
                        </div>
                    </div>

                </div>
                <div class='row margin-top-3'>
                    <div class='col'>
                        <div class="form-group">
                            <label class='fweight-700'>PANGKAT</label>
                            <div><?= $user->nama_pangkat ?></div>
                        </div>
                    </div>
                    <div class='col'>

                        <div class="form-group margin-left-3">
                            <label class='fweight-700'>JABATAN</label>
                            <div><?= $user->nama_jabatan ?></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card box-shadow">
            <div class="card-body">
                <h5 class="card-title">Jalur Divisi </h5>
                <div class='text-center'>
                    <span class="material-icons-outlined icon-xxl-title text-muted">
                        account_tree
                    </span>

                    <div class='d-flex flex-column justify-content-center align-items-center'>

                        <div class="form-group margin-top-3">
                            <label class='fweight-700 text-md-2'>KEPALA </label>
                            <div class=' text-md-2'><?= $user->nama_kepala ?></div>
                        </div>


                        <div class="form-group margin-top-3 ">
                            <label class='fweight-700 text-md-2'>DIVISI</label>
                            <div class='text-md-2'><?= strtoupper($user->nama_divisi) ?></div>
                        </div>


                        <div class="form-group margin-top-3">
                            <label class='fweight-700 text-md-2'>BAGIAN</label>
                            <div class='text-md-2'><?= strtoupper($user->nama_bagian) ?></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>

    <div class="col-lg-8">
        <div class="card box-shadow">
            <div class="card-body">
                <form id='form-pengajuan'>
                    <h5 class="card-title">Form Pengajuan <?= $nama_pengajuan ?> </h5>
                    <div class='text-center'>
                        <span class="material-icons-outlined text-muted" style='font-size:200px'>
                            assignment
                        </span>
                    </div>
                    <div class="container margin-top-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Tanggal Lembur</label>
                                    <input type='text' name='templating[tgl_lembur]' class='form-control' id='tgllembur' placeholder="Tanggal Lembur">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Lama Lembur</label>
                                    <div class='d-flex align-items-center'>
                                        <input type='number' name='templating[lama_lembur]' class='form-control w-50' placeholder="Lama Lembur">
                                        <div class='text-muted margin-left-2'>Jam</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea name='templating[keterangan]' class='form-control' placeholder="Keterangan"></textarea>
                                </div>
                            </div>

                        </div>


                    </div>
                </form>
            </div>

        </div>

        <div class="card box-shadow">
            <div class="card-body">
                <h5 class="card-title">Penandatangan / Pengawas</h5>
                <div class='text-center'>
                    <span class="material-icons-outlined icon-xxl-title text-muted">
                        drive_file_rename_outline
                    </span>
                </div>

                <div class="form-group">
                    <label class='fweight-700 margin-bottom-1'>Nama penandatangan</label>
                    <select id="penandatangan" name='templating[nama_penandatangan]' class='form-select'>
                        <option value="">- Pilih Penandatangan -</option>
                    </select>
                </div>

            </div>
        </div>

    </div>
</div>
</div>
<div class='position-fixed' style="bottom:50px; right:35px">
    <button class='btn btn-success d-flex align-items-center rounded-pill box-shadow btn-lg padding-x-3 padding-y-2' name='simpan'>
        <span class="material-icons-outlined icon-title">
            check_circle
        </span>
        <div class='fweight-700 text-md-4 margin-left-2'>Simpan</div>
        <div></div>
    </button>
</div>
<?= $this->endSection() ?>

<?= $this->section('js_files') ?>
<script src="<?= base_url('template/vendors/select2/select2.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/LightPick/moment.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/LightPick/lightpick.js') ?>"></script>
<script src="<?= base_url('template/vendors/JqueryMask/jquery.mask.min.js') ?>"></script>

<script src="<?= base_url('js/Pengajuan/PengajuanSelect2.js') ?>"></script>
<script src="<?= base_url('js/Pengajuan/TambahPengajuan.js') ?>"></script>

<?= $this->endSection() ?>