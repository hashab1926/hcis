<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <div class="card" style="border-top-left-radius:0;">
            <div class="card-body padding-x-1">

                <table id="datatable" class="table strip-table" style="width:100%">
                    <thead class='border-radius-sm' style='background:#f2f4fd'>
                        <tr>
                            <th class='padding-left-5'>Nomor</th>
                            <th class='padding-left-5'>Divisi</th>
                            <th class='padding-left-5'>Kas Jurnal</th>
                            <th class='padding-left-5'>Cost Center</th>
                            <th class='padding-left-5'>Aksi</th>

                        </tr>
                    </thead>
                </table>
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
<script src="<?= base_url('js/Rekap/DataFbcj.js') ?>"></script>
<?= $this->endSection() ?>