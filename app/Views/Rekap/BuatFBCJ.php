<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('template/vendors/kartik-upload/fileinput.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('template/vendors/LightPick/lightpick.css') ?>">

<style>
    table {
        border-spacing: 0 1em;
        border-collapse: separate;
    }

    table tr {
        border: none !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <div class="card padding-y-3">
            <div class="card-body">
                <div class="row">
                    <div class="col text-center">
                        <h3>Rekapitulasi FBCJ</h3>
                    </div>
                </div>

                <form id='form-title-fbcj'>
                    <div class="row margin-top-5">
                        <div class="col-lg-6">

                            <div class="row margin-top-2">
                                <div class="col-lg-2 d-flex justify-content-between align-items-center">
                                    <div class='fweight-700'>Tanggal</div>
                                    <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" name='tanggal' placeholder="Tanggal" id="tanggal" class="form-control custom-input-height">
                                </div>
                            </div>

                            <div class="row  margin-top-2">
                                <div class="col-lg-2 d-flex justify-content-between  align-items-center">
                                    <div class='fweight-700'>Divisi</div>
                                    <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                                </div>
                                <div class="col-lg-7">
                                    <select name="id_unit_kerja_divisi" data-name="id_unit_kerja_divisi" class="w-100" id="id_unit_kerja_divisi"></select>
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
                                    <select name="kas_jurnal" data-name="id_direktorat" class="w-100" id="id_direktorat"></select>
                                </div>

                            </div>

                            <div class="row margin-top-2">
                                <div class="col-lg-2 d-flex justify-content-between  align-items-center">
                                    <div class='fweight-700'>Cost Center</div>
                                    <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                                </div>
                                <div class="col-lg-7">
                                    <select name="id_cost_center" data-name="id_cost_center" class="w-100" id="id_cost_center"></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row  margin-top-2">
                                <div class="col-lg-2 col-12 d-flex justify-content-between align-items-center">
                                    <div class='fweight-700'>Penandatangan</div>
                                    <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                                </div>
                                <div class="col-lg-7">
                                    <select data-name="penandatangan" name='penandatangan' class='form-select'>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group padding-x-5 margin-top-7">
                                <label for="first-name-column">Upload Bukti Transaksi/Bon <sup>Opsional</sup></label>
                                <div class="file-loading">
                                    <input id="fileUpload" name="bukti_file[]" type="file" data-browse-on-zone-click="true" class="file" multiple>
                                </div>
                                <i class='text-muted'>Upload bukti transaksi jika diperlukan</i>
                            </div>
                        </div>
                    </div>
                </form>

                <br />

                <div class='margin-top-10'>
                    <form id='form-fbcj'>
                        <div class="table-responsive">
                            <table class='table table-borderless'>
                                <thead>
                                    <tr>
                                        <th>Bussiness Transaction</th>
                                        <th>Wbs Element</th>
                                        <th class='padding-right-4' style='text-align:right'>Amount</th>
                                        <th>Recipient</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id='tbody-isi'>
                                    <tr class='box-shadow'>
                                        <td class='padding-3'> <select name="rincian[id_bussiness_trans][]" data-name="id_bussiness_trans" class="w-100" style="width: 100%"></select></td>
                                        <td class='padding-3'><select name="rincian[id_wbs_element][]" data-name="id_wbs_element" class="w-100" style="width: 100%"></select></td>
                                        <td class='padding-3'><input type='text' dir="rtl" name='rincian[amount][]' class='form-control currency-number currency-number amount' placeholder='Amount'></td>
                                        <td class='padding-3'><select name="rincian[id_karyawan][]" data-name="id_karyawan" class="w-100" style="width: 100%"></select></td>

                                        <td class='padding-3 text-center'>
                                            <button class='no-border no-background text-muted padding-x-1 hapus-baris d-flex align-items-center justify-content-center padding-top-1 w-100'>
                                                <span class='material-icons-outlined'>
                                                    highlight_off
                                                </span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="text-align:right" class=' fweight-700 text-md-2' colspan=2>TOTAL AMOUNT</td>
                                        <td class='text-center fweight-700 padding-right-6'>
                                            <div class=' d-flex justify-content-between'>
                                                <div>Rp.</div>
                                                <div id='total-amount'>0</div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>

                    <div class='margin-top-2'>
                        <button class='btn btn-primary padding-y-2 fweight-700 btn-block d-flex align-items-center justify-content-center' id='templating-tambah-baris'>
                            <span class='material-icons-outlined'>
                                add
                            </span>
                            <div class='margin-left-2'>Tambah Baris Rincian</div>
                        </button>
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
    </div>
</div>


<?= $this->endSection(); ?>
<?= $this->section('js_files') ?>
<script src="<?= base_url('template/vendors/select2/select2.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/JqueryMask/jquery.mask.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/LightPick/moment.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/LightPick/lightpick.js') ?>"></script>

<script src="<?= base_url('js/UnitKerja/Bagian/BagianSelect2.js') ?>"></script>

<script src="<?= base_url('template/vendors/kartik-upload/piexif.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/kartik-upload/sortable.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/kartik-upload/custom_fileinput.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/kartik-upload/theme.js') ?>"></script>

<script src="<?= base_url('js/Rekap/FBCJSelect2.js') ?>"></script>
<script src="<?= base_url('js/Rekap/BuatFBCJ.js') ?>"></script>
<?= $this->endSection(); ?>