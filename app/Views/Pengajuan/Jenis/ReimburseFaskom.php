<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('template/vendors/LightPick/lightpick.css') ?>">
<style>
    tfoot tr,
    tfoot tr td {
        border: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<input type="hidden" name='nama_jenis' value="<?= $_GET['jenis_pengajuan'] ?>">
<div class="row">
    <div class="col-lg-4">
        <div class="card box-shadow" id='data-diri-pengaju'>
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

        <div class="card box-shadow" id='jalur-divisi'>
            <div class="card-body">
                <h5 class="card-title">Jalur Divisi </h5>
                <div class='text-center'>
                    <span class="material-icons-outlined icon-xxl-title text-muted">
                        account_tree
                    </span>

                    <div class='d-flex flex-column justify-content-center align-items-center'>

                        <div class="form-group margin-top-3">
                            <label class='fweight-700 text-md-2'>KEPALA </label>
                            <div class='d-flex flex-wrap'>
                                <div class='text-md-2 fweight-700'><?= $user->kode_kepala ?></div>
                                <div class=' text-md-2 margin-x-2'>/</div>
                                <div class=' text-md-2'><?= $user->nama_kepala == null  ? "<span class='text-muted'>Belum diisi</span>"  : strtoupper($user->nama_kepala)  ?></div>

                            </div>
                        </div>


                        <div class="form-group margin-top-3 ">
                            <label class='fweight-700 text-md-2'>DIVISI</label>
                            <div class='d-flex flex-wrap'>
                                <div class='text-md-2 fweight-700'><?= $user->kode_divisi ?></div>
                                <div class=' text-md-2 margin-x-2'>/</div>
                                <div class='text-md-2 fweight-700'><?= $user->singkatan ?></div>
                                <div class=' text-md-2 margin-x-2'>/</div>

                                <div class='text-md-2'><?= $user->nama_divisi == null  ? "<span class='text-muted'>Belum diisi</span>"  : strtoupper($user->nama_divisi)  ?></div>
                            </div>
                        </div>


                        <div class="form-group margin-top-3">
                            <label class='fweight-700 text-md-2'>BAGIAN</label>
                            <div class='text-md-2'><?= $user->nama_bagian == null  ? "<span class='text-muted'>Belum diisi</span>"  : strtoupper($user->nama_bagian)  ?></div>
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

    <div class="col-lg-8" id='wrapper-pengajuan'>
        <div class="card box-shadow">
            <div class='position-absolute ' style="top:20px; left:-10px">
                <a href='#form-pengajuan' class='btn btn-primary padding-1 d-flex align-items-center' id='btn-expand'>
                    <span class="material-icons-outlined icon-secondary">
                        arrow_back_ios_new
                    </span>
                </a>
            </div>
            <div class="card-body">
                <form id='form-pengajuan'>
                    <h5 class="card-title">Form Pengajuan</h5>
                    <div class='text-center'>
                        <span class="material-icons-outlined text-muted" style='font-size:200px'>
                            assignment
                        </span>
                    </div>
                    <div class=" margin-top-4">
                        <div class="row margin-bottom-3">
                            <div class="col-lg-5 text-md-2">
                                <div class='d-flex justify-content-end margin-top-2'>
                                    <div class='fweight-600'>No.Pengajuan</div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class='margin-top-2 text-md-2 fweight-700'>
                                    <?= $nomor_pengajuan ?>
                                </div>
                            </div>

                        </div>
                        <div class="row margin-bottom-3">
                            <div class="col-lg-5 text-md-2">
                                <div class='d-flex justify-content-end margin-top-2'>
                                    <div class='fweight-600'>Tgl.Pengajuan</div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class='margin-top-2 text-md-2 fweight-700'>
                                    <?= date('d-m-y H:i:s') ?>
                                    <input type="hidden" value="<?= date('d-m-y H:i:s') ?>" name="templating[tgl_pengajuan]">
                                </div>
                            </div>

                        </div>

                        <div class="row margin-bottom-3">
                            <div class="col-lg-5 text-md-2">
                                <div class='d-flex justify-content-end margin-top-2'>
                                    <div class='fweight-600'>Bulan</div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class='margin-top-2 text-md-2 fweight-700'>
                                    <input type="month" name="templating[tahun_bulan]" id='tahun_bulan'>
                                </div>
                            </div>

                        </div>

                        <div class="row margin-bottom-3">
                            <div class="col-lg-5 text-md-2">
                                <div class='d-flex justify-content-end margin-top-2'>
                                    <div class='fweight-600'>Divisi</div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <input type="hidden" value="<?= $user->kode_divisi . ' &nbsp; &nbsp; &nbsp;' . $user->nama_divisi . ' / ' . $user->singkatan ?>" name="templating[divisi]">

                                <div class='margin-top-2 text-md-2 fweight-700 d-flex flex-wrap'>
                                    <div><?= $user->kode_divisi ?></div>
                                    <div class='margin-x-2'></div>
                                    <div><?= $user->nama_divisi ?></div>
                                    <div class='margin-x-2'>/</div>
                                    <div><?= $user->singkatan ?></div>
                                </div>
                            </div>

                        </div>



                        <div class='margin-top-5'>

                            <table class='table table-bordered'>
                                <thead>
                                    <tr class='fweight-700'>
                                        <td class='text-muted text-center'>No</td>
                                        <td class='text-muted padding-left-5'>NIP</td>
                                        <td class='text-muted padding-left-5'>NAMA</td>
                                        <td class='text-muted padding-left-5'>PANGKAT</td>
                                        <td class='text-muted padding-left-5'>PLAFON MAXIMAL</td>
                                        <td class='text-muted padding-left-5'>NILAI TOTAL</td>
                                        <td class='text-muted padding-left-5'>SELISIH PLAFON</td>
                                        <td class='text-muted padding-left-5'>HP.NOMOR</td>
                                        <td class='text-muted padding-left-5'>NILAI (Rp/)</td>

                                    </tr>
                                </thead>
                                <tbody id='tbody-rincian-biaya'>
                                    <tr>
                                        <input type="hidden" readonly name='templating[no]' value="1">
                                        <input type="hidden" readonly name='templating[nip]' value="<?= $user->nip ?>">
                                        <input type="hidden" readonly name='templating[nama_karyawan]' value="<?= $user->nama_karyawan ?>">
                                        <input type="hidden" readonly name='templating[nama_pangkat]' value="<?= $user->nama_pangkat ?>">
                                        <input type="hidden" readonly name='templating[hp_nomor]' value="<?= $user->nomor_hp ?>">

                                        <td class='padding-3 text-center'>1</td>
                                        <td class='padding-3'><?= $user->nip ?></td>
                                        <td class='padding-3'><?= strtoupper($user->nama_karyawan) ?></td>
                                        <td class='padding-3'><?= $user->nama_pangkat ?></td>
                                        <td class='padding-3'><input type='text' name='templating[plafon_maximal]' onkeyup="document.getElementById('grand_total').innerHTML = $(this).val(); document.getElementById('nilai_total').innerHTML =  $(this).val(); document.getElementById('nilai_rp').innerHTML = $(this).val()" class='form-control currency-number custom-input-height text-muted ' placeholder='Isi Nominal'></td>
                                        <td class='padding-3 text-center' id='nilai_total'></td>
                                        <td class='padding-3 text-center'>0</td>
                                        <td class='padding-3 text-center'><?= $user->nomor_hp ?></td>
                                        <td class='padding-3 text-center' id='nilai_rp'></td>

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8"></td>
                                        <td class='text-center fweight-700' id='grand_total'></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </form>
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