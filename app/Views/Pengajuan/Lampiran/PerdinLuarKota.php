<?php
// printr($template);

$templateLampiran = null;
if ($pengajuan->data_template_lampiran != null)
    $templateLampiran = json_decode($pengajuan->data_template_lampiran);
// printr($templateLampiran);
?>
<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('template/vendors/LightPick/lightpick.css') ?>">
<link rel="stylesheet" href="<?= base_url('template/vendors/kartik-upload/fileinput.min.css') ?>">
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
<div class="row">
    <div class="col">
        <?php if (isset($pengajuan)) : ?>
            <div class="card">
                <?= $this->include('Pengajuan/Menu') ?>

                <div class="card-body padding-top-7">
                    <form id="form-templating">
                        <div class="row">
                            <div class="col-lg-5">
                                <h4 class="text-center">Pengajuan</h4>
                                <div class="margin-top-8">
                                    <div class="row padding-y-1">
                                        <div class="col-lg-4 text-md-1">
                                            <div class='d-flex justify-content-end '>
                                                <div class='fweight-700 text-right'>No.Perdin</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <?= $pengajuan->nomor ?>
                                        </div>

                                    </div>

                                    <div class="row padding-y-1  margin-top-3">
                                        <div class="col-lg-4 text-md-1">
                                            <div class='d-flex justify-content-end '>
                                                <div class='fweight-700 text-right'>Wilayah Perjalanan Dinas</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <?= $template->kategori_wilayah ?>
                                        </div>

                                    </div>
                                    <div class="row padding-y-1 margin-top-3">
                                        <div class="col-lg-4 text-md-1">
                                            <div class='d-flex justify-content-end '>
                                                <div class='fweight-700'>Kota</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <?= $template->kota ?>
                                        </div>
                                    </div>

                                    <div class="row padding-y-1 margin-top-3">
                                        <div class="col-lg-4 text-md-1">
                                            <div class='d-flex justify-content-end '>
                                                <div class='fweight-700'>Pekerjaan</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <?= $template->pekerjaan ?>
                                        </div>
                                    </div>

                                    <div class="row padding-y-1 margin-top-3">
                                        <div class="col-lg-4 text-md-1">
                                            <div class='d-flex justify-content-end fweight-700 '>
                                                Lama Perdin
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <?= $template->lama_perdin ?>
                                        </div>
                                    </div>

                                    <div class="row padding-y-1 margin-top-3">
                                        <div class="col-lg-4 text-md-1">
                                            <div class='d-flex justify-content-end margin-top-2 fweight-700'>
                                                Lama Perdin Realisasi
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type='text' name='templating[lama_perdin_realisasi]' value="<?= $template->lama_perdin_realisasi ?? '' ?>" id='lama_perdin_realisasi' class='form-control custom-input-height datelightpick-lama-perdin' placeholder="Lama Perdin Realisasi">
                                        </div>
                                    </div>
                                    <div class="row padding-y-1 margin-top-3">
                                        <div class="col-lg-4 text-md-1">
                                            <div class='d-flex justify-content-end '>
                                                <div class='fweight-700'>WBS Element</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <?= $template->wbs_element ?>
                                        </div>
                                    </div>

                                    <div class="row padding-y-1 margin-top-3">
                                        <div class="col-lg-4 text-md-1">
                                            <div class='d-flex justify-content-end'>
                                                <div class='fweight-700'>Cost Center</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <?= $template->cost_center ?>
                                        </div>
                                    </div>

                                    <div class="row padding-y-1 margin-top-3">
                                        <div class="col-lg-4 text-md-1">
                                            <div class='d-flex justify-content-end'>
                                                <div class='fweight-700'>Bussiness Trans</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <?= $template->bussiness_trans ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-7 padding-x-4">

                                <h4 class="text-center">Rincian Biaya</h4>
                                <div class='text-center'>
                                    <span class="material-icons-outlined text-muted" style='font-size:200px'>
                                        paid
                                    </span>
                                </div>

                                <div>

                                    <table class='table table-borderless'>
                                        <thead>
                                            <tr class='fweight-700'>
                                                <td class='text-muted text-center'>No</td>
                                                <td class='text-muted padding-left-5'>Jenis Fasilitas</td>
                                                <td class='text-muted padding-right-5' style='text-align:right;'>Nilai Pengajuan</td>
                                                <td class='text-muted padding-right-5' style='text-align:right;'>Nilai Realisasi</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id='tbody-rincian-biaya'>
                                            <form id='form-rincianbiaya'>
                                                <?php
                                                // kalo fasilitasnya ada
                                                if (isset($template->jenis_fasilitas) && count($template->jenis_fasilitas) > 0) :
                                                    $totalPengajuan = 0;
                                                    $totalRealisasi = 0;

                                                    $jenisFasilitas = $template->jenis_fasilitas;
                                                    $nilaiPengajuan = $template->nilai_pengajuan;
                                                    $nilaiRealisasi = $template->nilai_realisasi ?? 0;

                                                    $no = 0;
                                                    foreach ($jenisFasilitas as $list) :
                                                        $totalPengajuan += str_replace('.', '', $nilaiPengajuan[$no]);
                                                        $totalRealisasi += str_replace('.', '', $nilaiRealisasi[$no] ?? 0);

                                                ?>
                                                        <tr class='box-shadow'>
                                                            <td class='padding-3 text-center'><?= ($no) + 1 ?></td>
                                                            <td class='padding-3'><input type='text' name='templating[jenis_fasilitas][]' class='form-control no-border text-muted ' value="<?= $list ?>" placeholder='Nama Rincian'></td>
                                                            <td class='padding-3'><input type='text' dir="rtl" name='templating[nilai_pengajuan][]' class='form-control currency-number currency-number nilai_pengajuan no-border' value="<?= $nilaiPengajuan[$no] ?>" placeholder='Nominal'></td>
                                                            <td class='padding-3'><input type='text' dir="rtl" name='templating[nilai_realisasi][]' class='form-control currency-number currency-number nilai_realisasi no-border' value="<?= $nilaiRealisasi[$no] ?? '' ?>" placeholder='Nominal'></td>
                                                            <td class='padding-3 text-center'>
                                                                <button class='no-border no-background text-muted padding-x-1 hapus-rincian d-flex align-items-center justify-content-center padding-top-1 w-100'>
                                                                    <span class='material-icons-outlined'>
                                                                        highlight_off
                                                                    </span>
                                                                </button>
                                                            </td>
                                                        </tr>

                                                <?php $no++;
                                                    endforeach;
                                                endif;
                                                $totalPengajuan = number_format($totalPengajuan, 0, ',', '.');
                                                $totalRealisasi = number_format($totalRealisasi, 0, ',', '.');
                                                ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class='text-center fweight-700 text-md-2' colspan=2>TOTAL NILAI</td>
                                                <td class='text-center fweight-700'>
                                                    <div class=' d-flex justify-content-between'>
                                                        <div>Rp.</div>
                                                        <div id='total-nilai-pengajuan'><?= $totalPengajuan ?></div>
                                                    </div>
                                                </td>
                                                <td class='text-center fweight-700'>
                                                    <div class=' d-flex justify-content-between'>
                                                        <div>Rp.</div>
                                                        <div id='total-nilai-realisasi'><?= $totalRealisasi ?></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>


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
                    </form>

                </div>
                <!-- <div class="col-lg-6">
         <iframe src="?= base_url('pengajuan/preview/' . $pengajuan->id) ?>#toolbar=0" class='size-a4' frameborder="0"></iframe> 
        </div>-->

            </div>

            <div class="card">
                <div class="card-body padding-top-7">
                    <form id='form-templating-lampiran'>
                        <div class="row">
                            <div class="col-lg-6 ">
                                <h4 class="text-center">Form Lampiran Keputusan Direksi</h4>

                                <div class="row padding-y-2">
                                    <div class="col-lg-5 text-md-1">
                                        <div class='d-flex justify-content-end '>
                                            <div class='fweight-700 text-right'>No</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" name='templating_lampiran[no]' value="<?= $templateLampiran->no ?? '' ?>" class='form-control' placeholder=" Nomor Lampiran">
                                    </div>
                                </div>

                                <div class="row padding-y-2">
                                    <div class="col-lg-5 text-md-1">
                                        <div class='d-flex justify-content-end '>
                                            <div class='fweight-700 text-right'>Edisi</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="number" name='templating_lampiran[edisi]' value="<?= $templateLampiran->edisi ?? '' ?>" class='form-control' placeholder="Edisi Lampiran">
                                    </div>
                                </div>

                                <div class="row padding-y-2">
                                    <div class="col-lg-5 text-md-1">
                                        <div class='d-flex justify-content-end '>
                                            <div class='fweight-700 text-right'>No.Perdin</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="hidden" name='templating_lampiran[nama_penandatangan]' value="<?= $template->nama_penandatangan ?>">

                                        <input type="hidden" name='templating_lampiran[no_perdin]' value="<?= $pengajuan->nomor ?>">
                                        <?= $pengajuan->nomor ?>
                                    </div>
                                </div>

                                <div class="row padding-y-2">
                                    <div class="col-lg-5 text-md-1">
                                        <div class='d-flex justify-content-end '>
                                            <div class='fweight-700 text-right'>Nama</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="hidden" name='templating_lampiran[nama_karyawan]' value="<?= $pengaju->nama_karyawan ?>">
                                        <?= $pengaju->nama_karyawan ?>
                                    </div>
                                </div>


                                <div class="row padding-y-2">
                                    <div class="col-lg-5 text-md-1">
                                        <div class='d-flex justify-content-end '>
                                            <div class='fweight-700 text-right'>Divisi</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="hidden" name='templating_lampiran[nama_divisi]' value="<?= $pengaju->nama_divisi ?>">
                                        <?= $pengaju->nama_divisi ?>
                                    </div>
                                </div>

                                <div class="row padding-y-2">
                                    <div class="col-lg-5 text-md-1">
                                        <div class='d-flex justify-content-end '>
                                            <div class='fweight-700 text-right'>Kota Tujuan</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="hidden" name='templating_lampiran[kota]' value="<?= $template->kota ?>">
                                        <?= $template->kota ?>
                                    </div>
                                </div>

                                <div class="row padding-y-2">
                                    <div class="col-lg-5 text-md-1">
                                        <div class='d-flex justify-content-end '>
                                            <div class='fweight-700 text-right'>Tanggal</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="hidden" id='lampiran_lama_perdin_realisasi' name='templating_lampiran[lama_perdin_realisasi]'>
                                        <div id='text_lampiran_lama_perdin_realisasi'>Belum diisi</div>

                                    </div>
                                </div>

                                <div class="row padding-y-2">
                                    <div class="col-lg-5 text-md-1">
                                        <div class='d-flex justify-content-end '>
                                            <div class='fweight-700 text-right'>Tujuan</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="hidden" name='templating_lampiran[tujuan]' value="<?= $template->pekerjaan ?>">
                                        <?= $template->pekerjaan ?>
                                    </div>
                                </div>

                                <div class="row padding-y-2">
                                    <div class="col-lg-5 text-md-1">
                                        <div class='d-flex justify-content-end '>
                                            <div class='fweight-700 text-right'>Biaya</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name='templating_lampiran[biaya]' value="" id='biaya_input'>
                                    <div class="col-lg-7" id='biaya'>
                                        0
                                    </div>
                                </div>

                                <div class="row padding-y-2">
                                    <div class="col-lg-5 text-md-1">
                                        <div class='d-flex justify-content-end '>
                                            <div class='fweight-700 text-right'>Kuitansi</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <select name="templating_lampiran[bon]">
                                            <option value="Ada bon">Ada Bon</option>
                                            <option value="Tidak ada">Tidak ada</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group padding-x-5 margin-top-7">
                                    <label for="first-name-column">Upload Bukti Transaksi/Bon <sup>Opsional</sup></label>
                                    <div class="file-loading">
                                        <input id="fileUpload" name="bukti_file[]" type="file" data-browse-on-zone-click="true" class="file" multiple>
                                    </div>
                                    <i class='text-muted'>Upload bukti transaksi jika diperlukan</i>
                                </div>
                            </div>

                            <div class="col-lg-12 margin-top-9">
                                <br />
                                <h4 class="text-center">Rincian Bukti Transaksi </h4>


                                <div class='margin-top-5'>

                                    <table class='table table-borderless'>
                                        <thead>
                                            <tr class='fweight-700'>
                                                <td class='text-muted text-center'>No</td>
                                                <td class='text-muted padding-left-5'>Tanggal</td>
                                                <td class='text-muted padding-left-5' style='text-align:left;'>Uraian</td>
                                                <td class='text-muted padding-left-5' style='text-align:left;'>Jumlah</td>
                                                <td class='text-muted padding-left-5' style='text-align:left;'>Satuan</td>
                                                <td class='text-muted padding-right-5' style='text-align:right;'>Harga Satuan</td>
                                                <td class='text-muted padding-right-5' style='text-align:right; width:15%'>Total</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id='tbody-rincian-bukti'>
                                            <?php
                                            $totalHarga = 0;
                                            if (isset($templateLampiran->tanggal) && count($templateLampiran->tanggal) > 0) :
                                                $total = 0;
                                                foreach ($templateLampiran->tanggal as $key => $list) :
                                                    $total = str_replace('.', '', $templateLampiran->harga_satuan[$key]);
                                                    $totalHarga += str_replace('.', '', $templateLampiran->harga_satuan[$key]);

                                            ?>
                                                    <tr class='box-shadow'>
                                                        <td class='padding-3 text-center  nomor-rincian'>1</td>
                                                        <td class='padding-3'><input type='text' name='templating_lampiran[tanggal][]' value="<?= $list ?? '' ?>" class='form-control no-border text-muted datelightpick-tanggal' placeholder='Tanggal'></td>
                                                        <td class='padding-3'><input type='text' name='templating_lampiran[uraian][]' value="<?= $templateLampiran->uraian[$key] ?? '' ?>" class='form-control no-border text-muted' placeholder='Uraian'></td>
                                                        <td class='padding-3'><input type='number' name='templating_lampiran[jumlah][]' value="<?= $templateLampiran->jumlah[$key] ?? '1' ?>" class='form-control jumlah-perrincian no-border text-muted' placeholder='Jumlah'></td>
                                                        <td class='padding-3'>
                                                            <select name='templating_lampiran[satuan][]' class='form-select'>
                                                                <option value="bon">Bon</option>
                                                            </select>
                                                        </td>
                                                        <td class="padding-3">
                                                            <input type='text' dir="rtl" name='templating_lampiran[harga_satuan][]' value="<?= $templateLampiran->harga_satuan[$key] ?? '' ?>" class='form-control currency-number currency-number harga_satuan no-border' placeholder='Nominal'>
                                                        </td>
                                                        <td class="padding-3 total_row_rincian" style='text-align:right'><?= number_format($total, 0, ',', '.') ?></td>

                                                        <td class='padding-3 text-center'>
                                                            <button class='no-border no-background text-muted padding-x-1 hapus-rincian-bukti d-flex align-items-center justify-content-center padding-top-1 w-100'>
                                                                <span class='material-icons-outlined'>
                                                                    highlight_off
                                                                </span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            <?php else : ?>
                                                <tr class='box-shadow'>
                                                    <td class='padding-3 text-center  nomor-rincian'>1</td>
                                                    <td class='padding-3'><input type='text' name='templating_lampiran[tanggal][]' class='form-control no-border text-muted datelightpick-tanggal' placeholder='Tanggal'></td>
                                                    <td class='padding-3'><input type='text' name='templating_lampiran[uraian][]' class='form-control no-border text-muted' placeholder='Uraian'></td>
                                                    <td class='padding-3'><input type='number' name='templating_lampiran[jumlah][]' value='1' class='form-control jumlah-perrincian no-border text-muted' placeholder='Jumlah'></td>
                                                    <td class='padding-3'>
                                                        <select name='templating_lampiran[satuan][]' class='form-select'>
                                                            <option value="bon">Bon</option>
                                                        </select>
                                                    </td>
                                                    <td class="padding-3">
                                                        <input type='text' dir="rtl" name='templating_lampiran[harga_satuan][]' class='form-control currency-number currency-number harga_satuan no-border' placeholder='Nominal'>
                                                    </td>
                                                    <td class="padding-3 total_row_rincian" style='text-align:right'>0</td>

                                                    <td class='padding-3 text-center'>
                                                        <button class='no-border no-background text-muted padding-x-1 hapus-rincian-bukti d-flex align-items-center justify-content-center padding-top-1 w-100'>
                                                            <span class='material-icons-outlined'>
                                                                highlight_off
                                                            </span>
                                                        </button>
                                                    </td>
                                                </tr>

                                            <?php endif; ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class='text-center fweight-700 text-md-2' colspan=6>Jumlah Biaya</td>
                                                <td class='text-center fweight-700'>
                                                    <div class=' d-flex justify-content-between'>
                                                        <div>Rp.</div>
                                                        <div id='total-rincian-bukti'><?= number_format($totalHarga, 0, ',', '.') ?></div>
                                                    </div>
                                                </td>

                                            </tr>
                                        </tfoot>
                                    </table>


                                    <div class='margin-top-2'>
                                        <button class='btn btn-primary padding-y-2 fweight-700 btn-block d-flex align-items-center justify-content-center' id='templating-lampiran-tambah-rincian'>
                                            <span class='material-icons-outlined'>
                                                add
                                            </span>
                                            <div class='margin-left-2'>Tambah Baris Rincian</div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

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

<script src="<?= base_url('template/vendors/kartik-upload/piexif.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/kartik-upload/sortable.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/kartik-upload/custom_fileinput.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/kartik-upload/theme.js') ?>"></script>

<script src="<?= base_url('js/Pengajuan/UbahPengajuan.js') ?>"></script>
<script src="<?= base_url('js/Pengajuan/LampiranPengajuan.js') ?>"></script>

<?= $this->endSection() ?>