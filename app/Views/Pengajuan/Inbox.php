<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
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

    .dropdown-item {
        padding-left: 0.5rem;
        padding-right: 0.5rem;

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
                    <th class='padding-x-7 '>
                        <div class="dropdown">
                            <span class="dropdown-toggle d-flex align-items-center" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="material-icons-outlined" style="opacity:0.8; border-right:0;">
                                    filter_alt
                                </div>
                                <div>Status</div>

                            </span>
                            <div class="dropdown-menu text-muted" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item filter-pengajuan d-flex align-items-center" href="#" data-value="">
                                    <span class="material-icons-outlined">format_list_bulleted</span>
                                    <div class="margin-left-2">Semua</div>
                                </a>
                                <a class="dropdown-item filter-pengajuan d-flex align-items-center" href="#" data-value="proses">
                                    <span class="material-icons-outlined">loop</span>
                                    <div class="margin-left-2">Sedang diproses</div>
                                </a>
                                <a class="dropdown-item filter-pengajuan d-flex align-items-center" href="#" data-value="tolak">
                                    <span class="material-icons-outlined">highlight_off</span>
                                    <div class="margin-left-2">Tolak</div>
                                </a>
                                <a class="dropdown-item filter-pengajuan d-flex align-items-center" href="#" data-value="acc">
                                    <span class="material-icons-outlined ">how_to_reg</span>
                                    <div class="margin-left-2">Acc</div>
                                </a>
                                <a class="dropdown-item filter-pengajuan d-flex align-items-center" href="#" data-value="selesai">
                                    <span class="material-icons-outlined">verified</span>
                                    <div class="margin-left-2">Selesai</div>
                                </a>

                            </div>
                        </div>

                    </th>
                    <th class='padding-x-5'>Waktu</th>

                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalFilter" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role=" document">
        <div class="modal-content">
            <div class="modal-header no-border">
                <h5 class="modal-title">Filter Berdasarkan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js_files') ?>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('js/Pengajuan/DataPengajuanInbox.js') ?>"></script>
<?= $this->endSection() ?>