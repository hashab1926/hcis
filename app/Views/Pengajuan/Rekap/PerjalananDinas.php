<?= $this->section('css_files') ?>
<style>
    .autocomplete-search {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        display: none;
        min-width: 40vw;
        padding: .5rem 0;
        margin-top: .125rem;
        font-size: 1rem;
        height: 40vh;
        color: #607080;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border-radius: 20px !important;
        overflow: auto;
    }

    .autocomplete-search .item {
        display: block;
        width: 100%;
        padding: .60rem 1rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        text-decoration: none;
        white-space: nowrap;
        background-color: transparent;
        border-left: 5px solid transparent;


    }

    .autocomplete-search .item:hover {
        background: #ebe9f1;
        cursor: pointer;
        border-left: 5px solid rgb(67, 94, 190);
        border-radius: 5px;
    }

    .autocomplete-search .item .item-icon {
        margin-right: 10px;
    }

    .autocomplete-search .item .item-text {
        color: #777;
    }

    .autocomplete-search .item .item-icon .material-icons-outlined {
        color: #777;
    }
</style>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->extend('Layout/Page') ?>
<?= $this->section('content') ?>
<div class="row margin-top-3">
    <div class="col">
        <div class="d-flex flex-column  text-center">
            <div class='fweight-500 text-lg-1 text-dark'>Rekapitulasi Perjalanan Dinas</div>
            <p class='text-muted text-md-2'>Cari karyawan yang telah mengajukan perjalanan dinas disini</p>
        </div>
        <div class='margin-top-7 margin-bottom-7'>

            <div class="form-group d-flex justify-content-center">
                <div class="input-group w-50">
                    <input type="text" class="box-shadow form-control custom-input-height border-radius padding-x-4" id="cari-karyawan" placeholder="Cari karyawan">

                    <div class="autocomplete-search " aria-labelledby="dropdownMenuButton">
                        <div class="item d-flex align-content-center" href="#">
                            <div class='item-icon'>
                                <span class="material-icons-outlined icon-lg-title">
                                    person_outline
                                </span>
                            </div>
                            <div class='d-flex flex-column'>
                                <div class='item-text fweight-700'>Albert Foundation</div>
                                <div class='subitem-text text-sm-4 text-muted'><?= 1922398 ?></div>
                            </div>
                        </div>

                        <div class="item d-flex align-content-center" href="#">
                            <div class='item-icon'>
                                <span class="material-icons-outlined icon-lg-title">
                                    person_outline
                                </span>
                            </div>
                            <div class='d-flex flex-column'>
                                <div class='item-text fweight-700'>Albert Foundation</div>
                                <div class='subitem-text text-sm-4 text-muted'><?= 1922398 ?></div>
                            </div>
                        </div>

                        <div class="item d-flex align-content-center" href="#">
                            <div class='item-icon'>
                                <span class="material-icons-outlined icon-lg-title">
                                    person_outline
                                </span>
                            </div>
                            <div class='d-flex flex-column'>
                                <div class='item-text fweight-700'>Albert Foundation</div>
                                <div class='subitem-text text-sm-4 text-muted'><?= 1922398 ?></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col">
                    <div class="w-25 mx-auto">
                        <div class="form-group">
                            <label for="">Pilih divisi</label>
                            <select name="id_divisi" data-name="id_divisi" class="w-100" id="id_divisi"></select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex justify-content-center flex-wrap margin-top-5">
                <div class=" w-100 d-flex justify-content-center">
                    <div class='d-flex align-items-center'>
                        <div class='margin-top-4 margin-right-3'>Dari Bulan &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </div>
                        <input type="month" class='form-control border-radius custom-input-height box-shadow' name='tgl_awal'>
                    </div>

                    <div class='d-flex align-items-center margin-left-5 '>
                        <div class='margin-top-4 margin-right-3'>Sampai &nbsp; &nbsp; &nbsp; </div>
                        <input type="month" class='form-control border-radius custom-input-height box-shadow' name='tgl_akhir'>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col text-center d-flex justify-content-center">
                    <button class='btn btn-primary btn-lg d-flex align-items-center' id='cari'>
                        <span class="material-icons-outlined">
                            search
                        </span>
                        <div>Cari </div>
                    </button>
                </div>
            </div>
        </div>
        <Br /><br />

        <img src="<?= base_url('img/undraw-pedin.svg') ?>" width="500">
    </div>
</div>

<div id='tipe-pengajuan' data-type='perdin'></div>
<?= $this->endSection() ?>

<?= $this->section('js_files'); ?>
<script src="<?= base_url('template/vendors/select2/select2.min.js') ?>"></script>

<script src="<?= base_url('js/Rekap/DataRekap.js') ?>"></script>
<script src="<?= base_url('js/Karyawan/KaryawanSelect2.js') ?>"></script>
<?= $this->endSection() ?>