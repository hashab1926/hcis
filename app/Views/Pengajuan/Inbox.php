<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<style>
    table {
        border-spacing: 0 0.8em !important;
        border-collapse: separate !important;
    }

    .dataTable-table:not(.table-borderless) thead th,
    .table:not(.table-borderless) thead th {
        border: none !important;
    }

    table tbody tr td:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;

    }

    table tbody tr td:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;

    }

    table.dataTable>thead .sorting:after,
    table.dataTable>thead .sorting:before {
        display: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">


        <table id="datatable" class="table table-hover" style="width:100%">
            <thead class='border-radius-sm'>
                <tr>
                    <th class='padding-x-5'>Pengajuan</th>
                    <th class='padding-x-5'>Jenis Pengajuan</th>
                    <th class='padding-x-7'>Status</th>
                    <th class='padding-x-5'>Waktu</th>

                </tr>
            </thead>
        </table>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('js_files') ?>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('js/Pengajuan/DataPengajuanInbox.js') ?>"></script>
<?= $this->endSection() ?>