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
$input = $_GET;
$jenisPengajuan = $input['jenis_pengajuan'] ?? null;
if (!empty($jenisPengajuan)) : ?>
    <div class="row margin-bottom-5">
        <div class="col d-flex justify-content-center ">
            <div id='preview-pdf'>
            </div>
        </div>
    </div>

<?php endif; ?>


<!-- TOOLBAR TABLE -->
<?= view_cell('App\Libraries\Widget\Toolbar::toolbarTemplate'); ?>
<!-- TOOLBAR TABLE -->

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