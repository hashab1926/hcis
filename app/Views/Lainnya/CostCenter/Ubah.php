<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <?= $this->include('Lainnya/CostCenter/Menu') ?>
        <div class="" style="border-top-left-radius:0;">
            <div class="card-body padding-x-1 pt-0">
                <form id="costcenter-updatestore">
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
                                                    supervised_user_circle
                                                </span>
                                            </div>
                                            <!-- ICON -->

                                            <div class='row'>
                                                <div class='col-lg-6 col-xl-6 col-xs-12 col-md-12 margin-top-2'>
                                                    <label class='fweight-700'>Kode Cost Center</label>
                                                    <div class="text-muted"><input type='text' name="kode_cost_center[<?= $list->id ?>]" class='form-control custom-input-height' value="<?= $list->kode_cost_center ?>" /></div>
                                                </div>

                                                <div class='col-lg-6 col-xl-6 col-xs-12 col-md-12 margin-top-2'>
                                                    <label class='fweight-700'>Nama</label>
                                                    <div class="text-muted"><input type='text' name="nama_cost_center[<?= $list->id ?>]" class='form-control custom-input-height' value="<?= $list->nama_cost_center ?>" /></div>
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
<script src="<?= base_url('js/Lainnya/CostCenter/UbahCostCenter.js') ?>"></script>

<?= $this->endSection() ?>