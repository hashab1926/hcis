<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <?= $this->include('Provinsi/Menu') ?>
        <div class="card" style="border-top-left-radius:0;">
            <div class="card-body padding-x-1">
                <div class="table-responsive">
                    <table id="datatable" class="table strip-table" style="width:100%">
                        <thead class='border-radius-sm' style='background:#f2f4fd'>
                            <tr class='rounded-pill-row padding-row'>
                                <th width=4%>
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class=" hover-pointer form-check-input form-check-primary form-check-glow" name="checkbox_all">
                                            <label class="form-check-label" for="checkbox_all"></label>
                                        </div>
                                    </div>
                                </th>
                                <th>PROVINSI </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TOOLBAR TABLE -->
<?= view_cell('App\Libraries\Widget\Toolbar::toolbarTable', ['except' => ['detail', 'buat_akun']]); ?>
<!-- TOOLBAR TABLE -->

<?= $this->endSection() ?>

<?= $this->section('js_files') ?>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('js/Provinsi/DataProvinsi.js') ?>"></script>
<script src="<?= base_url('js/Provinsi/HapusProvinsi.js') ?>"></script>
<script src="<?= base_url('js/Provinsi/UbahProvinsi.js') ?>"></script>
<script src="<?= base_url('js/CheckboxDatatable.js') ?>"></script>
<?= $this->endSection() ?>