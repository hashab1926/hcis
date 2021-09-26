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

        <div class="card box-shadow">
            <div class="card-body">
                <h5 class="card-title">Penandatangan</h5>
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
                            <div class="col-lg-4 text-md-2">
                                <div class='d-flex justify-content-lg-end margin-top-2'>
                                    <div class='fweight-600'>Kategori Wilayah Perjalanan Dinas</div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <select name="templating[kategori_wilayah]" data-name="id_provinsi" class="w-100" style="width: 100%"></select>
                            </div>

                        </div>
                        <div class="row margin-top-3">
                            <div class="col-lg-4 text-md-2">
                                <div class='d-flex justify-content-lg-end margin-top-2'>
                                    <div class='fweight-600'>Kota</div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <input type='text' name='templating[kota]' class='form-control custom-input-height' placeholder="Kota">
                            </div>
                        </div>

                        <div class="row margin-top-3">
                            <div class="col-lg-4 text-md-2">
                                <div class='d-flex justify-content-lg-end margin-top-2'>
                                    <div class='fweight-600'>Pekerjaan</div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <input type='text' name='templating[pekerjaan]' class='form-control custom-input-height' placeholder="Pekerjaan">
                            </div>
                        </div>

                        <div class="row margin-top-3">
                            <div class="col-lg-4 text-md-2">
                                <div class='d-flex justify-content-lg-end margin-top-2'>
                                    <div class='fweight-600'>Lama Perdin</div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <input type='text' name='templating[lama_perdin]' class='form-control custom-input-height datelightpick-lama-perdin' placeholder="Lama Perdin">
                            </div>
                        </div>

                        <div class="row margin-top-3">
                            <div class="col-lg-4 text-md-2">
                                <div class='d-flex justify-content-lg-end margin-top-2'>
                                    <div class='fweight-600'>WBS Element</div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <select name="templating[wbs_element]" data-name="id_wbs_element" class="w-100" style="width: 100%"></select>
                            </div>
                        </div>

                        <div class="row margin-top-3">
                            <div class="col-lg-4 text-md-2">
                                <div class='d-flex justify-content-lg-end margin-top-2'>
                                    <div class='fweight-600'>Cost Center</div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <select name="templating[cost_center]" data-name="id_cost_center" class="w-100" style="width: 100%"></select>
                            </div>
                        </div>

                        <div class="row margin-top-3">
                            <div class="col-lg-4 text-md-2">
                                <div class='d-flex justify-content-lg-end margin-top-2'>
                                    <div class='fweight-600'>Bussiness Trans</div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <select name="templating[bussiness_trans]" data-name="id_bussiness_trans" class="w-100" style="width: 100%"></select>
                            </div>
                        </div>

                        <div class="row margin-top-3">
                            <div class="col-lg-4 text-md-2">
                                <div class='d-flex justify-content-lg-end margin-top-2'>
                                    <div class='fweight-600'>Biaya Perjalanan dinas</div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-check form-switch margin-top-3">
                                    <input class="form-check-input" type="checkbox" id="biaya_perjalanan_dinas" checked="true" name='status_biaya_perjalanan_dinas'>
                                    <label class="form-check-label" id='label_biaya_perjalanan_dinas' for="biaya_perjalanan_dinas">Aktif</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>

        <div class="card box-shadow" id='wrapper-rincian-biaya'>
            <div class="card-body">
                <h5 class="card-title">Rincian Biaya</h5>
                <div class='text-center'>
                    <span class="material-icons-outlined text-muted" style='font-size:200px'>
                        paid
                    </span>
                </div>

                <div>
                    <form id='form-rincianbiaya'>
                        <table class='table table-borderless'>
                            <thead>
                                <tr class='fweight-700'>
                                    <td class='text-muted text-center'>No</td>
                                    <td class='text-muted padding-left-5'>Jenis Fasilitas</td>
                                    <td class='text-muted padding-right-5' style='text-align:right;'>Nilai Pengajuan</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody id='tbody-rincian-biaya'>
                                <tr class='box-shadow'>
                                    <td class='padding-3 text-center'>1</td>
                                    <td class='padding-3'><select name="templating[jenis_fasilitas][]" data-name="jenis_fasilitas" class="w-100" style="width: 100%"></select></td>
                                    <td class='padding-3'><input type='text' dir="rtl" name='templating[nilai_pengajuan][]' class='form-control currency-number currency-number nilai_pengajuan no-border' placeholder='Nominal'></td>
                                    <td class='padding-3 text-center'>
                                        <button class='no-border no-background text-muted padding-x-1 hapus-rincian d-flex align-items-center justify-content-center padding-top-1 w-100'>
                                            <span class='material-icons-outlined'>
                                                highlight_off
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class='text-center fweight-700 text-md-2' colspan=2>TOTAL NILAI</td>
                                    <td class='text-center fweight-700'>
                                        <div class=' d-flex justify-content-between'>
                                            <div>Rp.</div>
                                            <div id='total-nilai-pengajuan'>0</div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>

                    <div class='margin-top-2'>
                        <button class='btn btn-primary padding-y-2 fweight-700 btn-block d-flex align-items-center justify-content-center' id='templating-tambah-rincian'>
                            <span class='material-icons-outlined'>
                                add
                            </span>
                            <div class='margin-left-2'>Tambah Baris Rincian</div>
                        </button>
                    </div>
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