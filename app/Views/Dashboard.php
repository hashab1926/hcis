<?php
$library = new \App\Libraries\Library;
?>
<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<style>
    .stats-icon {
        float: none;
    }
</style>
<?= $this->endSection() ?>

<?php if (isset($login) == 'dir') : ?>
    <?= $this->section('content') ?>

    <div class="page-heading">
        <h3>Bulan ini</h3>
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class='text-center'>Perjalanan Dinas</h6>
                        <div class="row">
                            <div class="col-lg-4">



                                <div class='d-flex flex-column text-sm-4'>
                                    <div>Luar kota</div>
                                    <div>Rp.<?= number_format($total_perdin['total_perdinluarkota_bulanini'], 0, ',', '.') ?></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class='d-flex flex-column text-sm-4'>
                                    <div>Dalam kota</div>
                                    <div>Rp.<?= number_format($total_perdin['total_perdindalamkota_bulanini'], 0, ',', '.') ?></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class='d-flex flex-column text-sm-4'>
                                    <div>Luar Negri</div>
                                    <div>Rp.<?= number_format($total_perdin['total_perdinluarnegri_bulanini'], 0, ',', '.') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class='text-center'>FBCJ</h6>
                        <div class="row">
                            <div class="col">
                                <div class='text-md-2 fweight-600 text-center'>Rp.<?= number_format($total_fbcj['fbcj_bulanini'], 0, ',', '.') ?></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class='text-center'>Reimburse Faskom</h6>
                        <div class="row">
                            <div class="col">
                                <div class='text-md-2 fweight-600 text-center'>Rp.<?= number_format($total_faskom['total_perdinluarkota_bulanini'], 0, ',', '.') ?></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="page-heading">
        <h3>Hari ini</h3>
    </div>

    <section class="row">
        <div class="col-12 col-lg-8">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body padding-x-2 py-4-5">
                            <div class="row">
                                <div class="col-md-3 col-12 d-flex justify-content-end">
                                    <div class="stats-icon no-background">
                                        <div class="material-icons-outlined d-lg-block d-xl-block icon-title" style='font-size:25px !important;'>
                                            badge
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 col-12">
                                    <h6 class="text-muted font-semibold">Semua Pengajuan</h6>
                                    <h6 class="font-extrabold mb-0"><?= $pengajuan_harini['semua_pengajuan'] ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body padding-x-2 py-4-5">
                            <div class="row">
                                <div class="col-md-3 d-flex justify-content-end">
                                    <div class="stats-icon no-background">
                                        <span class="material-icons-outlined d-lg-block d-xl-block icon-title" style='font-size:25px !important;'>
                                            dashboard
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h6 class="text-muted font-semibold">Perjalanan Dinas</h6>
                                    <h6 class="font-extrabold mb-0"><?= $pengajuan_harini['perjalanan_dinas'] ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body padding-x-2 py-4-5">
                            <div class="row">
                                <div class="col-md-3 d-flex justify-content-end">
                                    <div class="stats-icon no-background">
                                        <span class="material-icons-outlined d-lg-block d-xl-block icon-title" style='font-size:25px !important;'>emoji_transportation</span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h6 class="text-muted font-semibold">Perdin Luar Kota</h6>
                                    <h6 class="font-extrabold mb-0"><?= $pengajuan_harini['perdin_luarkota'] ?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div>Rp.<?= number_format($total_perdin['total_perdinluarkota_hariini'], 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body padding-x-2 py-4-5">
                            <div class="row">
                                <div class="col-md-3 d-flex justify-content-end">
                                    <div class="stats-icon no-background">
                                        <span class="material-icons-outlined d-lg-block d-xl-block icon-title" style='font-size:25px !important;'>
                                            directions_car
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h6 class="text-muted font-semibold">Perdin Dalam Kota</h6>
                                    <h6 class="font-extrabold mb-0"><?= $pengajuan_harini['perdin_dalamkota'] ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div>Rp.<?= number_format($total_perdin['total_perdindalamkota_hariini'], 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body padding-x-2 py-4-5">
                            <div class="row">
                                <div class="col-md-3 d-flex justify-content-end">
                                    <div class="stats-icon no-background">
                                        <span class="material-icons-outlined d-lg-block d-xl-block icon-title" style='font-size:25px !important;'>
                                            flight_takeoff
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h6 class="text-muted font-semibold text-md-1">Perdin Luar Negri</h6>
                                    <h6 class="font-extrabold mb-0"><?= $pengajuan_harini['perdin_luarnegri'] ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div>Rp.<?= number_format($total_perdin['total_perdinluarnegri_hariini'], 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>


                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body padding-x-2 py-4-5">
                            <div class="row">
                                <div class="col-md-3 d-flex justify-content-end">
                                    <div class="stats-icon no-background ">
                                        <span class="material-icons-outlined d-lg-block d-xl-block icon-title" style='font-size:25px !important;'>paid</span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h6 class="text-muted font-semibold">Reimburse</h6>
                                    <h6 class="font-extrabold mb-0"><?= $pengajuan_harini['reimburse'] ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div>Rp.<?= number_format($total_faskom['total_perdinluarkota_bulanini'], 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body padding-x-2 py-4-5">
                            <div class="row">
                                <div class="col-md-3 d-flex justify-content-end">
                                    <div class="stats-icon no-background">
                                        <span class="material-icons-outlined d-lg-block d-xl-block icon-title" style='font-size:25px !important;'>
                                            hail
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h6 class="text-muted font-semibold">Cuti Karyawan</h6>
                                    <h6 class="font-extrabold mb-0"><?= $pengajuan_harini['cuti'] ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body padding-x-2 py-4-5">
                            <div class="row">
                                <div class="col-md-3 d-flex justify-content-end">
                                    <div class="stats-icon no-background">
                                        <span class="material-icons-outlined d-lg-block d-xl-block icon-title" style='font-size:25px !important;'>
                                            work
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h6 class="text-muted font-semibold">Lembur Karyawan</h6>
                                    <h6 class="font-extrabold mb-0"><?= $pengajuan_harini['lembur'] ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row margin-top-2">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Bulan ini</h5>
                        </div>
                        <div class="card-body">

                            <div>
                                <canvas id="chart-bulan-ini"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Konfirmasi Pengajuan</h4>
                    <div class="text-sm-3"><?= $total_belumapprove ?> Approve</div>
                </div>
                <div class="card-content pb-4">
                    <?php
                    if (count($list_konfirmasi) <= 0) :  ?>
                        <div class="row">
                            <div class="col text-center">
                                <div class='d-flex flex-column'>
                                    <span class="material-icons-outlined text-muted icon-lg-title">
                                        notifications
                                    </span>
                                    <div class='text-md-2 text-muted'>Belum Ada Notifikasi</div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php foreach ($list_konfirmasi as $list) : ?>
                        <div class="d-flex justify-content-between flex-wrap align-items-center hover-pointer-bg" onclick="document.location = 'pengajuan/detail/<?= $list->id ?>'">
                            <div>

                                <div class="recent-message d-flex px-4 py-3">
                                    <div class="avatar avatar-lg">
                                        <?= $library->iconNamaJenis($list->nama_jenis, 'text-muted') ?>
                                    </div>
                                    <div class="name margin-left-4">
                                        <h6 class="margin-bottom-1"><?= $library->namaJenisToView($list->nama_jenis) ?></h6>
                                        <div class="text-muted text-sm-4 fweight-400"><?= $list->nama_pengaju ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class='margin-right-5 text-muted text-sm-4'><?= $library->timeToText($list->created_at) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Tahun ini</h5>
                </div>
                <div class="card-body">
                    <div class="row margin-bottom-2">
                        <div class="col-12 col-lg-8 fweight-700 d-flex flex-wrap ">
                            <div class="material-icons-outlined d-none d-lg-block d-xl-block">
                                badge
                            </div>
                            <div class='margin-left-2'>Semua Pengajuan</div>
                        </div>
                        <div class="col fweight-700"><?= $pengajuan_tahunini['semua_pengajuan'] ?></div>
                    </div>
                    <div class="row margin-bottom-2">
                        <div class="col-6 col-lg-8 fweight-700 d-flex ">
                            <div class="material-icons-outlined d-none d-lg-block d-xl-block">
                                dashboard
                            </div>
                            <div class='margin-left-2'>Perjalanan Dinas</div>
                        </div>
                        <div class="col fweight-700"><?= $pengajuan_tahunini['perjalanan_dinas'] ?></div>
                    </div>
                    <div class="row margin-bottom-2">
                        <div class="col-6 col-lg-8 fweight-700 "></div>
                        <div class="col-6 col-lg-8 fweight-700 d-flex ">
                            <div class="material-icons-outlined d-none d-lg-block d-xl-block">
                                emoji_transportation
                            </div>
                            <div class='margin-left-2'>Perdin Luar Kota</div>
                        </div>
                        <div class="col fweight-700"><?= $pengajuan_tahunini['perdin_luarkota'] ?></div>
                    </div>
                    <div class="row margin-bottom-2">
                        <div class="col-6 col-lg-8 fweight-700 d-flex ">
                            <div class="material-icons-outlined d-none d-lg-block d-xl-block">
                                directions_car
                            </div>
                            <div class='margin-left-2'>Perdin Dalam kota</div>
                        </div>
                        <div class="col fweight-700"><?= $pengajuan_tahunini['perdin_dalamkota'] ?></div>
                    </div>
                    <div class="row margin-bottom-2">
                        <div class="col-6 col-lg-8 fweight-700 d-flex ">
                            <div class="material-icons-outlined d-none d-lg-block d-xl-block">
                                flight_takeoff
                            </div>
                            <div class='margin-left-2'>Perdin Luar negri</div>
                        </div>
                        <div class="col fweight-700"><?= $pengajuan_tahunini['perdin_luarnegri'] ?></div>
                    </div>
                    <div class="row margin-bottom-2">
                        <div class="col-6 col-lg-8 fweight-700 d-flex ">
                            <div class="material-icons-outlined d-none d-lg-block d-xl-block">
                                paid
                            </div>
                            <div class='margin-left-2'>Reimburse</div>
                        </div>
                        <div class="col fweight-700"><?= $pengajuan_tahunini['reimburse'] ?></div>
                    </div>
                    <div class="row margin-bottom-2">
                        <div class="col-6 col-lg-8 fweight-700 d-flex ">
                            <div class="material-icons-outlined d-none d-lg-block d-xl-block">
                                hail
                            </div>
                            <div class='margin-left-2'>Cuti Karyawan</div>
                        </div>
                        <div class="col fweight-700"><?= $pengajuan_tahunini['cuti'] ?></div>
                    </div>
                    <div class="row margin-bottom-2">
                        <div class="col-6 col-lg-8 fweight-700 d-flex ">
                            <div class="material-icons-outlined d-none d-lg-block d-xl-block">
                                work
                            </div>
                            <div class='margin-left-2'>Lembur Karyawan</div>
                        </div>
                        <div class="col fweight-700"><?= $pengajuan_tahunini['lembur'] ?></div>
                    </div>


                </div>
            </div>

        </div>

    </section>
    </div>

    <?= $this->endSection() ?>
<?php endif; ?>

<?= $this->section('js_files') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"></script>
<script src="<?= base_url('js/Dashboard.js') ?>"></script>
<?php if (isset($login) == 'dir') : ?>
    <script>
        var ctx = document.getElementById('chart-bulan-ini');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Perdin Luar kota', 'Perdin Dalam kota', 'Perdin Luar negri', 'Reimburse', 'Cuti Karyawan', 'Lembur Karyawan'],
                datasets: [{
                    label: '',
                    data: [<?= $pengajuan_bulanini ?>],
                    backgroundColor: [
                        '#6f42c1',
                        '#fd7e14',
                        '#dc3545',
                        '#435ebe',
                        '#343a40',
                        '#435ebe'
                    ],
                    borderColor: [
                        '#6f42c1',
                        '#fd7e14',
                        '#dc3545',
                        '#435ebe',
                        '#343a40',
                        '#435ebe'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
<?php endif; ?>
<?= $this->endSection(); ?>