<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <?= $this->include('UnitKerja/Bagian/Menu') ?>
        <div class="" style="border-top-left-radius:0;">
            <div class="card-body padding-x-1 pt-0">
                <form id="bagian-updatestore">
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
                                                    <label class='fweight-700'>Unit Divisi </label>
                                                    <select name="id_divisi[<?= $list->id ?>]" id="<?= $list->id ?>" data-name="id_divisi" data-selected="<?= $list->kode_divisi . ' - ' . $list->nama_divisi ?>" class="w-100"></select>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-12 margin-top-2'>
                                                    <label class='fweight-700'>Kode Bagian</label>
                                                    <div class="text-muted"><input type='text' placeholder='Kode unit' name="kode_bagian[<?= $list->id ?>]" class='form-control custom-input-height' value="<?= $list->kode_bagian ?>" /></div>
                                                </div>
                                                <div class='col-12 margin-top-4'>
                                                    <label class='fweight-700'>Nama Unit bagian </label>
                                                    <input type="text" placeholder="Nama Unit" name="nama_bagian[<?= $list->id ?>]" class='form-control custom-input-height' value="<?= $list->nama_bagian ?>">
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
<script src="<?= base_url('js/UnitKerja/Bagian/UbahBagianSelect2.js') ?>"></script>
<script src="<?= base_url('js/UnitKerja/Bagian/UbahBagian.js') ?>"></script>

<?= $this->endSection() ?>