<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <?= $this->include('UnitKerja/Divisi/Menu') ?>
        <div class="" style="border-top-left-radius:0;">
            <div class="card-body padding-x-1 pt-0">
                <form id="divisi-updatestore">
                    <div class="row">
                        <?php
                        $col = count($data) >= 3 ? 'col-lg-4' : 'col-lg-4';
                        foreach ($data as $list) :
                        ?>
                            <div class="<?= $col ?>">
                                <div class="card box-shadow">
                                    <div class="card-body">
                                        <div class='d-flex flex-column '>
                                            <!-- ICON -->
                                            <div class='text-center'>
                                                <span class="material-icons-outlined text-muted" style="font-size:150px">
                                                    account_tree
                                                </span>
                                            </div>
                                            <!-- ICON -->
                                            <div class="col-12 padding-bottom-1 margin-top-4">
                                                <div class="form-group">
                                                    <label for="first-name-column">Kepala / Direktur </label>
                                                    <select name="id_kepala[<?= $list->id ?>]" data-name="id_kepala" class="w-100"></select>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-12 margin-top-2'>
                                                    <label class='fweight-700'>Kode Unit</label>
                                                    <div class="text-muted"><input type='text' placeholder='Kode unit' name="kode_divisi[<?= $list->id ?>]" class='form-control custom-input-height' value="<?= $list->kode_divisi ?>" /></div>
                                                </div>
                                                <div class='col-12 margin-top-4'>
                                                    <label for="first-name-column">Nama Unit </label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Nama Unit" name="nama_divisi[<?= $list->id ?>]" class='form-control custom-input-height' value="<?= $list->nama_divisi ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">
                                                                <input type="text" class="form-control" name="singkatan[<?= $list->id ?>]" value="<?= $list->singkatan ?>" placeholder="Singkatan / Alias" name="singkatan" oninput="this.value = this.value.toUpperCase()">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <!-- BTN SIMPAN -->
                    <div class='position-fixed' style="bottom:50px; right:35px;">
                        <button class='btn btn-primary d-flex align-items-center padding-x-4 padding-y-3 rounded-pill box-shadow' type="submit" name="ubah">
                            <span class="material-icons-outlined">
                                edit
                            </span>
                            <div class='margin-left-2 fweight-700'>Terapkan</div>
                        </button>
                    </div>
                    <!-- BTN SIMPAN -->
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('js_files') ?>
<script src="<?= base_url('template/vendors/select2/select2.min.js') ?>"></script>
<script src="<?= base_url('js/UnitKerja//Divisi/DivisiSelect2.js') ?>"></script>
<script src="<?= base_url('js/UnitKerja/Divisi/UbahDivisi.js') ?>"></script>

<?= $this->endSection() ?>