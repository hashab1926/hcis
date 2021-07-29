<?= $this->extend('Layout/Page') ?>
<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/sidebar-right.css') ?>">
<link rel="stylesheet" href="<?= base_url('template/vendors/LightPick/lightpick.css') ?>">
<style>
    table.table-bordered>thead>tr>th {
        border: 1px solid blue;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
if ($status_code == 100) : ?>
    <div class="row">
        <div class="col text-center">
            <span class="material-icons-outlined text-muted icon-xxl-title">
                assignment
            </span>
            <div class='text-muted text-md-2'><?= $message ?></div>
        </div>
    </div>


<?php
elseif ($status_code != 200) : ?>
    <div class="row">
        <div class="col text-center">
            <h4>
                Sedang terjadi masalah
            </h4>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>



<?= $this->section('js_files') ?>
<script src="<?= base_url('template/vendors/select2/select2.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/pdfJS/build/pdf.js') ?>"></script>
<script src="<?= base_url('template/vendors/pdfJS/SettingPdf.js') ?>"></script>
<script src="<?= base_url('template/vendors/LightPick/moment.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/LightPick/lightpick.js') ?>"></script>
<script src="<?= base_url('template/vendors/JqueryMask/jquery.mask.min.js') ?>"></script>

<script src="<?= base_url('js/Pengajuan/PengajuanSelect2.js') ?>"></script>
<script src="<?= base_url('js/Pengajuan/TambahPengajuan.js') ?>"></script>

<?= $this->endSection() ?>